
# CSS Cheatcode — Centering Utilities

Quick helpers and examples to center tables, content areas, buttons and forms tailored to this project.

## Utilities

- Horizontal center (block-level):

```css
.center { margin: 0 auto; }
```

- Flex center both axes:

```css
.center-flex {
	display: flex;
	justify-content: center;
	align-items: center;
}
```

## Page / content area

Use an inner wrapper inside your `<main>` to constrain and center the page content (matches your `layout.php` sizing):

```css
.main-inner {
	max-width: 1050px;
	margin: 0 auto;
	padding: 24px;
}
```

Wrap views like `products/index.php` with `<div class="main-inner">…</div>` if needed.

## Table centering

- Center a narrow table horizontally:

```css
.table-centered {
	width: auto; /* shrink to content */
	margin: 0 auto;
	border-collapse: collapse;
}
```

- If table is full-width, center text inside cells instead:

```css
.table-centered th,
.table-centered td { text-align: center; }
```

## Button centering

- Center a single button inside a block:

```css
.button.center { display: inline-block; margin: 0 auto; }
```

- Center a group of buttons:

```css
.actions { display:flex; justify-content:center; gap:8px; }
```

## Form / card centering

```css
.form-wrapper {
	max-width: 640px;
	margin: 0 auto;
	padding: 16px;
}
```

Use this for `products/form.php` or confirmation cards.

## Vertical + horizontal center (viewport)

```css
.center-vh {
	min-height: calc(100vh - 120px); /* adjust for header/footer */
	display: flex;
	justify-content: center;
	align-items: center;
	flex-direction: column;
}
```

## Responsive tweaks

```css
@media (max-width:760px) {
	.table-centered { width: 100%; margin: 0; }
	.form-wrapper { padding: 12px; }
}
```

## Project-specific suggestions

- Add `.main-inner` inside the existing `<main>` in [app/Views/layout.php](app/Views/layout.php#L249-L251) to use a consistent centered container.
- For confirm dialogs and centered buttons use `.actions { justify-content:center }` in the view HTML.
- Add a small `assets/styles.css` and include it from `layout.php` if you prefer keeping styles external instead of inline.

----
If you want I can apply these classes to your views and add an `assets/styles.css` file and load it from `layout.php`.

