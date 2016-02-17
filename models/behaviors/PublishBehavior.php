<?php

namespace claudejanz\toolbox\models\behaviors;

use Yii;
use yii\base\Behavior;

/**
 * @author Janz
 *
 */
class PublishBehavior extends Behavior {

    public $field = 'published';

    
    const PUBLISHED_DRAFT = 1;
    const PUBLISHED_VALIDATED = 2;
    const PUBLISHED_ACTIF = 3;
    const PUBLISHED_DELETED = 4;

    /**
     * @return array published names indexed by published IDs
     */
    public static function getPublishedOptions() {
        return array(
            self::PUBLISHED_DRAFT => Yii::t('core', 'Draft'),
            self::PUBLISHED_VALIDATED => Yii::t('core', 'Validate'),
            self::PUBLISHED_ACTIF => Yii::t('core', 'Actif'),
            self::PUBLISHED_DELETED => Yii::t('core', 'Archived'),
        );
    }

    /**
     * @return string display text for the current Published
     */
    public function getPublishedLabel() {
        $model = $this->owner;
        $publishedOptions = self::getPublishedOptions();
        return isset($publishedOptions[$model->id]) ? $publishedOptions[$model->id] : "unknown published ($model->id)";
    }

   


    

}
