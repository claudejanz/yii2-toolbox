<?php

namespace claudejanz\toolbox\controllers\actions;

use Yii;
use yii\base\Action;
use yii\helpers\Html;

class SortableAction extends Action {

    public $modelclass;
    public $scenario;

    /**
     * column name of sorting value
     * @var string 
     */
    public $orderBy = 'weight';

    

    

    public function run() {
        // Get POST
        $post = explode(',', Yii::$app->request->post()['order']);

        $count = 1;
        foreach ($post as $key => $value) {

            // $value should always be an array, but we do a check
           

                $modelclass = $this->modelclass;
                $pks = (array)$modelclass::primaryKey();
                $model = $modelclass::find()->where([
                            join(',',$pks) => $value,
                        ])->one();
                if ($this->scenario) {
                    $model->setScenario($this->scenario);
                }

                $model->{$this->orderBy} = $key;
                $model->save(false);
                $count++;
           
        }

        // Echo status message for the update
        echo Html::tag('div',Yii::t('claudejanz', "Order Updated on {date} !",['date'=>Yii::$app->formatter->asDatetime()]),['class'=>'alert alert-success']);
    }

    public function parseJsonArray($jsonArray, $parentID = null) {
        $return = array();
        foreach ($jsonArray as $subArray) {
            $returnSubSubArray = array();
            if (isset($subArray['children'])) {
                $returnSubSubArray = $this->parseJsonArray($subArray['children'], $subArray['id']);
            }
            $return[] = array('id' => $subArray['id'], 'parentID' => $parentID);
            $return = array_merge($return, $returnSubSubArray);
        }

        return $return;
    }

}
