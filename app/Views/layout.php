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
            --text: #222;
            --muted: #555;
            --border: #bbb;
            --page: #f2f6fa;
            --primary: #2f6f9f;
            --primary-dark: #255a82;
            --danger: #b00020;
        }

        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            color: var(--text);
            background: var(--page);
        }

        header {
            background: var(--primary);
            color: #fff;
            border-bottom: 2px solid var(--primary-dark);
        }

        .bar, main {
            width: min(1050px, calc(100% - 24px));
            margin: 0 auto;
        }

        .bar {
            min-height: 58px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }

        .brand {
            font-size: 1.05rem;
            font-weight: bold;
        }

        nav a {
            color: #fff;
            text-decoration: none;
            font-weight: bold;
            margin-left: 14px;
        }

        main { padding: 24px 0 40px; }

        .toolbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            margin-bottom: 16px;
        }

        h1 { margin: 0; font-size: 1.8rem; }
        p { color: var(--muted); line-height: 1.4; }

        .panel {
            background: #fff;
            border: 1px solid var(--border);
            overflow: hidden;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 10px 12px;
            text-align: left;
            border-bottom: 1px solid var(--border);
            vertical-align: middle;
        }

        th {
            color: #fff;
            background: var(--primary);
        }

        tr:last-child td { border-bottom: 0; }

        .actions {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
            align-items: center;
        }

        .button, button {
            appearance: none;
            border: 1px solid var(--primary-dark);
            background: var(--primary);
            color: #fff;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 34px;
            padding: 0 12px;
            font: inherit;
            font-weight: bold;
            text-decoration: none;
            white-space: nowrap;
        }

        .button:hover, button:hover { background: var(--primary-dark); }
        .button.secondary { background: #666; border-color: #444; }
        .button.secondary:hover { background: #444; }
        .button.danger { background: var(--danger); }
        button.danger { background: var(--danger); border-color: #8a0018; }

        form.inline { display: inline; }

        .form {
            padding: 16px;
            display: grid;
            gap: 14px;
        }

        label {
            display: grid;
            gap: 5px;
            font-weight: bold;
        }

        input, select {
            width: 100%;
            min-height: 36px;
            border: 1px solid var(--border);
            padding: 7px 9px;
            font: inherit;
            background: #fff;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 12px;
        }

        .error {
            color: var(--danger);
            font-weight: bold;
            font-size: .9rem;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            min-height: 24px;
            padding: 0 8px;
            font-size: .82rem;
            font-weight: bold;
            background: #d9edf7;
            color: #245269;
            border: 1px solid #9acfea;
        }

        .empty {
            padding: 24px;
            text-align: center;
        }

        .details {
            padding: 16px;
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 12px;
        }

        .metric {
            border: 1px solid var(--border);
            padding: 12px;
            background: #f9f9f9;
        }

        .metric span {
            display: block;
            color: var(--muted);
            font-size: .85rem;
            font-weight: bold;
            margin-bottom: 6px;
        }

        .warning {
            padding: 16px;
            display: grid;
            gap: 14px;
        }

        .warning-box {
            border: 1px solid #d88;
            background: #ffecec;
            color: #800;
            padding: 12px;
        }

        @media (max-width: 760px) {
            .bar, .toolbar, .actions { align-items: flex-start; flex-direction: column; }
            nav a { margin: 0 14px 0 0; }
            .grid, .details { grid-template-columns: 1fr; }
            table, thead, tbody, th, td, tr { display: block; }
            thead { display: none; }
            td { border-bottom: 0; padding: 9px 14px; }
            tr { border-bottom: 1px solid var(--border); padding: 10px 0; }
            tr:last-child { border-bottom: 0; }
            td::before {
                content: attr(data-label);
                display: block;
                color: var(--muted);
                font-size: .8rem;
                font-weight: bold;
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
