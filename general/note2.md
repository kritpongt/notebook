# PHP Local Deployment
index.php:
```
$path_root = ""
```

front/libs/config.php:
- constant `env`
- database

admin/lib/config.php:
- `$DB_ENV`
- database

# CSS

### Visual hidden

```css
.input-vh {
  position: absolute;
  width: 1px;
  height: 1px;
  padding: 0;
  margin: -1px;
  overflow: hidden;
  clip: rect(0, 0, 0, 0);
  white-space: nowrap;
  border-width: 0;
}
```

```html
<form action="/submit" method="POST">
  <input type="text" name="first_name" placeholder="First Name">

  <div class="input-vh" aria-hidden="true">
    <input type="text" name="username" id="" tabindex="-1" autocomplete="off">
  </div>

  <button type="submit">Send</button>
</form>
```

## Smarty

### Cache Busting
```
<link rel="stylesheet" href="style.css?v={time()}">
```

## Recaptcha + validation.js
```html
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
```