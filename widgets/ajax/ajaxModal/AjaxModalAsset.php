<?php
namespace claudejanz\toolbox\widgets\ajax\ajaxModal;

use yii\web\AssetBundle;



/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AjaxModalAsset
 *
 * @author Claude
 */
class AjaxModalAsset extends AssetBundle
{
   public $sourcePath = '@vendor/claudejanz/yii2-toolbox/widgets/ajax/ajaxModal/js';
   public $js = [
        'ajaxModal.js',
    ];
    
    public $depends = [
        'yii\web\JqueryAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
    
    public $publishOptions=['forceCopy'=>true];
}
