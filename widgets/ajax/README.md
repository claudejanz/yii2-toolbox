Ajax tools to work with bootstrap modal and pjax reload
=======================================================


Usage
-----

In Layout add Ajax Modal:

```html
<?= AjaxModal::widget(); ?>
```

In view:

```php

Pjax::begin(['id' => 'training' . $model->id, 'timeout' => false]);
echo $model->title;
echo AjaxButton::widget([
        'label' => Icon::show('pencil'),
        'encodeLabel' => false,
        'url' => [
            'users/planning-update',
            'id' => $user->id,
            'training_id' => $model->id
        ],
        'title' => Yii::t('app', 'Edit training: {title}', ['title' => $model->title]),
        'success' => '#training' . $model->id,
        'options' => [
            'class' => 'red',
        ],
    ]);
}

Pjax::end();

```

In form:

```php
use kartik\widgets\ActiveForm;

/* @var $form ActiveForm */

$form = ActiveForm::begin(['type'=>ActiveForm::TYPE_VERTICAL]); 

echo Form::widget([
    'model' => $model,
    'form' => $form,
    'columns' => 1,
    'attributes' => [
        'title'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Titre...', 'maxlength'=>1024]],
        'extra_comment'=>['type'=> Form::INPUT_TEXTAREA, 'options'=>['placeholder'=>'Enter Extra Comment...','rows'=> 6]],


    ]

]);
if(Yii::$app->request->isAjax){
    echo AjaxSubmit::widget([
        'label'=>$model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'),
        'options'=>[
            'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary'
        ]]);
}else{
    echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']);
    
}
ActiveForm::end();
```


In controller


```php
    public function behaviors()
    {
        return [
            'negociator' => [
                'class' => 'yii\filters\ContentNegotiator',
                'only' => ['planning-update'], // in a controller
                // if in a module, use the following IDs for user actions
                // 'only' => ['user/view', 'user/index']
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                    'text/html' => Response::FORMAT_HTML,
                ],
            ],
        ];
    }

    public function actionPlanningUpdate($id, $training_id)
    {
        $model = Training::findOne($training_id);
        if ($model->load(Yii::$app->request->post())) {
            if (Yii::$app->request->isAjax) {
                if ($model->validate()) {
                    return $model->save();
                } else {
                    throw new NotAcceptableHttpException($this->render('/trainings/update', [
                        'model' => $model,
                    ]));
                }
            } else {
                if ($model->save()) {
                    return $this->redirect(['planning', 'id' => $this->model->id]);
                }
            }
        }

        return $this->render('/trainings/update', [
                    'model' => $model,
        ]);
    }

```
[Back to Menu](https://github.com/claudejanz/yii2-toolbox/#features)