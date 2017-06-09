<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace claudejanz\toolbox\widgets;

use claudejanz\toolbox\widgets\base\YiiWidget;




/**
 * Description of BootstrapPortlet
 *
 * @author Claude
 */
class BootstrapPortlet extends YiiWidget{
public $title;
public $content;
public $color = 'default';
public function init() {
    echo '<div class="panel panel-default panel-'.$this->color.'">';
        if ($this->title) {
            echo "<div class=\"panel-heading\">$this->title</div>";
        }
        echo "<div class=\"panel-body\">";
}

public function run() {
        echo "</div>";
        echo "</div>";
    }

}
