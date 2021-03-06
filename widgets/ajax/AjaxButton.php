<?php

namespace claudejanz\toolbox\widgets\ajax;

use claudejanz\toolbox\widgets\base\YiiWidget;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\JsExpression;

/**
 * AjaxSubmit renders an ajax submit.
 * @author Claude Janz <claudejanz@gmail.com>
 */
class AjaxButton extends YiiWidget
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
     * @var string to use for javascript confirm()
     */
    public $confirm = null;

    /**
     * the javascript function to be executed on done
     * @var JsExpression
     */
    public $done;

    /**
     * the javascript function to be executed on fail
     * @var JsExpression
     */
    public $fail;

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
        $confirmBegin = ($this->confirm) ? "if(confirm('$this->confirm')){" : '';
        $confirmEnd = ($this->confirm) ? "}" : '';




        if (!isset($this->done)) {
            $successCode = "";
            if ($this->success) {
                $all = preg_split('@#@', $this->success, -1, PREG_SPLIT_NO_EMPTY);
                if (count($all) > 1) {
                    foreach ($all as $value) {
                        $successCode .= "$.pjax.reload('#$value',{timeout:false,async:false});";
                    }
                } else {
                    $successCode .= "$.pjax.reload('$this->success',{timeout:false});";
                }
            }
            $this->done = new JsExpression("function (data) {
                    if(data.error == 1){
                        alert(data.message);
                    }else{
                       $successCode
                    }
                }");
        }
        if (!isset($this->fail)) {
            $this->fail = new JsExpression("function (data) {
                    if(data.responseJSON){
                        alert(data.responseJSON.message);
                    }else if(data.responseText){
                        alert(data.responseText);
                    }else{
                        console.log(data);
                    }
                }");
        }


        $view->registerJs("$('#" . $this->options['id'] . "').click(function(event) {
                $confirmBegin
                $.ajax($this->ajaxOptions).done($this->done).fail($this->fail)
                $confirmEnd   
                event.preventDefault();
                event.stopPropagation();
                return false;
            });");
    }

}
