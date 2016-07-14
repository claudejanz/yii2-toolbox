Usages
======

MySortable
----------

This widget uses a "view" to render a list of models and make them sortable.
Sends ajax request on changes to given url.

```php
$models = PageImage::findAll(['page_id'=>$id]);

echo MySortable::widget([
    'options'  => ['id' => 'pages-images-order'],
    'items'    => $models,
    'url'      => ['pages/save-page-images-order', 'id' => Yii::$app->request->queryParams['id']],
    'itemView' => '/page-images/orderView',
]);
```

BootstrapPortlet
----------

Creates a bootstrap portlet around someting. 

```php
BootstrapPortlet::begin(array(
    'title' => 'title',
    'color' =>'danger',
));
echo 'content';
BootstrapPortlet::end();
```

Alerts
----------

Displays alert in bootstarp alert box. 

 - create an alert.

```php
Yii::$app->session->setFlash(
    \kartik\widgets\Alert::TYPE_INFO,
    Yii::t('app', 'Thanks for contacting us. We will respond shortly.')
);
```


 - put this in your main and it will display the message in a nice box in the right color.

```php
echo Alerts::widget();
```
[Back to Menu](https://github.com/claudejanz/yii2-toolbox/#features)