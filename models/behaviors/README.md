Usages
======

MultilingualBehavior,PublishBehavior,OnlyBehavior,FileBehavior,AutoSlugBehavior
----------

Widgets for inputs

```php
public function behaviors()
{
    return array(
        'ml' => [
            'class' => MultilingualBehavior::className(),
            'languages' => Yii::$app->params['langsNames'],
            'langClassName' => PageLang::className(), // or namespace/for/a/class/PostLang
            'langForeignKey' => 'page_id',
            'attributes' => [
                'title',
                'content',
                'meta_description',
                'meta_keywords',
                'breadcrumb_text',
                'slug',
            ]
        ],
        'publish' => [
            'class' => PublishBehavior::className(),
        ],
        
        'homePageBehavior' => [
            'class' => OnlyBehavior::className(),
            'field' => 'home_page'
        ],
        'fileBehavior' => [
            'class' => FileBehavior::className(),
            //'paths' => ['image2'=>'@webroot/images/all2/{id}/','@webroot/images/all/{id}/'],
            'paths' => '@webroot/images/pages/{id}/',
        ],
        'autoSlug' => [
            'class' => AutoSlugBehavior::className(),
            'addLanguage' => true,
        ],
    );
}
```

