<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\ProductStatus;
use App\Repositories\ProductRepositoryInterface;
use App\Services\ProductValidator;
use Core\Http\Request;
use Core\Http\Response;
use Core\View\Engine;

final readonly class ProductController
{
    public function __construct(
        private ProductRepositoryInterface $products,
        private ProductValidator $validator,
        private Engine $view,
    ) {
    }

    public function index(): Response
    {
        return Response::html($this->view->render('products.index', [
            'title' => 'Inventory',
            'products' => $this->products->all(),
        ]));
    }

    public function create(): Response
    {
        return Response::html($this->view->render('products.form', [
            'title' => 'Add Product',
            'action' => '/products',
            'method' => 'POST',
            'product' => null,
            'statuses' => ProductStatus::cases(),
            'errors' => [],
            'old' => [],
        ]));
    }

    public function xssDemo(): Response
    {
        return Response::html($this->view->render('products.xss_demo', [
            'title' => 'XSS Demo',
            'raw' => '',
            'sanitized' => '',
        ]));
    }

    public function checkXss(Request $request): Response
    {
        return Response::html($this->view->render('products.xss_demo', [
            'title' => 'XSS Demo',
            'raw' => (string) ($request->rawBody['xss_sample'] ?? ''),
            'sanitized' => (string) ($request->body['xss_sample'] ?? ''),
        ]));
    }

    public function store(Request $request): Response
    {
        $validated = $this->validator->validate($request);

        if (! $validated['valid']) {
            return $this->formResponse('Add Product', '/products', null, $validated['errors'], $validated['data']);
        }

        if ($this->products->findBySku((string) $validated['data']['sku']) !== null) {
            return $this->formResponse('Add Product', '/products', null, [
                'sku' => 'That SKU is already used by another product.',
            ], $validated['data']);
        }

        $this->products->create($validated['data']);

        return Response::redirect('/products');
    }

    public function show(Request $request, string $id): Response
    {
        $product = $this->products->find((int) $id);

        if ($product === null) {
            return Response::html($this->view->render('errors.404', ['title' => 'Product not found']), 404);
        }

        return Response::html($this->view->render('products.show', [
            'title' => $product->name,
            'product' => $product,
        ]));
    }

    public function edit(Request $request, string $id): Response
    {
        $product = $this->products->find((int) $id);

        if ($product === null) {
            return Response::html($this->view->render('errors.404', ['title' => 'Product not found']), 404);
        }

        return Response::html($this->view->render('products.form', [
            'title' => 'Edit Product',
            'action' => "/products/{$id}",
            'method' => 'POST',
            'product' => $product,
            'statuses' => ProductStatus::cases(),
            'errors' => [],
            'old' => [],
        ]));
    }

    public function confirmDestroy(Request $request, string $id): Response
    {
        $product = $this->products->find((int) $id);

        if ($product === null) {
            return Response::html($this->view->render('errors.404', ['title' => 'Product not found']), 404);
        }

        return Response::html($this->view->render('products.confirm_delete', [
            'title' => 'Delete Product',
            'product' => $product,
        ]));
    }

    public function update(Request $request, string $id): Response
    {
        $product = $this->products->find((int) $id);

        if ($product === null) {
            return Response::html($this->view->render('errors.404', ['title' => 'Product not found']), 404);
        }

        $validated = $this->validator->validate($request);

        if (! $validated['valid']) {
            return $this->formResponse('Edit Product', "/products/{$id}", $product, $validated['errors'], $validated['data']);
        }

        $productWithSku = $this->products->findBySku((string) $validated['data']['sku']);

        if ($productWithSku !== null && $productWithSku->id !== (int) $id) {
            return $this->formResponse('Edit Product', "/products/{$id}", $product, [
                'sku' => 'That SKU is already used by another product.',
            ], $validated['data']);
        }

        $this->products->update((int) $id, $validated['data']);

        return Response::redirect("/products/{$id}");
    }

    public function destroy(Request $request, string $id): Response
    {
        if ($this->products->find((int) $id) === null) {
            return Response::html($this->view->render('errors.404', ['title' => 'Product not found']), 404);
        }

        $this->products->delete((int) $id);

        return Response::redirect('/products');
    }

    private function formResponse(string $title, string $action, mixed $product, array $errors, array $old): Response
    {
        return Response::html($this->view->render('products.form', [
            'title' => $title,
            'action' => $action,
            'method' => 'POST',
            'product' => $product,
            'statuses' => ProductStatus::cases(),
            'errors' => $errors,
            'old' => $old,
        ]), 422);
    }
}
