<?php

namespace claudejanz\toolbox\widgets\ajax;

use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Url;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AjaxButton
 *
 * @author Claude
 */
class AjaxButton extends Widget
{

    /**
     * @var array|string the url to get Form.
     */
    public $url;

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
    public $label = 'Edit';

    /**
     * @var string title of modal
     */
    public $title = 'Title';

    /**
     * @var string selector for update pjax
     */
    public $success ;

    /**
     * @var boolean whether the label should be HTML-encoded.
     */
    public $encodeLabel = true;

    public function init()
    {
        if (!$this->url) {
            $this->url = Url::to();
        }
        if (is_array($this->url)) {
            $this->url = Url::to($this->url);
        }
        Html::addCssClass($this->options, 'showModal');
        $this->options['data'] = [];
        $this->options['data']['url'] = $this->url;
        $this->options['data']['title'] = $this->title;
        if ($this->success) {
            $this->options['data']['success'] = $this->success;
        }

        parent::init();
    }

    public function run()
    {
        parent::run();
        echo Html::tag($this->tagName, $this->encodeLabel ? Html::encode($this->label) : $this->label, $this->options);
    }

}
