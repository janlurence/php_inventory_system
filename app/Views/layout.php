<?php

declare(strict_types=1);

$e = static fn (mixed $value): string => htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
$pageTitle = isset($title) ? $e($title) . ' | PHP MVC Inventory' : 'PHP MVC Inventory';
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $pageTitle ?></title>
    <style>
        :root {
            color-scheme: light;
            --ink: #172033;
            --muted: #657084;
            --line: #d9dee8;
            --panel: #ffffff;
            --page: #f5f7fb;
            --accent: #0f766e;
            --accent-dark: #115e59;
            --danger: #b42318;
        }

        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            color: var(--ink);
            background: var(--page);
        }

        header {
            background: #111827;
            color: #fff;
            border-bottom: 4px solid var(--accent);
        }

        .bar, main {
            width: min(1120px, calc(100% - 32px));
            margin: 0 auto;
        }

        .bar {
            min-height: 72px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
        }

        .brand {
            font-size: 1.1rem;
            font-weight: 800;
            letter-spacing: 0;
        }

        nav a {
            color: #d1fae5;
            text-decoration: none;
            font-weight: 700;
            margin-left: 18px;
        }

        main { padding: 34px 0 56px; }

        .toolbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 18px;
            margin-bottom: 20px;
        }

        h1 { margin: 0; font-size: clamp(1.7rem, 4vw, 2.5rem); }
        p { color: var(--muted); line-height: 1.6; }

        .panel {
            background: var(--panel);
            border: 1px solid var(--line);
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 12px 28px rgb(20 27 45 / 8%);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 14px 16px;
            text-align: left;
            border-bottom: 1px solid var(--line);
            vertical-align: middle;
        }

        th {
            font-size: .78rem;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: .08em;
            background: #f9fafb;
        }

        tr:last-child td { border-bottom: 0; }

        .actions {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            align-items: center;
        }

        .button, button {
            appearance: none;
            border: 0;
            border-radius: 6px;
            background: var(--accent);
            color: #fff;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 38px;
            padding: 0 14px;
            font: inherit;
            font-weight: 800;
            text-decoration: none;
            white-space: nowrap;
        }

        .button:hover, button:hover { background: var(--accent-dark); }
        .button.secondary { background: #374151; }
        .button.secondary:hover { background: #1f2937; }
        .button.danger { background: var(--danger); }
        button.danger { background: var(--danger); }

        form.inline { display: inline; }

        .form {
            padding: 22px;
            display: grid;
            gap: 18px;
        }

        label {
            display: grid;
            gap: 7px;
            font-weight: 800;
        }

        input, select {
            width: 100%;
            min-height: 42px;
            border: 1px solid #c8d0dc;
            border-radius: 6px;
            padding: 9px 11px;
            font: inherit;
            background: #fff;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 16px;
        }

        .error {
            color: var(--danger);
            font-weight: 700;
            font-size: .9rem;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            border-radius: 999px;
            min-height: 28px;
            padding: 0 10px;
            font-size: .82rem;
            font-weight: 800;
            background: #e0f2fe;
            color: #075985;
        }

        .empty {
            padding: 34px;
            text-align: center;
        }

        .details {
            padding: 24px;
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 18px;
        }

        .metric {
            border: 1px solid var(--line);
            border-radius: 8px;
            padding: 16px;
            background: #fbfdff;
        }

        .metric span {
            display: block;
            color: var(--muted);
            font-size: .78rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: .08em;
            margin-bottom: 6px;
        }

        .warning {
            padding: 22px;
            display: grid;
            gap: 18px;
        }

        .warning-box {
            border: 1px solid #fecaca;
            border-radius: 8px;
            background: #fff7f7;
            color: #7f1d1d;
            padding: 16px;
        }

        @media (max-width: 760px) {
            .bar, .toolbar, .actions { align-items: flex-start; flex-direction: column; }
            nav a { margin: 0 14px 0 0; }
            .grid, .details { grid-template-columns: 1fr; }
            table, thead, tbody, th, td, tr { display: block; }
            thead { display: none; }
            td { border-bottom: 0; padding: 9px 14px; }
            tr { border-bottom: 1px solid var(--line); padding: 10px 0; }
            tr:last-child { border-bottom: 0; }
            td::before {
                content: attr(data-label);
                display: block;
                color: var(--muted);
                font-size: .76rem;
                font-weight: 800;
                text-transform: uppercase;
                letter-spacing: .08em;
                margin-bottom: 3px;
            }
        }
    </style>
</head>
<body>
    <header>
        <div class="bar">
            <div class="brand">PHP MVC Inventory</div>
            <nav>
                <a href="/products">Products</a>
                <a href="/products/create">Add Product</a>
            </nav>
        </div>
    </header>
    <main>
        <?= $content ?>
    </main>
</body>
</html>
