<!-- filepath: /var/www/punto-de-venta/resources/views/sales/index.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-4">Lista de Ventas</h1>

    <a href="{{ route('sales.create') }}" class="btn btn-primary mb-3">Crear Nueva Venta</a>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Codigo</th>
                <th>Cliente</th>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Precio unitario</th>
                <th>Total</th>
                <th>Fecha</th>
                @if (Auth::user()->role === 'administrator')
                    <th>Vendedor</th>
                    <th>Acciones</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach($sales as $sale)
                <tr>
                    <td>{{ $sale->id }}</td>
                    <td>{{ $sale->code }}</td>
                    <td>{{ $sale->customer }}</td>
                    <td>{{ $sale->product->name }}</td>
                    <td>{{ $sale->quantity }}</td>
                    <td>{{ $sale->product->price }}</td>
                    <td>{{ $sale->total }}</td>
                    <td>{{ $sale->created_at }}</td>
                    @if (Auth::user()->role === 'administrator')
                        <td>{{ $sale->user->name }}</td>
                        <td>
                            <a href="{{ route('sales.edit', $sale->id) }}" class="btn btn-warning">Editar</a>
                            <form action="{{ route('sales.destroy', $sale->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro de que deseas eliminar esta venta?')">Eliminar</button>
                            </form>
                        </td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection