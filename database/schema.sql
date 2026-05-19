CREATE TABLE IF NOT EXISTS products (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL,
    sku TEXT NOT NULL UNIQUE,
    quantity INTEGER NOT NULL DEFAULT 0,
    price REAL NOT NULL,
    status TEXT NOT NULL DEFAULT 'in_stock',
    created_at TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO products (name, sku, quantity, price, status)
SELECT 'Mechanical Keyboard', 'KEY-001', 12, 2899.00, 'in_stock'
WHERE NOT EXISTS (SELECT 1 FROM products WHERE sku = 'KEY-001');

INSERT INTO products (name, sku, quantity, price, status)
SELECT 'USB-C Dock', 'DOCK-042', 3, 1999.00, 'low_stock'
WHERE NOT EXISTS (SELECT 1 FROM products WHERE sku = 'DOCK-042');

INSERT INTO products (name, sku, quantity, price, status)
SELECT 'Wireless Mouse', 'MSE-777', 0, 899.00, 'out_of_stock'
WHERE NOT EXISTS (SELECT 1 FROM products WHERE sku = 'MSE-777');
