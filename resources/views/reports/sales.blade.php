@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-4">Reporte de Ventas</h1>

    <form method="GET" action="{{ route('reports.sales') }}">
        <div class="d-flex mb-3 justify-content-between">
            <div class="d-inline-flex gap-3">
                <input type="date" style="width:400px" name="start_date" class="form-control" placeholder="Fecha de inicio" value="{{ request('start_date') }}">
                <input type="date" style="width:400px" name="end_date" class="form-control" placeholder="Fecha de fin" value="{{ request('end_date') }}">
            </div>
            <div>
                <button type="submit" class="btn btn-primary">Filtrar</button>
            </div>
        </div>
    </form>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Código</th>
                <th>Nombre cliente</th>
                <th>Identificación cliente</th>
                <th>Correo cliente</th>
                <th>Cantidad productos</th>
                <th>Monto total</th>
                <th>Fecha y hora</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sales as $sale)
                <tr>
                    <td>{{ $sale->code }}</td>
                    <td>{{ $sale->customer }}</td>
                    <td>{{ $sale->document }}</td>
                    <td>{{ $sale->email }}</td>
                    <td>{{ $sale->quantity }}</td>
                    <td>{{ $sale->total }}</td>
                    <td>{{ $sale->created_at }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <a href="{{ route('reports.sales.export', ['format' => 'json', 'start_date' => request('start_date'), 'end_date' => request('end_date')]) }}" class="btn btn-secondary">Exportar JSON</a>
    <a href="{{ route('reports.sales.export', ['format' => 'csv', 'start_date' => request('start_date'), 'end_date' => request('end_date')]) }}" class="btn btn-secondary">Exportar XLSX</a>
</div>
@endsection