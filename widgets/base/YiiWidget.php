<?php
namespace claudejanz\toolbox\widgets\base;
use yii\base\Widget;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of YiiWidget
 *
 * @author Claude
 */
class YiiWidget extends Widget
{
   public function getId($autoGenerate = true)
    {
        if ($autoGenerate && $this->_id === null) {
            $this->_id = static::$autoIdPrefix . static::$counter++.time();
        }

        return $this->_id;
    }
}
