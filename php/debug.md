## PHP Debug

### Info
```php
phpinfo();
```

### Enable mod_rewrite
```
```

### Enable short open tag
php.ini:
```
short_open_tag = On
```

### Display error
```php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL & ~E_DEPRECATED & ~E_NOTICE);
```