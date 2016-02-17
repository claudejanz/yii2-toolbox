<?php

namespace claudejanz\toolbox\models\behaviors;

use yii\base\Behavior;
use yii\db\ActiveRecord;

/**
 * @author Janz
 *
 */
class HomePageBehavior extends Behavior {

    public function events() {
        return [
            ActiveRecord::EVENT_AFTER_INSERT => 'afterSave',
            ActiveRecord::EVENT_AFTER_UPDATE => 'afterSave',
        ];
    }

   

    public function afterSave($event) {
        $model = $this->owner;
        /* @var $model ActiveRecord */
        if($model->home_page){
            $model->updateAll(['home_page'=>null],['not in','id',[$model->id]]);
        }
    }

}
