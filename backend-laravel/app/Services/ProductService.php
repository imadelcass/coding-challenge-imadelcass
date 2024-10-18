<?php

namespace App\Services;

use App\Models\Product;

class ProductService
{
    public function create(array $data)
    {
        $product = Product::create($data);
        $product->categories()->sync($data['categories'] ?? []);
        return $product;
    }

    public function update(Product $product, array $data)
    {
        $product->update($data);
        $product->categories()->sync($data['categories'] ?? []);
        return $product;
    }

    public function delete(Product $product)
    {
        $product->delete();
    }
}
