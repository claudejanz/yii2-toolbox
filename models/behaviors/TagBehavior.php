<?php

namespace claudejanz\toolbox\models\behaviors;

use app\models\Tag;
use yii\base\Behavior;
use yii\db\ActiveRecord;

/**
 * @author Janz
 *
 */
class TagBehavior extends Behavior {
    /**
     * @var string to recive data from form. in format "Arzier, Genève"
     * If you change the variable name please also change the $textFieldName value to match this public var
     * Don't forget to set array('tags_text', 'safe') on $owner 
     */
    //public $tags_text;

    /**
     * @var string where to get tags from
     */
    private $_relationName = 'tags';

    /**
     * @var string where to get tags from
     */
    public $pivotClass = 'tags';

    /**
     * @var string Field name for incomming data
     */
    public $textFieldName = 'technologies';
    private $_oldTags = [];
    private $_toUpdate = [];
    private $_relatedTags = [];

    public function events() {
        return [
            ActiveRecord::EVENT_AFTER_FIND => 'afterFind',
            ActiveRecord::EVENT_BEFORE_INSERT => 'beforeSave',
            ActiveRecord::EVENT_BEFORE_UPDATE => 'beforeSave',
            ActiveRecord::EVENT_AFTER_INSERT => 'afterSave',
            ActiveRecord::EVENT_AFTER_UPDATE => 'afterSave',
        ];
    }

    public function afterFind($event) {
        if (isset($this->owner->{$this->_relationName})) {
            $this->_relatedTags = $this->owner->{$this->_relationName};
        }
    }

    public function beforeSave($event) {

        if (isset($this->owner->{$this->textFieldName})) {
            $tags = self::string2array($this->owner->{$this->textFieldName});

            if ($tags)
                foreach ($tags as $name) {
                    /* @var $tag Tag */
                    $tag = Tag::find()->where(['name' => $name])->one();
                    if (!$tag) {
                        $tag = new Tag();
                        $tag->name = $name;
                        $tag->count = 1;
                        $tag->save();
                        array_push($this->_relatedTags, $tag);
                    } 
                    unset($tag);
                }

            //$this->owner->{$this->_relationName} = $this->_relatedTags;
        }
    }

    public function afterSave($event) {

        if (!empty($this->_relatedTags))
            $tags = self::string2array($this->owner->{$this->textFieldName});
            foreach ($this->_relatedTags as $tag) {
                /* @var $tag Tag */
                $pivotClass = $this->pivotClass;
                $model = $this->owner;
                $key = key($model->getRelation($this->_relationName)->via->link);
                $attributes = [$key => $model->primaryKey, 'tag_id' => $tag->id];
                $pivot = $pivotClass::find()->where($attributes)->one();
                if(!$pivot) {
                    $pivot = new $pivotClass;
                    $pivot->attributes = $attributes;
                    $pivot->save();
                }
                if(!in_array($tag->name, $tags)){
                    $pivot->delete();
                }
                $tag->updateCount();
            }
    }

    public static function string2array($tags) {
        return preg_split('/\s*,\s*/', trim($tags), -1, PREG_SPLIT_NO_EMPTY);
    }

    public static function array2string($tags) {
        return implode(', ', $tags);
    }

}
