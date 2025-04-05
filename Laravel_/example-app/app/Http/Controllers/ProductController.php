<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProductController extends Controller
{
    private function initSessionProducts(): void
    {
        if (!session()->has('products')) {
            session([
                'products' => [
                    ['id' => 1, 'name' => 'Product 1', 'description' => 'Description 1', 'price' => 100],
                    ['id' => 2, 'name' => 'Product 2', 'description' => 'Description 2', 'price' => 200],
                ]
            ]);
        }
    }

    private function getProducts(): array
    {
        $this->initSessionProducts();
        return session('products', []);
    }

    private function saveProducts(array $products): void
    {
        session(['products' => array_values($products)]);
    }

    public function index()
    {
        $products = $this->getProducts();
        return response()->json(['data' => $products], Response::HTTP_OK);
    }

    public function show($id)
    {
        $products = $this->getProducts();
        $product = collect($products)->firstWhere('id', $id);

        if (!$product) {
            return response()->json(['error' => 'Product not found'], Response::HTTP_NOT_FOUND);
        }

        return response()->json(['data' => $product], Response::HTTP_OK);
    }

    public function createProduct(Request $request)
    {
        $products = $this->getProducts();

        $newProduct = [
            'id' => count($products) > 0 ? max(array_column($products, 'id')) + 1 : 1,
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'price' => $request->input('price'),
        ];

        $products[] = $newProduct;
        $this->saveProducts($products);

        return response()->json(['data' => $newProduct], Response::HTTP_CREATED);
    }

    public function update(Request $request, $id)
    {
        $products = $this->getProducts();
        $index = collect($products)->search(fn($product) => $product['id'] == $id);

        if ($index === false) {
            return response()->json(['error' => 'Product not found'], Response::HTTP_NOT_FOUND);
        }

        $products[$index] = array_merge(
            $products[$index],
            $request->only(['name', 'description', 'price'])
        );

        $this->saveProducts($products);

        return response()->json(['data' => $products[$index]], Response::HTTP_OK);
    }

    public function delete($id)
    {
        $products = $this->getProducts();
        $index = collect($products)->search(fn($product) => $product['id'] == $id);

        if ($index === false) {
            return response()->json(['error' => 'Product not found'], Response::HTTP_NOT_FOUND);
        }

        $deletedProduct = $products[$index];
        unset($products[$index]);
        $this->saveProducts($products);

        return response()->json(['data' => $deletedProduct], Response::HTTP_OK);
    }
}
