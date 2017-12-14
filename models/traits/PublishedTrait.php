<?php

namespace claudejanz\toolbox\models\traits;

use claudejanz\toolbox\models\behaviors\PublishBehavior;
use Yii;
use yii\db\ActiveQuery;

/*
 * @link https://www.klod.ch/ 
 * @copyright Copyright (c) 2017 Klod SA
 * @author Claude Janz <claude.janz@klod.ch>
 */

/**
 * Description of OrderTrait
 *
 * @author Claude
 */
trait PublishedTrait
{

    /**
     * 
     * @return ActiveQuery
     */
    public function byRights()
    {
        if (Yii::$app->user->isGuest) {
            $modelClass = $this->modelClass;
            $tableName = $modelClass::tableName();
            $this->orderBy(['{{%' . $tableName . '}}.[[weight]]' => SORT_ASC]);
            $this->andwhere(['[[published]]' => PublishBehavior::PUBLISHED_ACTIF]);
        }
        return $this;
    }

}
