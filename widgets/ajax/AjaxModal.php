<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace claudejanz\toolbox\widgets\ajax;

use claudejanz\toolbox\widgets\ajax\ajaxModal\AjaxModalAsset;
use kartik\icons\Icon;
use yii\bootstrap\Modal;
use yii\web\JsExpression;

/**
 * Description of AjaxModal
 *
 * @author Claude
 */
class AjaxModal extends Modal
{

    public function init()
    {
        parent::init();
        AjaxModalAsset::register($this->view);
    }

    public static function widget($config = [])
    {
        $config = array_merge([
            'header'=> '<span id="modalHeaderTitle"></span>',
            'headerOptions' => ['id' => 'modalHeader'],
            'id' => 'modal',
            'size' => 'modal-lg',
            //keeps from closing modal with esc key or by clicking out of the modal.
            // user must click cancel or X to close
            'clientOptions' => ['backdrop' => 'static', 'keyboard' => FALSE],
            'clientEvents' => ['hidden.bs.modal' => new JsExpression('function(){$(\'#modalContent\').html(\'<i class="fa fa-refresh fa-spin"></i>\');}')]
                ], $config);
        return parent::widget($config);

//        $this->headerOptions = ['id' => 'modalHeader'];
//        $this->id = 'modal';
//        $this->size = 'modal-lg';
//        //keeps from closing modal with esc key or by clicking out of the modal.
//        // user must click cancel or X to close
//        $this->clientOptions = ['backdrop' => 'static', 'keyboard' => FALSE];
    }

    public function run()
    {
        Icon::map($this->view,Icon::FA);
        echo "<div id='modalContent'>".Icon::show('refresh fa-spin', [], Icon::FA)."</div>";
//        echo "".Icon::show('refresh fa-spin', [], Icon::FA)."";
        parent::run();
    }

}
