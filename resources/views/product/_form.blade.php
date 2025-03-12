<!-- filepath: /var/www/punto-de-venta/resources/views/product/_form.blade.php -->

<div class="form-group">
    <label for="sku">SKU</label>
    <input type="text" class="form-control" id="sku" name="sku" value="{{ old('sku', $product->sku ?? '') }}" required>
    @error('sku')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label for="name">Name</label>
    <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $product->name ?? '') }}" required>
    @error('name')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label for="price">Price</label>
    <input type="number" class="form-control" id="price" name="price" value="{{ old('price', $product->price ?? '') }}" step="0.01" required>
    @error('price')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label for="stock">Stock</label>
    <input type="number" class="form-control" id="stock" name="stock" value="{{ old('stock', $product->stock ?? '') }}" required>
    @error('stock')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

<button type="submit" class="btn btn-primary">Save</button>