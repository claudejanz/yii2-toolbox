<?php

namespace claudejanz\toolbox\widgets\ajax;

use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\Url;

/**
 * AjaxSubmit renders an ajax submit.
 * @author Claude Janz <claudejanz@gmail.com>
 */
class AjaxButton extends Widget
{

    /**
     * @var array|string the url to execute.
     */
    public $url;
    
    public $ajaxOptions = [];

    /**
     * @var array the HTML attributes for the widget container tag.
     */
    public $options = [];

    /**
     * @var string the tag to use to render the button
     */
    public $tagName = 'button';

    /**
     * @var string the button label
     */
    public $label = 'Do Ajax';

    /**
     * @var boolean whether the label should be HTML-encoded.
     */
    public $encodeLabel = true;

    /**
     * @var string selector for update pjax
     */
    public $success;

    /**
     * Initializes the widget.
     */
    public function init()
    {
        parent::init();
        if (!$this->url) {
            $this->url = Url::to();
        }
        if (is_array($this->url)) {
            $this->url = Url::to($this->url);
        }
        if (!isset($this->options['id'])) {
            $this->options['id'] = $this->getId() . time();
        }
        if (!isset($this->options['type'])) {
            $this->options['type'] = 'button';
        }
    }

    public function run()
    {
        parent::run();

        echo Html::tag($this->tagName, $this->encodeLabel ? Html::encode($this->label) : $this->label, $this->options);


        $this->registerAjaxScript();
    }

    protected function registerAjaxScript()
    {
        $view = $this->getView();

        if (!isset($this->ajaxOptions['type'])) {
            $this->ajaxOptions['type'] = 'get';
        }

        if (!isset($this->ajaxOptions['url'])) {
            $this->ajaxOptions['url'] = $this->url;
        }
        if (!isset($this->ajaxOptions['dataType'])) {
            $this->ajaxOptions['dataType'] = 'json';
        }

        $this->ajaxOptions = Json::encode($this->ajaxOptions);
        $view->registerJs("$('#" . $this->options['id'] . "').click(function() {
                $.ajax($this->ajaxOptions).done(function (data) {
                    if(data.error == 1){
                        alert(data.message);
                    }else{
                        if(data.message){
                            alert(data.message);
                        }
                        " . (($this->success) ? "$.pjax.reload('$this->success',{timeout:false});" : 'alert(data);') . "
                    }
                })
                .fail(function (data) {
                    if(data.responseJSON){
                        alert(data.responseJSON.message);
                    }else if(data.responseText){
                        alert(data.responseText);
                    }else{
                        console.log(data);
                    }
                })
               
                return false;
            });");
    }

}
