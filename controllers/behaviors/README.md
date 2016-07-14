Usages
======

PageBehavior 
----------

Finds or Creates a Page Model for controller

```php
public function behaviors()
{
    return [
        
        'page' => [
            'class' => PageBehavior::className(),
            'actions' => ['none']
        ],
        
    ];
}
```

