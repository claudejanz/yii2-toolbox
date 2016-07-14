Usage
-----
```php
$models = PageImage::findAll(['page_id'=>$id]);

echo MySortable::widget([
    'options'  => ['id' => 'pages-images-order'],
    'items'    => $models,
    'url'      => ['pages/save-page-images-order', 'id' => Yii::$app->request->queryParams['id']],
    'itemView' => '/page-images/orderView',
]);
```