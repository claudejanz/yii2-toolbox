<?php

namespace claudejanz\toolbox\widgets\ajax;

use claudejanz\toolbox\widgets\base\YiiWidget;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\JsExpression;

/**
 * AjaxSubmit renders an ajax submit.
 * @author Claude Janz <claudejanz@gmail.com>
 */
class AjaxSubmit extends YiiWidget
{

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
    public $label = 'Submit';

    /**
     * @var boolean whether the label should be HTML-encoded.
     */
    public $encodeLabel = true;

    /**
     * @var boolean whether the label should be HTML-encoded.
     */
    public $useFormData = true;

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
    public $addcode;

    /**
     * Initializes the widget.
     */
    public function init()
    {

        parent::init();
        if (!isset($this->options['id'])) {
            $this->options['id'] = $this->getId() . time();
        }
        if (!isset($this->options['type'])) {
            $this->options['type'] = 'submit';
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
            $this->ajaxOptions['type'] = new JsExpression('$(this).closest("form").attr("method")');
        }
        if (!isset($this->ajaxOptions['url'])) {
            $this->ajaxOptions['url'] = new JsExpression('$(this).closest("form").attr("action")');
        }
        if (!isset($this->ajaxOptions['dataType'])) {
            $this->ajaxOptions['dataType'] = 'json';
        }

        if (!isset($this->ajaxOptions['data']) && isset($this->ajaxOptions['type'])) {
            if (!isset($this->ajaxOptions['data'])) {
                if ($this->useFormData) {
                    if (isset($this->options['name']) && isset($this->options['value'])) {

                        $this->addcode = new JsExpression('
                            var d = new FormData($(this).closest("form")[0]);
                            d.append("' . $this->options['name'] . '","' . $this->options['value'] . '");
                            ');
//                        $this->ajaxOptions['data'] = new JsExpression('((new FormData($(this).closest("form")[0])).append("'.$this->options['name'].'","'.$this->options['value'].'"))');
                        $this->ajaxOptions['data'] = new JsExpression('d');
                        $this->ajaxOptions['processData'] = new JsExpression('false');
                    } else {
                        $this->ajaxOptions['data'] = new JsExpression('new FormData($(this).closest("form")[0])');
                        $this->ajaxOptions['processData'] = new JsExpression('false');
                    }
                    $this->ajaxOptions['contentType'] = new JsExpression('false');
                } else {
                    $this->ajaxOptions['data'] = new JsExpression('$(this).closest("form").serialize()');
                }
            }
        }

        if (!isset($this->done))
            $this->done = new JsExpression("function (data) {
                    $('#cjModal').modal('hide');
                    if (data.message) {
                        alert(data.message);
                    }
                    if($('#cjModal').data('target').data('success')){
                        var success =  $('#cjModal').data('target').data('success');
                        var indices = [];
                        for(var i=0; i<success.length;i++) {
                            if (success[i] === '#') indices.push(i);
                        }
                        if(indices.length>1){
                           for(var i=0; i<indices.length;i++) {
                                var end = (i!=indices.length-1)?indices[i+1]:success.length;
                                $.pjax.reload(success.substring(indices[i],end),{timeout:false,async:false});
                           }
                        }else{
                            $.pjax.reload(success,{timeout:false});
                        }
                    }
                }");
        if (!isset($this->fail))
            $this->fail = new JsExpression("function (data) { if (typeof(data.responseJSON) != 'undefined') { $('#cjModalContent').html(data.responseJSON.message);}}");

        $this->ajaxOptions = Json::encode($this->ajaxOptions);
        $view->registerJs("$('#" . $this->options['id'] . "').click(function(event) {
                $this->addcode
                $.ajax($this->ajaxOptions).done($this->done).fail($this->fail);
                    event.preventDefault();
                    event.stopPropagation();
                return false;
            });");
    }

}
