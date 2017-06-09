<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace claudejanz\toolbox\widgets\base;

/**
 * Description of TraitWidetId
 *
 * @author Claude
 */
trait TraitWidetId
{
    public function getId($autoGenerate = true)
    {
        if ($autoGenerate && $this->_id === null) {
            $this->_id = static::$autoIdPrefix . static::$counter++.time();
        }

        return $this->_id;
    }
}
