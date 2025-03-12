<!-- filepath: /var/www/punto-de-venta/resources/views/sales/create.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Crear Nueva Venta</h1>

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('sales.store') }}" method="POST">
        @csrf
        @include('sales._form')
        <button type="submit" class="btn btn-primary">Guardar</button>
    </form>
</div>
@endsection