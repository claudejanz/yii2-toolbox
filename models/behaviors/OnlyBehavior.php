<?php

namespace claudejanz\toolbox\models\behaviors;

use yii\base\Behavior;
use yii\db\ActiveRecord;

/**
 * @author Janz
 *
 */
class OnlyBehavior extends Behavior
{

    public $field = '';
    public $sameFields = [];

    public function init()
    {
        if(!isset($this->field))throw new InvalidConfigException(Yii::t('claudejanz','the "{name}" must be set for "{class}".',['name'=>'field','class'=>__CLASS__]));
        if(!is_array($this->sameFields))throw new InvalidConfigException(Yii::t('claudejanz','the "{name}" must be an array for "{class}".',['name'=>'field','class'=>__CLASS__]));
    }

    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_INSERT => 'afterSave',
            ActiveRecord::EVENT_AFTER_UPDATE => 'afterSave',
        ];
    }

    public function afterSave($event)
    {
        /* @var $model ActiveRecord */
        $model = $this->owner;
        if ($model->{$this->field}) {
            $conditions = ['not in', 'id', [$model->id]];
            if (!empty($this->sameFields)) {
                $conditions = ['and', $conditions];
                foreach ($this->sameFields as $field) {
                    $conditions[] = [$field => $model->{$field}];
                }
            }
            $model->updateAll([$this->field => null], $conditions);
        }
    }

}
