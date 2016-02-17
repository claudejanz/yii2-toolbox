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
        Layout::PATH_FULL => array(Place::PLACE_CONTENT_BEFORE, Place::PLACE_CONTENT_AFTER),
        Layout::PATH_COLUMN1 => array(Place::PLACE_CONTENT_BEFORE, Place::PLACE_CONTENT_AFTER),
        Layout::PATH_COLUMN2 => array(Place::PLACE_LEFT,Place::PLACE_CONTENT_BEFORE, Place::PLACE_CONTENT_AFTER),
        Layout::PATH_COLUMN3 => array(Place::PLACE_LEFT, Place::PLACE_CONTENT_BEFORE, Place::PLACE_CONTENT_AFTER, Place::PLACE_RIGHT),
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
