# PHP Local Deployment
index.php:
```
ini_set('session.cookie_secure', "0");

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

### Text truncate `...`
```css
style="max-width: 300px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;"
```

## Smarty

### Cache Busting
```
<link rel="stylesheet" href="style.css?v={time()}">
```

## Recaptcha + Validation.js
```php
// recaptcha v2
$recaptchaV2_public_key = "6LfDi9EsAAAAAN4caUJoTAfqukWbqBGyPwpMNxEW";
// $recaptchaV2_secret_key = "6LfDi9EsAAAAAMRHa8sivOBmN-GNRIkNTTk3FMpM";

$smarty->assign("recaptchaV2_public_key", $recaptchaV2_public_key);
```

```tpl
<script src="https://www.google.com/recaptcha/api.js" async defer></script>

<form id="dropleadContact" data-toggle="validator" class="form-default" method="post" autocomplete="off">
	<!-- ... -->
	<div class="row">
		<div id="recaptcha-content"
			class="g-recaptcha"
			data-callback="onRecaptchaSuccess"
			data-expired-callback="onRecaptchaExpired"
			data-sitekey="{$recaptchaV2_public_key}">
		</div>
		<div class="form-group has-feedback">
			<input type="text" name="g-recaptcha-form" id="g-recaptcha-response-content" style="display: none;" required>
		</div>
	</div>
</form>
```

```js
window.onRecaptchaSuccess = function(token) {
	const inputResponse = $('#g-recaptcha-response-content');
	inputResponse.val(token).trigger('change');
};

window.onRecaptchaExpired = function() {
	const inputResponse = $('#g-recaptcha-response-content');
	inputResponse.val('').trigger('change');
};

const recaptchaV2 = $(this).find('input[name="g-recaptcha-form"]').val();
if (recaptchaV2 !== grecaptcha.getResponse()) {
	return false
}
```