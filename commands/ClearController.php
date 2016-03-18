<?php

/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace claudejanz\toolbox\commands;

use Yii;
use yii\console\Controller;
use yii\helpers\Console;
use yii\helpers\FileHelper;

/**
 * This command removes @app/web/assets/.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class ClearController extends Controller
{

    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     */
    public function actionIndex()
    {
        $assets = [
            '@app/web/assets',
            '@app/web/image-cache',
            '@app/runtime/cache',
            '@app/runtime/debug',
            '@app/runtime/logs'
        ];
        $sep = '----------------------------------------------' . PHP_EOL;
        $message = $sep;
        $message .= 'What do you want to clear?' . PHP_EOL;
        $valids = [];
        $key = 0;
        foreach ($assets as $key => $value) {
            $message.= $this->ansiFormat($key, Console::FG_GREY)
                    . $this->ansiFormat(' => ', Console::FG_GREEN)
                    . $this->ansiFormat($value, Console::FG_YELLOW) . PHP_EOL;
            $valids[] = $key;
        }
        $message.= $this->ansiFormat('all', Console::FG_GREY)
                . $this->ansiFormat(' => ', Console::FG_GREEN)
                . $this->ansiFormat('all', Console::FG_YELLOW) . PHP_EOL;
        $message .= $sep;
        $error = $this->ansiFormat('Not valid input', Console::FG_RED);
        $pattern = '@^((' . implode('|', $valids) . '|all),?)+$@';
        $value = $this->prompt($message . 'Choices:', [
            'default' => '0,1',
            'pattern' => $pattern,
            'error' => $error
        ]);


        $values = preg_split('@,@', $value, -1, PREG_SPLIT_NO_EMPTY);
        if (in_array('all', $values)) {
            $this->clearAliases($assets);
        } else {
            $all = [];
            foreach ($values as $value) {
                if (key_exists($value, $assets))
                    $all[] = $assets[$value];
            }
            if (!empty($all)) {
                $this->clearAliases($all);
            }
        }
        echo $sep;
    }

    private function clearAliases($assets)
    {
        $len = count($assets);
        $message = '';
        Console::startProgress(0, $len, 'Doing Updates: ', false);
        foreach ($assets as $key => $asset) {
            $uri = Yii::getAlias($asset);
            FileHelper::removeDirectory($uri);
            FileHelper::createDirectory($uri);
            Console::updateProgress($key + 1, $len);
            $message .= 'cleared: ' . $this->ansiFormat($uri, Console::FG_GREEN) . PHP_EOL;
        }
        Console::endProgress("done." . PHP_EOL);
        echo $message;
    }

}
