<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\Customer;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SalesExport;
use Illuminate\Support\Facades\DB;


class SaleController extends Controller
{
    public function index()
    {
        $sales = Sale::with('customer', 'employee')->orderByDesc('sale_date')->get();
        $customers = \App\Models\Customer::all();
        $items = \App\Models\Item::all(); // Para el modal de venta
    
        return view('modules.sales.index', compact('sales', 'customers', 'items'));
    }
    
    public function create()
    {
        $customers = Customer::all();
        $items = Item::all();
        return view('modules.sales.create', compact('customers', 'items'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'payment_method' => 'required|string|max:255',
            'products' => 'required|array|min:1',
            'products.*.product_id' => 'required|exists:items,id_item',
            'products.*.quantity' => 'required|integer|min:1',
            'products.*.unit_price' => 'required|numeric|min:0',
        ]);

        $total = collect($request->products)->sum(function ($item) {
            return $item['quantity'] * $item['unit_price'];
        });

        $sale = Sale::create([
            'sale_date' => now(),
            'total' => $total,
            'payment_method' => $request->payment_method,
            'customer_id' => $request->customer_id,
            'employee_id' => Auth::id(),
            'comments' => $request->comments,
        ]);

        foreach ($request->products as $product) {
            SaleDetail::create([
                'sale_id' => $sale->id,
                'product_id' => $product['product_id'],
                'quantity' => $product['quantity'],
                'unit_price' => $product['unit_price'],
                'subtotal' => $product['quantity'] * $product['unit_price'],
            ]);
        }

            // Rebajar stock del producto
        $item = Item::find($product['product_id']);
        if ($item) {
            $item->stock -= $product['quantity'];
            $item->save();
        }

        $lowStockItems = Item::where('stock', '<=', 5)->get();

        if ($lowStockItems->count() > 0) {
            $alertList = $lowStockItems->pluck('name')->implode(', ');
            session()->flash('warning', "⚠️ Atención: los siguientes productos tienen 5 unidades o menos: $alertList.");
        }

        return redirect()->route('sales.index')->with('success', 'Venta registrada correctamente.');
    }

    public function exportPDF()
    {
        $sales = Sale::with('customer', 'employee', 'saleDetails')->get();
        $pdf = Pdf::loadView('modules.sales.pdf', compact('sales'));
        return $pdf->download('ventas.pdf');
    }

    public function exportExcel()
    {
        return Excel::download(new SalesExport, 'ventas.xlsx');
    }

    public function generatePdf($id)
    {
        $sale = Sale::with('customer', 'employee', 'saleDetails.product')->findOrFail($id);

        // Marcamos como generado (esto evita futuros edits)
        $sale->pdf_generated = true;
        $sale->save();

        $pdf = \PDF::loadView('modules.sales.pdf', ['sale' => $sale]);

        $filename = "Venta-{$sale->id}.pdf";
        return $pdf->download($filename);
    }

    public function getSaleDetails($id)
    {
        $sale = Sale::with('saleDetails')->findOrFail($id);
        return response()->json($sale->saleDetails);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'payment_method' => 'required|string|max:255',
            'comments' => 'nullable|string',
            'products' => 'required|array|min:1',
            'products.*.product_id' => 'required|string|exists:items,id_item',
            'products.*.quantity' => 'required|integer|min:1',
            'products.*.unit_price' => 'required|numeric|min:0',
        ]);
    
        DB::beginTransaction();
    
        try {
            $sale = Sale::findOrFail($id);
    
            // Actualiza los campos de la venta
            $sale->update([
                'customer_id' => $request->customer_id,
                'payment_method' => $request->payment_method,
                'comments' => $request->comments,
                'total' => collect($request->products)->sum(fn($p) => $p['quantity'] * $p['unit_price']),
            ]);
    
            // Elimina los detalles actuales
            $sale->saleDetails()->delete();
    
            // Crea los nuevos detalles
            foreach ($request->products as $product) {
                SaleDetail::create([
                    'sale_id' => $sale->id,
                    'product_id' => $product['product_id'],
                    'quantity' => $product['quantity'],
                    'unit_price' => $product['unit_price'],
                    'subtotal' => $product['quantity'] * $product['unit_price'],
                ]);
            }
    
            DB::commit();
    
            return redirect()->route('sales.index')->with('success', 'Registro de venta actualizado correctamente.');
    
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error al actualizar la venta: ' . $e->getMessage());
        }
    }

} 

