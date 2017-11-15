<?php

/*
 * @link https://www.klod.ch/ 
 * @copyright Copyright (c) 2017 Klod SA
 * @author Claude Janz <claude.janz@klod.ch>
 */

namespace claudejanz\toolbox\widgets\inputs;

use claudejanz\toolbox\widgets\base\YiiInputWidget;

/**
 * Description of DateTimePicker
 *
 * @author Claude
 */
class DateTimePicker extends YiiInputWidget
{

    public $options = ['class' => 'form-control'];
    public $pluginOptions=[];
    public $type='text';

    public function run()
    {
        echo $this->renderInputHtml($this->type);
        $this->registerPlugin();
    }

    public function registerPlugin()
    {
        $view = $this->view;
        $id = $this->options['id'];
        DateTimePickerAsset::register($view);
        $pluginOptions = \yii\helpers\Json::encode($this->pluginOptions);
        $js="$('#$id').datetimepicker($pluginOptions);";
        $view->registerJs($js);
    }

}
