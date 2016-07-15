<?php

namespace claudejanz\toolbox\models\behaviors;

use yii\base\Behavior;
use yii\db\ActiveRecord;
use yii\db\Query;

/**
 * Description of WeightDefaultBehavior
 *
 * @author Claude
 */
class WeightDefaultBehavior extends Behavior 
{
   public $weightField = 'weight';
    
    public function events() {
        return [
            ActiveRecord::EVENT_BEFORE_VALIDATE => 'beforeValidate',
        ];
    }

    public function beforeValidate($event) {
        $model = $this->owner;
        if (!isset($model->{$this->weightField})) {
            $result = (new Query())
    ->select(['MAX('.$this->weightField.')'])
    ->from($this->owner->tableName())
    ->scalar()+1;
            $model->{$this->weightField} = $result;
        }
    }
}
