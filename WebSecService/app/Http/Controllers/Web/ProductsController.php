<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('products.index', compact('products'));
    }

    public function purchase(Product $product)
    {
        $user = auth()->user();
        if ($user->credit < $product->price) {
            return view('products.insufficient_credit');
        }
        if ($product->stock < 1) {
            return redirect()->back()->with('error', 'Out of stock');
        }

        $user->purchases()->create(['product_id' => $product->id]);
        $user->credit -= $product->price;
        $user->save();
        $product->stock--;
        $product->save();

        return redirect()->route('profile')->with('success', 'Purchase successful');
    }

    // Add store, edit, update, destroy methods for employees
}