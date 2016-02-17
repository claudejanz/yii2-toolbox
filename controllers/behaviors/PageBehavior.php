<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace claudejanz\toolbox\controllers\behaviors;

use app\models\Page;
use Yii;
use yii\base\Behavior;
use yii\web\Controller;

/**
 * Description of PageFilter
 *
 * @author Claude Janz <claude.janz@gmail.com>
 */
class PageBehavior extends Behavior {

    /**
     * @var array this property defines the allowed actions.
     * If * is submitted it applies to all actions.
     * If nothing is submitted it applies to no action.
     *
     * For example,
     *
     * ~~~
     * ['create, 'update', 'delete']
     * ~~~
     */
    public $actions = [];

    public function events() {
        return [Controller::EVENT_BEFORE_ACTION => 'beforeAction'];
    }

    public function beforeAction($event) {
        $controller = $this->owner;
        $action_id = $controller->action->id;
        if (is_string($this->actions)) {
            $this->actions = (Array) $this->actions;
        }
        $all = ($this->actions[0] == '*') ? true : false;
        if ($all || in_array($action_id, $this->actions)) {
            $this->setPage();
        }
        $this->_page = $this->getPage();
        return $event->isValid;
    }

    private $_page;

    public function setPage($params = null) {
        $controller = $this->owner;
        if (!isset($this->_page)) {
            if ($params instanceof Page) {
                $this->_page = $params;
            } elseif ($params !== null) {
                $serialized_params = serialize($params);
                $this->_page = Page::find()->where(['controller' => $controller->id, 'action' => $controller->action->id, 'params' => $serialized_params])->one();
                if ($this->_page == null)
                    $this->_page = $this->autoCreatePage($serialized_params);
            }else {
                $this->_page = Page::find()->where(['controller' => $controller->id, 'action' => $controller->action->id])->one();
                if ($this->_page == null)
                    $this->_page = $this->autoCreatePage();
            }
        }
        return $this->_page;
    }

    /**
     * @return Page
     */
    public function getPage() {

        if ($this->_page == null) {
            $controller = $this->owner;
            
            if ($controller->id == 'pages' && $controller->action->id == 'view') {
                //get request params
                $queryParams = Yii::$app->getRequest()->getQueryParams();
                $this->_page = Page::find()->where(array('controller' => $controller->id, 'action' => $controller->action->id, 'id' => $queryParams['id']))->one();
            }
            if ($this->_page == null) {
                $this->_page = Page::find()->where(array('controller' => $controller->id, 'action' => $controller->action->id))->one();
            }
            if ($this->_page == null) {
                $this->_page = $this->autoCreatePage(null, false);
            }
        }
        $this->owner->layout = $this->_page->layout->path;
        return $this->_page;
    }

    public function autoCreatePage($serialized_params = null, $saveIt = true) {
        $page = new Page;
        $page->scenario = 'autoCreate';
        if ($serialized_params != null)
            $page->params = $serialized_params;

        // validate to set values from validation default
        if (!$page->validate()) {
            var_dump($page->errors);
            die();
        }
        // save if asked
        if ($saveIt && !$page->save())
            var_dump($page->errors);


        return $page;
    }

    //public function bef
}
