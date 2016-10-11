<?php

namespace claudejanz\toolbox\models\behaviors;

use yii\base\Behavior;
use yii\db\ActiveRecord;

/**
 * @author Janz
 *
 */
class RelatedBehavior extends Behavior
{
    /**
     * @var string to recive data from form. in format "Arzier, Genève"
     * If you change the variable name please also change the $textFieldName value to match this public var
     * Don't forget to set array('tags_text', 'safe') on $owner 
     */
    //public $tags_text;

    /**
     * @var string where to get tags from
     */
    public $relations = [];

    public function events() {
        return [

            ActiveRecord::EVENT_AFTER_INSERT => 'afterSave',
            ActiveRecord::EVENT_AFTER_UPDATE => 'afterSave',
        ];
    }

    public function afterSave($event) {

        $model = $this->owner;
        foreach ($this->relations as $relationName => $relationValues) {
            $model->unlinkAll($relationName, true);
            if (!empty($relationValues)) {

                $relation = $model->getRelation($relationName);
                $vias = $relation->via;

                $modelKey = key(end($vias)->link);
                $relationClassName = end($vias)->modelClass;
                $relationKey = current($relation->link);
                foreach ($relationValues as $value) {
                    if ($value instanceof ActiveRecord) {
                        $value = $value->primaryKey;
                    }
                    $attributes = [$modelKey => $model->primaryKey, $relationKey => $value];

                    $pivot = $relationClassName::find()->where($attributes)->one();
                    if (!$pivot) {
                        $pivot = new $relationClassName;
                        $pivot->attributes = $attributes;
                        $pivot->save();
                    }
                }
            }
        }
    }

    public static function string2array($tags) {
        return preg_split('/\s*,\s*/', trim($tags), -1, PREG_SPLIT_NO_EMPTY);
    }

    public static function array2string($tags) {
        return implode(', ', $tags);
    }

}
