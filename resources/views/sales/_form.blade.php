<!-- filepath: /var/www/punto-de-venta/resources/views/sales/form.blade.php -->

<div class="form-group">
    <label for="customer">Cliente</label>
    <input type="text" name="customer" class="form-control" id="customer" value="{{ old('customer', $sale->customer ?? '') }}" required>
</div>

<div class="form-group">
    <label for="document">Nro Documento</label>
    <input type="text" name="document" class="form-control" id="document" value="{{ old('document', $sale->document ?? '') }}" required>
</div>

<div class="form-group">
    <label for="product_id">Producto</label>
    <select name="product_id" class="form-control" id="product_id" required>
        <option value="">Seleccione un producto</option>
        @foreach($products as $product)
            <option value="{{ $product->id }}" {{ old('product_id', $sale->product_id ?? '') == $product->id ? 'selected' : '' }}>
                {{ $product->name }}
            </option>
        @endforeach
    </select>
</div>

<div class="form-group">
    <label for="quantity">Cantidad</label>
    <input type="number" name="quantity" class="form-control" id="quantity" value="{{ old('quantity', $sale->quantity ?? '') }}" required>
</div>

<div class="form-group">
    <label for="total">Total</label>
    <input type="text" name="total" class="form-control" id="total" value="{{ old('total', $sale->total ?? '') }}" disabled required>
</div>



