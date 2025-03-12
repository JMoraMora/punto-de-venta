<!-- filepath: /var/www/punto-de-venta/resources/views/product/create.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Create Product</h1>
    <form action="{{ route('products.store') }}" method="POST">
        @csrf
        @include('product._form')
    </form>
</div>
@endsection