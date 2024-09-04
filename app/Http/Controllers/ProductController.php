<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    //

    public function index()
    {
        $products = Product::with('images')->get();
        return view('product.index', compact('products'));
    }

    public function create()
    {
        return view('product.create');
    }

    public function store(Request $request)
    {

        // Validation
        $request->validate([
            'product_name' => 'required|string|max:255',
            'product_price' => 'required|numeric|min:0',
            'product_description' => 'required|string',
            'images.*' => 'required|image|mimes:jpg,jpeg,png|max:2048', // Limit each image to 2MB
        ]);

        $product = Product::create($request->only('product_name', 'product_description', 'product_price'));

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                // Save the image in the public/images directory
                $filename = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('images'), $filename);

                // Save the image path in the database
                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => 'images/' . $filename,
                ]);
            }
        }

        return response()->json([
            'success' => true,
            'redirect_url' => route('products.index'),
        ]);
    }

    public function destroy($id)
    {
        $product = Product::find($id);

        // Delete associated images from the public folder
        foreach ($product->images as $image) {
            $imagePath = public_path($image->image);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        // Delete product and images from the database
        $product->images()->delete();
        $product->delete();

        return response()->json(['success' => 'Product deleted successfully.']);
    }

}
