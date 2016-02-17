<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace claudejanz\toolbox\commands;

use Yii;
use yii\console\Controller;
use yii\helpers\FileHelper;

/**
 * This command removes @app/web/assets/.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class ClearAssetsController extends Controller
{
    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     */
    public function actionIndex()
    {
        $assets = ['@app/web/assets/','@app/web/image-cache/'];
        $this->clearAliases($assets);
    }
   

    private function clearAliases($assets)
    {
        foreach ($assets as $asset) {
            $uri = Yii::getAlias($asset);
            FileHelper::removeDirectory($uri);
            FileHelper::createDirectory($uri);
            echo 'cleared: ' .$uri. "\n";
        }
    }

}
