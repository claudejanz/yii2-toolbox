<?php

namespace claudejanz\toolbox\models\traits;

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
trait OrderTrait
{

    /**
     * 
     * @return ActiveQuery
     */
    public function byWeight()
    {
        $modelClass = $this->modelClass;
        $tableName = $modelClass::tableName();
        $this->orderBy(['{{%' . $tableName . '}}.[[weight]]' => SORT_ASC]);
        return $this;
    }

}
