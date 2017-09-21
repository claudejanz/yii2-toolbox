<?php

namespace claudejanz\toolbox\widgets\inputs;

use claudejanz\toolbox\widgets\base\YiiInputWidget;
use kartik\helpers\Html;
use Yii;
use yii\helpers\Json;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PublishWidget
 *
 * @author Claude
 */
class BooleanWidget extends YiiInputWidget
{

    public $items;
    public $colors;

    function init()
    {
        if (!$this->items) {
            $this->items = [1 => Yii::t('claudejanz', 'Yes'), 0 => Yii::t('claudejanz', 'No')];
        }
        if (!$this->items) {
            $this->colors = [1=>'btn-primary',0=>'btn-danger'];
        }
        parent::init();
    }

    function run()
    {
        parent::run();

        $wid = $this->options['id'];

        $model = $this->model;
        $attribute = $this->attribute;
        echo Html::activeHiddenInput($model, $attribute, $this->options);

        echo Html::beginTag('div', ['id' => $wid . '-buttons', 'class' => 'input-group btn-group']);
        foreach ($this->items as $key => $item) {
            echo Html::button($item, ['data' => ['value' => $key], 'class' => (isset($model->$attribute) && $key == $model->$attribute ? 'btn ' . $this->colors[$key] . ' active' : 'btn btn-default')]);
        }
        echo Html::endTag('div');
        $js_colors = Json::encode($this->colors);
        $js = <<<JS
 $('#{$wid}-buttons').find('button').each(function(){
   $(this).on('click',function(){
     $('#{$wid}-buttons').find('button').each(function(){
        $(this).removeClass('btn-primary btn-danger btn-warning btn-success btn-info active');
        $(this).addClass('btn-default');
     });
     var color=$js_colors;
     $(this).removeClass('btn-default');
     $(this).addClass(''+color[$(this).data('value')]+' active');
     console.log(color[$(this).data('value')]);
     $('#{$wid}').val($(this).data('value'));
     $('#{$wid}')[0].onchange();
   });  
});               
JS;
        $this->view->registerJs($js);
    }

}
