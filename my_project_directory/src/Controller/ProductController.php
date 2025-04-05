<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/v1')]
class ProductController extends AbstractController
{
    private const PRODUCTS = [
        ['id' => 1, 'name' => 'Product 1', 'description' => 'description 1', 'price' => 999.99],
        ['id' => 2, 'name' => 'Product 2', 'description' => 'description 2', 'price' => 49.99],
    ];

    private const SESSION_KEY = 'products';

    private function getProductsFromSession(SessionInterface $session): array
    {
        if (!$session->has(self::SESSION_KEY)) {
            $session->set(self::SESSION_KEY, self::PRODUCTS);
        }

        return $session->get(self::SESSION_KEY);
    }

    private function saveProductsToSession(SessionInterface $session, array $products): void
    {
        $session->set(self::SESSION_KEY, $products);
    }

    #[Route('/products', name: 'get_products', methods: [Request::METHOD_GET])]
    public function getProducts(SessionInterface $session): JsonResponse
    {
        $products = $this->getProductsFromSession($session);
        return new JsonResponse(['data' => $products], Response::HTTP_OK);
    }

    #[Route('/products/{id}', name: 'get_product_item', methods: [Request::METHOD_GET])]
    public function getProductItem(string $id, SessionInterface $session): JsonResponse
    {
        $products = $this->getProductsFromSession($session);
        $product = $this->getProductItemById($products, $id);

        if (!$product) {
            return new JsonResponse(['data' => ['error' => 'Not found product by id ' . $id]], Response::HTTP_NOT_FOUND);
        }

        return new JsonResponse(['data' => $product], Response::HTTP_OK);
    }

    #[Route('/products', name: 'post_products', methods: [Request::METHOD_POST])]
    public function createProduct(Request $request, SessionInterface $session): JsonResponse
    {
        $requestData = json_decode($request->getContent(), true);
        $products = $this->getProductsFromSession($session);

        $maxId = max(array_column($products, 'id'));
        $newId = $maxId + 1;

        $newProduct = [
            'id' => $newId,
            'name' => $requestData['name'] ?? '',
            'description' => $requestData['description'] ?? '',
            'price' => $requestData['price'] ?? 0,
        ];

        $products[] = $newProduct;
        $this->saveProductsToSession($session, $products);

        return new JsonResponse(['data' => $newProduct], Response::HTTP_CREATED);
    }

    #[Route('/products/{id}', name: 'patch_product', methods: [Request::METHOD_PATCH])]
    public function updateProduct(string $id, Request $request, SessionInterface $session): JsonResponse
    {
        $products = $this->getProductsFromSession($session);
        $found = false;

        foreach ($products as &$product) {
            if ($product['id'] == $id) {
                $requestData = json_decode($request->getContent(), true);
                $product['name'] = $requestData['name'] ?? $product['name'];
                $product['description'] = $requestData['description'] ?? $product['description'];
                $product['price'] = $requestData['price'] ?? $product['price'];
                $found = true;
                break;
            }
        }

        if (!$found) {
            return new JsonResponse(['data' => ['error' => 'Not found product by id ' . $id]], Response::HTTP_NOT_FOUND);
        }

        $this->saveProductsToSession($session, $products);

        return new JsonResponse(['data' => $product], Response::HTTP_OK);
    }

    #[Route('/products/{id}', name: 'delete_product', methods: [Request::METHOD_DELETE])]
    public function deleteProduct(string $id, SessionInterface $session): JsonResponse
    {
        $products = $this->getProductsFromSession($session);
        $initialCount = count($products);

        $products = array_filter($products, fn ($product) => $product['id'] != $id);

        if (count($products) === $initialCount) {
            return new JsonResponse(['data' => ['error' => 'Not found product by id ' . $id]], Response::HTTP_NOT_FOUND);
        }

        $this->saveProductsToSession($session, array_values($products));

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }

    private function getProductItemById(array $products, string $id): ?array
    {
        foreach ($products as $product) {
            if ($product['id'] == $id) {
                return $product;
            }
        }
        return null;
    }
}
