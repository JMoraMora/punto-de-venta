<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Sale;
use Illuminate\Support\Facades\Auth;

class SaleController extends Controller
{
    // Mostrar una lista de ventas
    public function index()
    {
        $sales = Sale::paginate(12);
        return view('sales.index', compact('sales'));
    }

    // Mostrar el formulario para crear una nueva venta
    public function create()
    {
        $products = Product::all();
        return view('sales.create', compact('products'));
    }

    // Almacenar una nueva venta en la base de datos
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'code' => 'required|string|max:255',
            'customer' => 'required|string|max:255',
            'document' => 'required|string|max:255',
            'product_id' => 'required|string|max:255',
            'quantity' => 'required|integer',
        ]);

        $product = Product::findOrFail($validatedData['product_id']);

        if ($product->stock_available < $validatedData['quantity']) {
            return redirect()->route('sales.create')->with('error', 'No hay suficiente stock disponible.');
        }

        $product->stock_available -= $validatedData['quantity'];
        $product->save();

        $sale = new Sale();
        $sale->code = $validatedData['code'];
        $sale->customer = $validatedData['customer'];
        $sale->document = $validatedData['document'];

        if($request->has('email') && !empty($request->email)) {
            $request->validate([
                'email' => 'email',
            ]);

            $sale->email = $request->email;
        }

        // $sale->user_id = Auth::id();
        $sale->user_id = 1;
        $sale->product_id = $product->id;
        $sale->quantity = $validatedData['quantity'];
        $sale->total = $product->price * $validatedData['quantity'];

        $sale->save();

        return redirect()->route('sales.index')->with('success', 'Venta creada exitosamente.');
    }

    // Mostrar el formulario para editar una venta existente
    public function edit($id)
    {
        $sale = Sale::findOrFail($id);
        $products = Product::all();
        return view('sales.edit', compact('sale', 'products'));
    }

    // Actualizar una venta existente en la base de datos
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'product_name' => 'required|string|max:255',
            'quantity' => 'required|integer',
            'price' => 'required|numeric',
        ]);

        Sale::whereId($id)->update($validatedData);

        return redirect()->route('sales.index')->with('success', 'Venta actualizada exitosamente.');
    }

    // Eliminar una venta de la base de datos
    public function destroy($id)
    {
        $sale = Sale::findOrFail($id);
        $sale->delete();

        return redirect()->route('sales.index')->with('success', 'Venta eliminada exitosamente.');
    }
}