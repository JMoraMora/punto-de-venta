<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $query = Sale::query();

        if ($request->has('start_date') && $request->has('end_date')) {
            $start_date = $request->start_date;
            $end_date = $request->end_date . ' 23:59:59';
            $query->whereBetween('created_at', [$start_date, $end_date]);
        }

        $sales = $query->get();

        return view('reports.sales', compact('sales'));
    }

    public function export(Request $request)
    {
        $format = $request->query('format', 'csv');

        $query = Sale::query();

        if ($request->has('start_date') && $request->has('end_date')) {
            $start_date = $request->start_date;
            $end_date = $request->end_date . ' 23:59:59';
            $query->whereBetween('created_at', [$start_date, $end_date]);
        }

        $sales = $query->get();

        if ($format === 'json') {
            return response()->json($sales);
        } else {
            $delimiter = '|';
        }

        $response = new StreamedResponse(function() use ($sales, $delimiter) {
            $handle = fopen('php://output', 'w');

            fputcsv($handle, [
                'Código', 'Nombre cliente', 'Identificación cliente', 'Correo cliente', 'Cantidad productos', 'Monto total', 'Fecha y hora'
            ], $delimiter);

            foreach ($sales as $sale) {
                fputcsv($handle, [
                    $sale->code,
                    $sale->customer,
                    $sale->document,
                    $sale->email,
                    $sale->quantity,
                    $sale->total,
                    $sale->created_at,
                ], $delimiter);
            }

            fclose($handle);
        });

        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename="sales_report.csv"');

        return $response;
    }
}
