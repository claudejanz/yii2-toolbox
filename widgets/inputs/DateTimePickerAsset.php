<?php

/*
 * @link https://www.klod.ch/ 
 * @copyright Copyright (c) 2017 Klod SA
 * @author Claude Janz <claude.janz@klod.ch>
 */

namespace claudejanz\toolbox\widgets\inputs;

use yii\web\AssetBundle;



class DateTimePickerAsset extends AssetBundle
{
    public $sourcePath = '@bower/eonasdan-bootstrap-datetimepicker/build';
    public $js = [
        'js/bootstrap-datetimepicker.min.js',
    ];
    
    public $css = [
        'css/bootstrap-datetimepicker.min.css',
    ];
    public $depends = [
        'claudejanz\yii2moment\MomentAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\web\JqueryAsset'
    ];
}