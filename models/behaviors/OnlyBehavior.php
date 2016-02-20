<?php

namespace claudejanz\toolbox\models\behaviors;

use yii\base\Behavior;
use yii\db\ActiveRecord;

/**
 * @author Janz
 *
 */
class OnlyBehavior extends Behavior {
    public $field='home_page';
    public function events() {
        return [
            ActiveRecord::EVENT_AFTER_INSERT => 'afterSave',
            ActiveRecord::EVENT_AFTER_UPDATE => 'afterSave',
        ];
    }

   

    public function afterSave($event) {
        $model = $this->owner;
        /* @var $model ActiveRecord */
        if($model->{$this->field}){
            $model->updateAll([$this->field=>null],['not in','id',[$model->id]]);
        }
    }

}
