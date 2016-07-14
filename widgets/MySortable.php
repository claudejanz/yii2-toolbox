<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace claudejanz\toolbox\widgets;

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\jui\Sortable;
use yii\web\JsExpression;

/**
 * Description of MySortable
 *
 * @author Claude
 */
class MySortable extends Sortable
{

    public $url;
    public $itemView;
    public $key='order';

    public function init() {
        parent::init();
        if (empty($this->clientEvents)) {
            $this->clientEvents = [
                'update' => new JsExpression('function(event, ui){'
                        . 'var s=$(this).sortable("toArray");'
                        . '$.ajax({
                            data: {'.$this->key.' : $(this).sortable("toArray").toString()},
                            type: "POST",
                            url: "'.Url::to($this->url).'"
                        }).done(function( data ) {
            $("#'.$this->options['id'].'").siblings(".response").html(data);
});'
                        . '}'),
            ];
        }
    }
    public function run() {
        echo Html::tag('div','',['class'=>'response']);
        parent::run();
}

    public function renderItems()
    {
        $items = [];
//        die('ici');
        foreach ($this->items as $item) {
            $options = $this->itemOptions;
            $options['id'] =  $item->id;
            $tag = ArrayHelper::remove($options, 'tag', 'li');
            $content = $this->view->render($this->itemView, ['model' => $item]);
            $items[] = Html::tag($tag, $content, $options);
        }

        return implode("\n", $items);
    }

}
