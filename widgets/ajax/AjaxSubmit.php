<?php

namespace claudejanz\toolbox\widgets\ajax;

use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\JsExpression;

/**
 * AjaxSubmit renders an ajax submit.
 * @author Claude Janz <claudejanz@gmail.com>
 */
class AjaxSubmit extends Widget
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
            $this->ajaxOptions['type'] = new JsExpression('$(this).parents("form").attr("method")');
        }

        if (!isset($this->ajaxOptions['url'])) {
            $this->ajaxOptions['url'] = new JsExpression('$(this).parents("form").attr("action")');
        }

        if (!isset($this->ajaxOptions['data']) && isset($this->ajaxOptions['type']))
            $this->ajaxOptions['data'] = new JsExpression('$(this).parents("form").serialize()');

//        if (!isset($this->ajaxOptions['always']))
//            $this->ajaxOptions['always'] = new JsExpression('function(){console.log("coucou");}');

        $this->ajaxOptions = Json::encode($this->ajaxOptions);
        $view->registerJs("$('#" . $this->options['id'] . "').click(function() {
                $.ajax($this->ajaxOptions).done(function (data) {
                    $('#modal').modal('hide');
                    if($('#modal').data('target').data('success')){
                        $.pjax.reload($($('#modal').data('target').data('success')),{timeout:false});
                    }
                })
                .fail(function (data) {
                    $('#modalContent').html(data.responseJSON.message);
                })
               
                return false;
            });");
    }

}
