<?php

namespace claudejanz\toolbox\models\behaviors;

use app\models\Layout;
use app\models\Place;
use yii\base\Behavior;
use yii\db\ActiveRecord;

/**
 * @author Janz
 *
 */
class AutoPlaceBehavior extends Behavior {

    public function events() {
        return [
            ActiveRecord::EVENT_AFTER_INSERT => 'afterSave',
        ];
    }

    public $path_elements = array(
    );

    public function afterSave($event) {
        $model = $this->owner;
        $es = $this->path_elements[$model->path];
        foreach ($es as $value) {
            $place = new Place();
            $place->title = $value;
            $place->layout_id = $model->id;
            $place->save();
        }
    }

}
