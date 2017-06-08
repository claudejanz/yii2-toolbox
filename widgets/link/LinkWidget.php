<?php

use yii\helpers\Html;
use yii\widgets\InputWidget;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of LinkWidget
 *
 * @author Claude Janz <claude.janz@klod.ch>
 */
class LinkWidget extends InputWidget
{
    public $attribute = 'params';
    public function init()
    {
        parent::init();
        $this->value = unserialize($this->model->{$this->attribute});
    }
    public function run()
    {
        echo Html::activeHiddenInput($this->model, $this->attribute);
    }
}
