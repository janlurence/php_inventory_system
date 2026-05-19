<?php

declare(strict_types=1);

$e = static fn (mixed $value): string => htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
?>
<section class="toolbar">
    <div>
        <h1>Delete Product</h1>
        <p>Review this inventory item before removing it.</p>
    </div>
    <a class="button secondary" href="/products">Back</a>
</section>

<section class="panel">
    <div class="warning">
        <div class="warning-box">
            <strong><?= $e($product->name) ?></strong> will be permanently deleted from inventory.
        </div>

        <div class="details">
            <div class="metric"><span>SKU</span><?= $e($product->sku) ?></div>
            <div class="metric"><span>Status</span><span class="badge"><?= $e($product->status->label()) ?></span></div>
            <div class="metric"><span>Quantity</span><?= $e($product->quantity) ?></div>
            <div class="metric"><span>Price</span>PHP <?= number_format($product->price, 2) ?></div>
        </div>

        <div class="actions">
            <form class="inline" method="post" action="/products/<?= $e($product->id) ?>">
                <input type="hidden" name="_method" value="DELETE">
                <button class="danger" type="submit">Confirm Delete</button>
            </form>
            <a class="button secondary" href="/products/<?= $e($product->id) ?>">Cancel</a>
        </div>
    </div>
</section>
