<?php

namespace claudejanz\toolbox\widgets\inputs;

use kartik\helpers\Html;
use Yii;
use yii\helpers\Json;
use yii\widgets\InputWidget;

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
class BooleanWidget extends InputWidget {

    function run() {
        parent::run();

        $wid = $this->options['id'];

        echo Html::activeHiddenInput($this->model, $this->attribute);

        echo Html::beginTag('div', ['id' => $wid . '-buttons', 'class' => 'input-group btn-group']);
        $items = [1=>Yii::t('app','Yes'),0=>Yii::t('app','No')];
        $colors =  ['btn-danger','btn-primary'];
        foreach ($items as $key => $item) {
            echo Html::button($item, ['data' => ['value' => $key], 'class' => ($key == $this->model->{$this->attribute} ? 'btn '.$colors[$key].' active' : 'btn btn-default')]);
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
     $(this).addClass(''+color[$(this).data('value')]+' active');
     console.log(color[$(this).data('value')]);
     $('#{$wid}').val($(this).data('value'))
   });  
});               
JS;
        $this->view->registerJs($js);
    }

}
