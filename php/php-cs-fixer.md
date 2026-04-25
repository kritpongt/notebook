# PHP cs fixer

### Install
```
composer global require friendsofphp/php-cs-fixer
```

### Path executable file
```
composer global config bin-dir --absolute
```

## OpenSSL enable
```
php --ini
```
Edit php.ini file:
- search `extension_dir = "ext"` and then uncomment
- search `extension = openssl` and then uncomment
- search `extension = zip` and then uncomment

if `Loaded Configuration File: (none)`
1. go to php path file
2. copy `php.ini-development` and then rename it `php.ini`

## Error unknown cause
Edit file php.ini:
```
short_open_tag = On
```