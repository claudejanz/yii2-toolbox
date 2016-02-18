<?php
namespace claudejanz\multilingual;

use Yii;
use yii\db\ActiveQuery;

class MultilingualQuery extends ActiveQuery
{
    /**
     * @var string the name of the lang field of the translation table. Default to 'language'.
     */
    public $languageField = 'language';

    /**
     * Scope for querying by languages
     * @param $language
     * @return ActiveQuery
     */
    public function localised($language = null)
    {
        if (!$language)
            $language = Yii::$app->language;
        $this->with(['translation' => function ($query) use ($language) {
            $query->andWhere([$this->languageField => $language]);
            
        }]);
        return $this;
    }

    /**
     * Scope for querying by all languages
     * @return ActiveQuery
     */
    public function multilingual()
    {
        $this->with('translations');
        return $this;
    }

}