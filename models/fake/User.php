<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace claudejanz\toolbox\models\fake;

use yii\base\Component;
use yii\web\IdentityInterface;

class User extends Component implements IdentityInterface
{

    public $isGuest = false;

    public function getAuthKey() {
        
    }

    private $_id = 1;

    public function getId() {
        return $this->_id;
    }

    public function setId($id) {
        $this->_id = $id;
   }

    public function validateAuthKey($authKey) {
        return true;
    }

    public static function findIdentity($id) {
        $this->getId();
    }

    public static function findIdentityByAccessToken($token, $type = null) {
        
    }

    public function can($rule){
        return true;
    }

}
