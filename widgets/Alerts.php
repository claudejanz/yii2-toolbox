<?php

/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace claudejanz\toolbox\widgets;

use claudejanz\toolbox\widgets\base\YiiWidget;
use kartik\widgets\Alert;
use Yii;

/**
 * Alert widget renders a message from session flash. All flash messages are displayed
 * in the sequence they were assigned using setFlash. You can set message as following:
 *
 * ```php
 * \Yii::$app->getSession()->setFlash('error', 'This is the message');
 * \Yii::$app->getSession()->setFlash('success', 'This is the message');
 * \Yii::$app->getSession()->setFlash('info', 'This is the message');
 * ```
 *
 * Multiple messages could be set as follows:
 *
 * ```php
 * \Yii::$app->getSession()->setFlash('error', ['Error 1', 'Error 2']);
 * ```
 *
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @author Alexander Makarov <sam@rmcreative.ru>
 */
class Alerts extends YiiWidget
{

    /**
     * @var array the options for rendering the close button tag.
     */
    public $closeButton = [];

    public function init()
    {
        parent::init();

        $session = Yii::$app->getSession();
        $flashes = $session->getAllFlashes();
        $appendCss = isset($this->options['class']) ? ' ' . $this->options['class'] : '';
        $valid = [Alert::TYPE_INFO, Alert::TYPE_DANGER, Alert::TYPE_SUCCESS, Alert::TYPE_WARNING, Alert::TYPE_PRIMARY, Alert::TYPE_DEFAULT, Alert::TYPE_CUSTOM];

        $i = 1;
        foreach ($flashes as $type => $data) {
            if (in_array($type, $valid)) {
                $data = (array) $data;
                foreach ($data as $message) {
                    echo Alert::widget([
                        'type'  => $type,
                        'body'  => $message,
                        'delay' => (3000 * $i),
                    ]);
                    $i++;
                }

                $session->removeFlash($type);
            }
        }
    }

}
