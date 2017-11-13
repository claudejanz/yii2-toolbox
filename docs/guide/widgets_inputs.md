Usages
======

PublishWidget, BooleanWidget, CssClassWidget
----------

Widgets for inputs

```php
use kartik\widgets\ActiveForm;
use claudejanz\toolbox\widgets\inputs\PublishWidget
use claudejanz\toolbox\widgets\inputs\BooleanWidget
use claudejanz\toolbox\widgets\inputs\CssClassWidget
use claudejanz\toolbox\widgets\inputs\DateTimePicker

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
        'date_time' => [
            'type' => Form::INPUT_WIDGET,
            'widgetClass' => DateTimePicker::className(),
        ],

       
    ]
]);
ActiveForm::end();
```

[Back to Menu](README.md)

