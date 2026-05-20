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

### Check IP
```php
$ip = $_SERVER['HTTP_CF_CONNECTING_IP'] ?? $_SERVER['REMOTE_ADDR'];
```

### Display errors
```php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL & ~E_DEPRECATED & ~E_NOTICE);
```

### Log errors
```php
ini_set('log_errors', 1);
ini_set('error_log', '/var/www/html/logs/php_errors.log');
error_log("TEST: log writable at ".date('Y-m-d H:i:s'));
```

### Reflection API
Reflection function:
```php
try {
	$ref = new ReflectionFunction('<function_name>');
	$trace .= $ref->isInternal()
		? $ref->getName()." [built-in]"
		: "File: ".$ref->getFileName()." (L".$ref->getStartLine().")";
}catch(ReflectionExecption $e){
	$trace .= "Err: ".$e->getMessage();
}
echo "<script>console.log(".json_encode($trace).")</script>";
```

Reflection class:
```php
$ref = new ReflectionClass('<class_name>');
$trace = [
	'class' => $ref->getName(),
	'file' => $ref->getFileName(),
	'methods' => [],
	'properties' => [],
];
foreach ($ref->getMethods() as $m) {
	$trace['methods'][] = [
		'name' => $m->getName(),
		'line' => $m->getStartLine(),
		'public' => $m->isPublic(),
		'static' => $m->isStatic(),
		'params' => array_map(fn($p) => $p->getName(), $m->getParameters()),
	];
}
foreach ($ref->getProperties() as $p) {
	$trace['properties'][] = [
		'name' => $p->getName(),
		'visibility' => $p->isPublic() ? 'public' : ($p->isProtected() ? 'protected' : 'private'),
		'static' => $p->isStatic(),
	];
}
echo "<script>console.log(".json_encode($trace, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE).")</script>";
```
- *`JSON_UNESCAPED_SLASHES` not escape*
- *`JSON_UNESCAPED_UNICODE` unicode*

### Functions included
```php
$inc_funcs = get_included_files();
echo "<script>console.log(".json_encode($inc_funcs).")</script>";
```

### Defined functions
```php
$funcs = get_defined_functions();
echo "<script>console.log(".json_encode($funcs).")</script>";
```