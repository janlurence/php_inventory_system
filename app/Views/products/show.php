<?php

declare(strict_types=1);

$e = static fn (mixed $value): string => htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
?>
<section class="toolbar">
    <div>
        <h1><?= $e($product->name) ?></h1>
        <p>Single-record view resolved through the parameter route <strong>/products/{id}</strong>.</p>
    </div>
    <div class="actions">
        <a class="button secondary" href="/products">Back</a>
        <a class="button" href="/products/<?= $e($product->id) ?>/edit">Edit</a>
    </div>
</section>

<section class="panel">
    <div class="details">
        <div class="metric"><span>SKU</span><?= $e($product->sku) ?></div>
        <div class="metric"><span>Status</span><span class="badge"><?= $e($product->status->label()) ?></span></div>
        <div class="metric"><span>Quantity</span><?= $e($product->quantity) ?></div>
        <div class="metric"><span>Price</span>PHP <?= number_format($product->price, 2) ?></div>
        <div class="metric"><span>Created</span><?= $e($product->createdAt ?? 'Not recorded') ?></div>
    </div>
</section>
