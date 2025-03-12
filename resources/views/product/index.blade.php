<!-- filepath: /var/www/punto-de-venta/resources/views/product/index.blade.php -->
@extends('layouts.app')

@section('title', 'Products')

@section('content')
<div class="container">
    <h1 class="my-4">Products</h1>
    <a href="{{ route('products.create') }}" class="btn btn-success mb-3">Create Product</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>SKU</th>
                <th>Name</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
                <tr>
                    <td>{{ $product->sku }}</td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->price }}</td>
                    <td>{{ $product->stock }}</td>
                    <td>
                        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-primary btn-sm">Edit</a>
                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach

            {{ $products->links() }}
        </tbody>
    </table>
</div>
@endsection