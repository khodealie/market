<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductRes;
use App\Http\Resources\ProductCollection;
use App\Models\Address;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function addProduct(Request $request): ProductRes
    {
        $request->validate([
            'name' => ['required', 'min:5', 'max:32'],
            'price' => ['required', 'numeric']
        ]);
        $product = new Product();
        $product['name'] = $request['name'];
        $product['price'] = $request['price'];
        $product->user()->associate(auth()->user());
        $product->save();
        return new ProductRes($product);
    }

    public function getAllProducts(): ProductCollection
    {
        $userAddress = Auth()->user()->addresses()->first();
        $addresses = Address::getNearLocation($userAddress['latitude'], $userAddress['longitude']);
        $products = collect();
        foreach ($addresses as $address) {
            $products = $products->merge($address->user->products);
        }
        return new ProductCollection($products);
    }
}
