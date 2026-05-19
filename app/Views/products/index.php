<?php

declare(strict_types=1);

$e = static fn (mixed $value): string => htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
?>
<section class="toolbar">
    <div>
        <h1>Inventory</h1>
        <p>Manage products, stock levels, prices, and availability through the custom MVC framework.</p>
    </div>
    <a class="button" href="/products/create">Add Product</a>
</section>

<section class="panel">
    <?php if ($products === []): ?>
        <div class="empty">
            <h2>No products yet</h2>
            <p>Create the first inventory record to verify form handling and database persistence.</p>
            <a class="button" href="/products/create">Add Product</a>
        </div>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>SKU</th>
                    <th>Qty</th>
                    <th>Price</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product): ?>
                    
                    <tr>
                        <td data-label="Name"><strong><?= $e($product->name) ?></strong></td>
                        <td data-label="SKU"><?= $e($product->sku) ?></td>
                        <td data-label="Qty"><?= $e($product->quantity) ?></td>
                        <td data-label="Price">PHP <?= number_format($product->price, 2) ?></td>
                        <td data-label="Status"><span class="badge"><?= $e($product->status->label()) ?></span></td>
                        <td data-label="Actions">
                            <div class="actions">
                                <a class="button secondary" href="/products/<?= $e($product->id) ?>">View</a>
                                <a class="button secondary" href="/products/<?= $e($product->id) ?>/edit">Edit</a>
                                <a class="button danger" href="/products/<?= $e($product->id) ?>/delete">Delete</a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</section>
