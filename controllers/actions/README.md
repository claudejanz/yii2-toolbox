Usages
======

SortableAction 
----------

Sorts Models

```php
public function actions()
{
    return [
        'save-page-images-order' => [
            'class' => 'claudejanz\toolbox\controllers\actions\SortableAction',
            //'scenario'=>'editable',  //optional
            'orderBy'=>'weight',
            'modelclass' => PageImage::className(),
        ],
    ];
}
```

[Back to Menu](https://github.com/claudejanz/yii2-toolbox/#features)