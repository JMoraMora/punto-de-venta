<!-- filepath: /var/www/punto-de-venta/resources/views/sales/form.blade.php -->

<div class="form-group">
    <label for="code">Codigo de venta *</label>
    <input type="text" name="code" class="form-control" id="code" value="{{ old('code', $sale->code ?? '') }}" required>
    @if ($errors->has('code'))
        <span class="text-danger">{{ $errors->first('code') }}</span>
    @endif
</div>

<div class="form-group">
    <label for="customer">Cliente *</label>
    <input type="text" name="customer" class="form-control" id="customer" value="{{ old('customer', $sale->customer ?? '') }}" required>
    @if ($errors->has('customer'))
        <span class="text-danger">{{ $errors->first('customer') }}</span>
    @endif
</div>

<div class="form-group">
    <label for="document">Nro Documento *</label>
    <input type="text" name="document" class="form-control" id="document" value="{{ old('document', $sale->document ?? '') }}" required>
    @if ($errors->has('document'))
        <span class="text-danger">{{ $errors->first('document') }}</span>
    @endif
</div>

<div class="form-group">
    <label for="email">Email (Opcional)</label>
    <input type="text" name="email" class="form-control" id="email" value="{{ old('email', $sale->email ?? '') }}">
    @if ($errors->has('email'))
        <span class="text-danger">{{ $errors->first('email') }}</span>
    @endif
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
    @if ($errors->has('product_id'))
        <span class="text-danger">{{ $errors->first('product_id') }}</span>
    @endif
</div>

<div class="form-group">
    <label for="quantity">Cantidad</label>
    <input type="number" name="quantity" class="form-control" id="quantity" value="{{ old('quantity', $sale->quantity ?? '') }}" required>
    @if ($errors->has('quantity'))
        <span class="text-danger">{{ $errors->first('quantity') }}</span>
    @endif
</div>

<div class="form-group">
    <label for="total">Total</label>
    <input type="text" name="total" class="form-control" id="total" value="{{ old('total', $sale->total ?? '') }}" disabled>
</div>



