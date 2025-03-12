<!-- filepath: /var/www/punto-de-venta/resources/views/product/edit.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Product</h1>
    <form action="{{ route('products.update', $product->id) }}" method="POST">
        @csrf
        @method('PUT')
        @include('product._form')
    </form>
</div>
@endsection