<?php

namespace claudejanz\toolbox\widgets\inputs;

use claudejanz\toolbox\models\behaviors\CssClassBehavior;
use claudejanz\toolbox\widgets\base\YiiInputWidget;
use kartik\helpers\Html;
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
class CssClassWidget extends YiiInputWidget {

    function run() {
        parent::run();

        $wid = $this->options['id'];

        echo Html::activeHiddenInput($this->model, $this->attribute);

        echo Html::beginTag('div', ['id' => $wid . '-buttons', 'class' => 'input-group btn-group']);
        $items = CssClassBehavior::getClassCssTextOptions();
        $colors = CssClassBehavior::getClassCssOptions();
        foreach ($items as $key => $item) {
            echo Html::button($item, ['data' => ['value' => $key], 'class' => ($key == $this->model->{$this->attribute} ? 'btn btn-'.$colors[$key].' active' : 'btn btn-default')]);
        }
        echo Html::endTag('div');
        $js_colors = Json::encode($colors);
        $js = <<<JS
 $('#{$wid}-buttons').find('button').each(function(){
   $(this).on('click',function(){
     $('#{$wid}-buttons').find('button').each(function(){
        $(this).removeClass('btn-primary btn-danger btn-warning btn-success btn-info active');
        $(this).addClass('btn-default');
     });
     var color=$js_colors;
     $(this).removeClass('btn-default');
     $(this).addClass('btn-'+color[$(this).data('value')]+' active');
     $('#{$wid}').val($(this).data('value'))
   });  
});               
JS;
        $this->view->registerJs($js);
    }

}
