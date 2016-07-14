Usages
======

Request  
----------

This compents replaces standart Request to remove /web from url.

In web.php config file.
```php
'components' => [
    'request' => [
        'class' => 'claudejanz\toolbox\components\Request',
        'cookieValidationKey' => 'YAO0QHYbNUrODV0O7cH6M_9sbVzPiTIf',
        'web' => '/web',
    ],
],
```

