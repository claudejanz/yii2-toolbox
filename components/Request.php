<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace claudejanz\toolbox\components;


class Request extends \yii\web\Request {
    public $web;

    public function getBaseUrl(){
        return str_replace($this->web, "", parent::getBaseUrl());
    }
}

