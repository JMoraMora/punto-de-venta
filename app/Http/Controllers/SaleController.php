<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Sale;

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
            'product_name' => 'required|string|max:255',
            'quantity' => 'required|integer',
            'price' => 'required|numeric',
        ]);

        Sale::create($validatedData);

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