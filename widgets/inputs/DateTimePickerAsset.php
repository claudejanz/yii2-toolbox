<?php

/*
 * @link https://www.klod.ch/ 
 * @copyright Copyright (c) 2017 Klod SA
 * @author Claude Janz <claude.janz@klod.ch>
 */

namespace claudejanz\toolbox\widgets\input;

use yii\web\AssetBundle;



class DateTimePickerAsset extends AssetBundle
{
    public $sourcePath = '@vendor/eternicode/bootstrap-datepicker/dist';
    public $js = [
        'bootstrap-datepicker.min.js',
    ];
    
    public $depends = [
        'yii\web\JqueryAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}