<?php

namespace claudejanz\toolbox\models\behaviors;

use Yii;
use yii\base\Behavior;
use yii\db\ActiveRecord;

/**
 * @author Janz
 *
 */
class PublishBehavior extends Behavior
{

    public $field = 'published';
    public $value = self::PUBLISHED_ACTIF;

    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_VALIDATE => 'beforeValidate',
        ];
    }

    public function beforeValidate($event)
    {
        $model = $this->owner;
        if (empty($model->{$this->field}))
            $model->{$this->field} = $this->value;
    }

    const PUBLISHED_DRAFT = 1;
    const PUBLISHED_VALIDATED = 2;
    const PUBLISHED_ACTIF = 3;
    const PUBLISHED_DELETED = 4;

    /**
     * @return array published names indexed by published IDs
     */
    public static function getPublishedOptions()
    {
        return array(
            self::PUBLISHED_DRAFT => Yii::t('claudejanz', 'Draft'),
            self::PUBLISHED_VALIDATED => Yii::t('claudejanz', 'Validate'),
            self::PUBLISHED_ACTIF => Yii::t('claudejanz', 'Actif'),
            self::PUBLISHED_DELETED => Yii::t('claudejanz', 'Archived'),
        );
    }

    public static function getPublishedColors()
    {
        return array(
            self::PUBLISHED_DRAFT => 'danger',
            self::PUBLISHED_VALIDATED => 'warning',
            self::PUBLISHED_ACTIF => 'success',
            self::PUBLISHED_DELETED => 'info'
        );
    }

    /**
     * @return string display text for the current Published
     */
    public function getPublishedLabel()
    {
        $model = $this->owner;
        $publishedOptions = self::getPublishedOptions();
        return isset($publishedOptions[$model->published]) ? $publishedOptions[$model->published] : "unknown published ($model->published)";
    }

    /**
     * @return string display text for the current Published
     */
    public function getPublishedColor()
    {
        $model = $this->owner;
        $publishedOptions = self::getPublishedColors();
        return isset($publishedOptions[$model->published]) ? $publishedOptions[$model->published] : "unknown published ($model->published)";
    }

}
