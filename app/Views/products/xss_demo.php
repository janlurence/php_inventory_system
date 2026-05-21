<?php

declare(strict_types=1);

$e = static fn (mixed $value): string => htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
$sample = '<script>alert("xss")</script><b>Hello</b>';
?>
<section class="toolbar">
    <div>
        <h1>XSS Demo</h1>
        <p>Test if the middleware removes script tags before the request reaches the controller.</p>
    </div>
    <a class="button secondary" href="/products">Back</a>
</section>

<form method="post" action="/xss-demo">
    <p>Try XSS text</p>
    <textarea name="xss_sample" rows="5" cols="60" placeholder="<?= $e($sample) ?>"><?= $e($raw) ?></textarea>
    <p><button type="submit">Check XSS</button></p>
</form>

<?php if ($raw !== '' || $sanitized !== ''): ?>
    <h2>Result</h2>
    <p>Raw input is shown first. Output is the sanitized value after middleware.</p>

    <p>Raw sample</p>
    <textarea rows="5" cols="60" readonly><?= $e($raw) ?></textarea>

    <p>Sanitized output</p>
    <textarea rows="5" cols="60" readonly><?= $e($sanitized) ?></textarea>
<?php endif; ?>
