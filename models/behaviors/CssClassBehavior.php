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

    
   const CLASSCSS_DEFAULT = 'default';
    const CLASSCSS_PRIMARY = 'primary';
    const CLASSCSS_SUCCESS = 'success';
    const CLASSCSS_INFO = 'info';
    const CLASSCSS_WARNING = 'warning';
    const CLASSCSS_DANGER = 'danger';

    /**
     * @return array classcss names indexed by classcss IDs
     */
    public static function getClassCssTextOptions() {
        return array(
            self::CLASSCSS_DEFAULT => Yii::t('claudejanz', 'Default'),
            self::CLASSCSS_PRIMARY => Yii::t('claudejanz', 'Primary'),
            self::CLASSCSS_SUCCESS => Yii::t('claudejanz', 'Success'),
            self::CLASSCSS_INFO => Yii::t('claudejanz', 'Info'),
            self::CLASSCSS_WARNING => Yii::t('claudejanz', 'Warning'),
            self::CLASSCSS_DANGER => Yii::t('claudejanz', 'Danger'),
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
