<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\customer;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Models\Module;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CustomerExport;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $sortField = $request->get('sort', 'id'); // Campo por defecto
        $sortDirection = $request->get('direction', 'asc'); // Dirección por defecto

        // Validar los campos de ordenamiento para evitar inyecciones SQL
        $validSortFields = ['id', 'national_id', 'name', 'phone', 'email', 'address'];
        if (!in_array($sortField, $validSortFields)) {
            $sortField = 'id';
        }

        $customers = customer::orderBy($sortField, $sortDirection)->get();

        return view('modules.customers.index', compact('customers', 'sortField', 'sortDirection'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'national_id' => 'required|string|max:20|unique:customers',
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'email' => 'required|string|email|max:255|unique:customers',
            'address' => 'required|string|max:255',
        ]);

        // Obtener el último cliente basado en el id
        $lastCustomer = Customer::orderBy('id', 'desc')->first();

        // Extraer el número del id y convertirlo a entero
        $lastIdNumber = $lastCustomer ? intval($lastCustomer->id) : 0;

        // Incrementar el número para el nuevo ID
        $newId = $lastIdNumber + 1;

        $customer = Customer::create([
            'id' => $newId,
            'national_id' => $request->national_id,
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address,
        ]);

        return redirect()->route('customers.index')->with('success', 'Cliente agregado correctamente.');
    }

    public function update(Request $request, $id)
    {
        $customer = Customer::findOrFail($id);

        $request->validate([
            'national_id' => 'required|string|max:20',
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'email' => 'required|string|email|max:255',
            'address' => 'required|string|max:255',
        ]);

        $customer->update($request->all());

        return redirect()->route('customers.index')->with('success', 'Cliente actualizado correctamente.');
    }

    public function destroy($id)
    {
        $customer = customer::findOrFail($id);
        $customer->delete();

        return redirect()->route('customers.index')->with('success', 'Estudiante eliminado correctamente.');
    }

    public function deleteAll(Request $request)
    {
        $ids = $request->ids;

        // Validar que los IDs sean un array y no estén vacíos
        if (!is_array($ids) || empty($ids)) {
            return response()->json(["error" => "No se han seleccionado estudiantes."]);
        }

        // Eliminar los clientes seleccionados
        $customers = customer::whereIn('id', $ids)->get();
        foreach ($customers as $customer) {
            $customer->delete();
        }

        return response()->json(["success" => "Estudiantes seleccionados eliminados exitosamente."]);
    }

    public function generatePDF()
    {

        $customers = customer::all();
        $date = date('d/m/Y H:i:s');


        $data = [

            'title' => 'Registros de Clientes',
            'date' => date('d/m/Y H:i:s'),
            'customers' => $customers
        ];

        $pdf = PDF::loadView('modules.customers.pdf', $data);
        $pdfName = "Clientes - {$date}.pdf";


        return $pdf->download($pdfName);
    }

    public function exportExcel()
    {
        $date = date('d-m-Y H:i:s');;
        $excelName = "Clientes {$date}.xlsx";
        return Excel::download(new CustomerExport, $excelName);
    }
}
