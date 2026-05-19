<?php

declare(strict_types=1);

use App\Models\Product;
use App\Models\ProductStatus;

$e = static fn (mixed $value): string => htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
$value = static function (string $field) use ($old, $product): string {
    if (array_key_exists($field, $old)) {
        return (string) $old[$field];
    }

    if (! $product instanceof Product) {
        return '';
    }

    $current = $product->{$field};

    return $current instanceof ProductStatus ? $current->value : (string) $current;
};
?>
<section class="toolbar">
    <div>
        <h1><?= $e($title) ?></h1>
        <p>Validated form input is passed to a controller, then saved through a repository abstraction.</p>
    </div>
    <a class="button secondary" href="/products">Back</a>
</section>

<section class="panel">
    <form class="form" method="post" action="<?= $e($action) ?>">
        <div class="grid">
            <label>
                Product name
                <input name="name" value="<?= $e($value('name')) ?>" required minlength="3">
                <?php if (isset($errors['name'])): ?><span class="error"><?= $e($errors['name']) ?></span><?php endif; ?>
            </label>

            <label>
                SKU
                <input name="sku" value="<?= $e($value('sku')) ?>" required pattern="[A-Za-z0-9-]{3,24}">
                <?php if (isset($errors['sku'])): ?><span class="error"><?= $e($errors['sku']) ?></span><?php endif; ?>
            </label>
        </div>

        <div class="grid">
            <label>
                Quantity
                <input type="number" name="quantity" min="0" value="<?= $e($value('quantity') ?: '0') ?>" required>
                <?php if (isset($errors['quantity'])): ?><span class="error"><?= $e($errors['quantity']) ?></span><?php endif; ?>
            </label>

            <label>
                Price
                <input type="number" name="price" min="0.01" step="0.01" value="<?= $e($value('price')) ?>" required>
                <?php if (isset($errors['price'])): ?><span class="error"><?= $e($errors['price']) ?></span><?php endif; ?>
            </label>
        </div>

        <label>
            Stock status
            <select name="status">
                <?php foreach ($statuses as $status): ?>
                    
                    <option value="<?= $e($status->value) ?>" <?= $value('status') === $status->value ? 'selected' : '' ?>>
                        <?= $e($status->label()) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <?php if (isset($errors['status'])): ?><span class="error"><?= $e($errors['status']) ?></span><?php endif; ?>
        </label>

        <div class="actions">
            <button type="submit">Save Product</button>
            <a class="button secondary" href="/products">Cancel</a>
        </div>
    </form>
</section>
