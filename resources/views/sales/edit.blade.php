
<!-- filepath: /var/www/punto-de-venta/resources/views/sales/edit.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Editar Venta</h1>
    <form action="{{ route('sales.update', $sale->id) }}" method="POST">
        @csrf
        @method('PUT')
        @include('sales._form')
        <button type="submit" class="btn btn-primary">Actualizar</button>
    </form>
</div>
@endsection