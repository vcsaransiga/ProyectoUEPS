<?php

namespace App\Exports;

use App\Models\Sale;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SalesExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Sale::with('customer', 'employee')->get()->map(function ($sale) {
            return [
                'ID' => $sale->id,
                'Cliente' => $sale->customer->name ?? '',
                'Empleado' => $sale->employee->name ?? '',
                'Fecha' => $sale->sale_date,
                'Total' => $sale->total,
                'Método de Pago' => $sale->payment_method,
                'Comentarios' => $sale->comments,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'ID',
            'Cliente',
            'Empleado',
            'Fecha',
            'Total',
            'Método de Pago',
            'Comentarios',
        ];
    }
}
