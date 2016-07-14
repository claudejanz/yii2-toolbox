Usages
======

PublishWidget, BooleanWidget, CssClassWidget
----------

Widgets for inputs

```php
use kartik\widgets\ActiveForm;

/* @var $form ActiveForm */

$form = ActiveForm::begin(['type' => ActiveForm::TYPE_VERTICAL]);
echo Form::widget([
    'model' => $model,
    'form' => $form,
    'columns' => 2,
    'attributes' => [
        'published' => [
            'type' => Form::INPUT_WIDGET,
            'widgetClass' => PublishWidget::className(),
        ],
        'home_page' => [
            'type' => Form::INPUT_WIDGET,
            'widgetClass' => BooleanWidget::className(),
        ],
        'css_class' => [
            'type' => Form::INPUT_WIDGET,
            'widgetClass' => CssClassWidget::className(),
        ],

       
    ]
]);
ActiveForm::end();
```

