<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Sale;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class SaleController extends Controller
{
    // Mostrar una lista de ventas
    public function index()
    {
        $sales = Sale::orderBy('id', 'desc')->paginate(12);
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
        DB::beginTransaction();

        try {
            $validatedData = $request->validate([
                'code' => 'required|string|max:255|unique:sales,code',
                'customer' => 'required|string|max:255',
                'document' => 'required|string|max:255',
                'product_id' => 'required|string|max:255',
                'quantity' => 'required|integer',
            ]);

            $product = Product::findOrFail($validatedData['product_id']);

            if ($product->stock_available < $validatedData['quantity']) {
                throw ValidationException::withMessages(['quantity' => 'No hay suficiente stock disponible.']);
            }

            $product->stock_available -= $validatedData['quantity'];
            $product->save();

            $sale = new Sale();
            $sale->code = $validatedData['code'];
            $sale->customer = $validatedData['customer'];
            $sale->document = $validatedData['document'];

            if ($request->has('email') && !empty($request->email)) {
                $request->validate([
                    'email' => 'email',
                ]);

                $sale->email = $request->email;
            }

            $sale->user_id = Auth::id();
            $sale->product_id = $product->id;
            $sale->quantity = $validatedData['quantity'];
            $sale->total = $product->price * $validatedData['quantity'];

            $sale->save();

            DB::commit();

            return redirect()->route('sales.index')->with('success', 'Venta creada exitosamente.');
        } catch (ValidationException $e) {
            DB::rollBack();
            return redirect()->route('sales.create')->withErrors($e->errors());
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('sales.create')->with('error', 'Ocurrió un error al crear la venta.');
        }
    }

    // Mostrar el formulario para editar una venta existente
    public function edit($id)
    {
        $sale = Sale::findOrFail($id);
        $products = Product::all();
        return view('sales.edit', compact('sale', 'products'));
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            $validatedData = $request->validate([
                'code' => 'required|string|max:255|unique:sales,code,' . $id,
                'customer' => 'required|string|max:255',
                'document' => 'required|string|max:255',
                'product_id' => 'required|string|max:255',
                'quantity' => 'required|integer',
            ]);

            $sale = Sale::findOrFail($id);
            $product = Product::findOrFail($validatedData['product_id']);

            if ($product->stock_available + $sale->quantity < $validatedData['quantity']) {
                throw ValidationException::withMessages(['quantity' => 'No hay suficiente stock disponible.']);
            }

            $product->stock_available += $sale->quantity;
            $product->stock_available -= $validatedData['quantity'];
            $product->save();

            $sale->code = $validatedData['code'];
            $sale->customer = $validatedData['customer'];
            $sale->document = $validatedData['document'];

            if ($request->has('email') && !empty($request->email)) {
                $request->validate([
                    'email' => 'email',
                ]);

                $sale->email = $request->email;
            }

            $sale->user_id = Auth::id();
            $sale->product_id = $product->id;
            $sale->quantity = $validatedData['quantity'];
            $sale->total = $product->price * $validatedData['quantity'];

            $sale->save();

            DB::commit();

            return redirect()->route('sales.index')->with('success', 'Venta actualizada exitosamente.');
        } catch (ValidationException $e) {
            DB::rollBack();
            return redirect()->route('sales.edit', $id)->withErrors($e->errors());
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('sales.edit', $id)->with('error', 'Ocurrió un error al actualizar la venta.');
        }
    }

    // Eliminar una venta de la base de datos
    public function destroy($id)
    {
        $sale = Sale::findOrFail($id);
        $product = $sale->product;
        $product->stock_available += $sale->quantity;
        $product->save();
        $sale->delete();

        return redirect()->route('sales.index')->with('success', 'Venta eliminada exitosamente.');
    }
}