<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function buy(Product $product)
    {
        $user = auth()->user();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Please login to make a purchase.');
        }

        // Check if user has the Customer role
        if (!$user->hasRole('Customer')) {
            return redirect()->route('products.index')
                ->with('error', 'Only customers can buy products.');
        }

        if ($product->stock <= 0) {
            return redirect()->route('products.index')->with('error', 'Product is out of stock.');
        }

        if ($user->credit < $product->price) {
            return view('products.insufficient_credit', compact('product'));
        }

        try {
            DB::beginTransaction();

            // Update user's credit
            $user->credit -= $product->price;
            $user->save();

            // Update product stock
            $product->stock -= 1;
            $product->save();

            // Create purchase record
            Purchase::create([
                'user_id' => $user->id,
                'product_id' => $product->id,
                'price' => $product->price,
                'quantity' => 1
            ]);

            DB::commit();

            return redirect()->route('products.index')
                ->with('success', 'Product purchased successfully! Your remaining credit is $' . number_format($user->credit, 2));
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Purchase failed: ' . $e->getMessage());
            return redirect()->route('products.index')
                ->with('error', 'An error occurred while processing your purchase. Please try again.');
        }
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        try {
            $product = new Product();
            $product->name = $request->name;
            $product->description = $request->description;
            $product->price = $request->price;
            $product->stock = $request->stock;

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('images/products'), $imageName);
                $product->image_path = 'images/products/' . $imageName;
            }

            $product->save();

            return redirect()->route('products.index')
                ->with('success', 'Product created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error creating product: ' . $e->getMessage());
        }
    }
} 