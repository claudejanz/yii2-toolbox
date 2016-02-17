<?php

namespace claudejanz\toolbox\models\behaviors;

use Yii;
use yii\base\Behavior;

/**
 * @author Janz
 *
 */
class CssClassBehavior extends Behavior {

    public $field = 'published';

    
   const CLASSCSS_DEFAULT = 1;
    const CLASSCSS_PRIMARY = 2;
    const CLASSCSS_SUCCESS = 3;
    const CLASSCSS_INFO = 4;
    const CLASSCSS_WARNING = 5;
    const CLASSCSS_DANGER = 6;

    /**
     * @return array classcss names indexed by classcss IDs
     */
    public static function getClassCssTextOptions() {
        return array(
            self::CLASSCSS_DEFAULT => Yii::t('core', 'Default'),
            self::CLASSCSS_PRIMARY => Yii::t('core', 'Primary'),
            self::CLASSCSS_SUCCESS => Yii::t('core', 'Success'),
            self::CLASSCSS_INFO => Yii::t('core', 'Info'),
            self::CLASSCSS_WARNING => Yii::t('core', 'Warning'),
            self::CLASSCSS_DANGER => Yii::t('core', 'Danger'),
        );
    }
    /**
     * @return array classcss values indexed by classcss IDs
     */
    public static function getClassCssOptions() {
        return array(
            self::CLASSCSS_DEFAULT => 'default',
            self::CLASSCSS_PRIMARY => 'primary',
            self::CLASSCSS_SUCCESS => 'success',
            self::CLASSCSS_INFO => 'info',
            self::CLASSCSS_WARNING => 'warning',
            self::CLASSCSS_DANGER => 'danger',
        );
    }

    /**
     * @return string display text for the current ClassCss
     */
    public function getClassCssLabel() {
        $model = $this->owner;
        $options = self::getClassCssTextOptions();
        return isset($options[$model->class_css]) ? $options[$model->class_css] :'';
    }
    /**
     * @return string display text for the current ClassCss
     */
    public function getClassCssText() {
        $model = $this->owner;
        $options = self::getClassCssOptions();
        return isset($options[$model->class_css]) ? $options[$model->class_css] :'';
    }

   


    

}
