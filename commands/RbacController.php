<?php

/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace claudejanz\toolbox\commands;

use claudejanz\contextAccessFilter\rules\OwnRule;
use Yii;
use yii\console\Controller;
use yii\helpers\Console;

/**
 * This command adds rbac entrys.
 *
 * @author Claude Janz <claude.janz@gmail.com>
 * @since 2.0
 */
class RbacController extends Controller {

    public function actionIndex() {
        $auth = Yii::$app->authManager;

        $total = 13;
        Console::startProgress(0, $total, 'Doing Updates: ', false);
        $i=1;
     
     
        $auth->removeAll();

        // add "view" permission
        $view = $auth->createPermission('view');
        $view->description = 'visualiser un enregistrement';
        $auth->add($view);
        Console::updateProgress($i++, $total);

        // add "create" permission
        $create = $auth->createPermission('create');
        $create->description = 'créer enregistrement';
        $auth->add($create);
        Console::updateProgress($i++, $total);
        
        // add "update" permission
        $update = $auth->createPermission('update');
        $update->description = 'update enregistrement';
        $auth->add($update);
        Console::updateProgress($i++, $total);
        
// add an own rule the rule
        $rule = new OwnRule();
        $auth->add($rule);
        Console::updateProgress($i++, $total);

        // add the "updateOwn" permission and associate the rule with it.
        $updateOwn = $auth->createPermission('updateOwn');
        $updateOwn->description = 'update own enregistrement';
        $updateOwn->ruleName = $rule->name;
        $auth->add($updateOwn);
        $auth->addChild($updateOwn,$update);
        Console::updateProgress($i++, $total);
        
        // add "publish" permission
        $publish = $auth->createPermission('publish');
        $publish->description = 'publish enregistrement';
        $auth->add($publish);
        Console::updateProgress($i++, $total);
        
        
        
        // add "delete" permission
        $delete = $auth->createPermission('delete');
        $delete->description = 'delete enregistrement';
        $auth->add($delete);
        Console::updateProgress($i++, $total);
        
        // add the "deleteOwn" permission and associate the rule with it.
        $deleteOwn = $auth->createPermission('deleteOwn');
        $deleteOwn->description = 'delete own enregistrement';
        $deleteOwn->ruleName = $rule->name;
        $auth->add($deleteOwn);
        $auth->addChild($deleteOwn,$delete);
        Console::updateProgress($i++, $total);

        
        /**
         * USER
         */
        // add "normal" role and give this role the "create" permission
        $normal = $auth->createRole('normal');
        $auth->add($normal);
        $auth->addChild($normal, $view);
        Console::updateProgress($i++, $total);

        // add "editor" role and give this role the "create" permission
        // as well as the permissions of the "normal" role
        $editor = $auth->createRole('editor');
        $auth->add($editor);
        $auth->addChild($editor, $create);
        $auth->addChild($editor, $updateOwn);
        $auth->addChild($editor, $deleteOwn);
        $auth->addChild($editor, $normal);
        Console::updateProgress($i++, $total);

        // add "publisher" role and give this role the "publish" permission
        // as well as the permissions of the "editor" role
        $publisher = $auth->createRole('publisher');
        $auth->add($publisher);
        $auth->addChild($publisher, $publish);
        $auth->addChild($publisher, $editor);
        Console::updateProgress($i++, $total);
        
        
        // add "admin" role and give this role the "update" permission
        // as well as the permissions of the "publisher" role
        $admin = $auth->createRole('admin');
        $auth->add($admin);
        $auth->addChild($admin, $update);
        $auth->addChild($admin, $delete);
        $auth->addChild($admin, $publisher);
        Console::updateProgress($i++, $total);

        // Assign roles to users. 10, 14 and 26 are IDs returned by IdentityInterface::getId()
        // usually implemented in your User model.
        $auth->assign($normal, 3);
        $auth->assign($publisher, 2);
        $auth->assign($admin, 1);
        Console::updateProgress($i++, $total);
        
        Console::endProgress("done." . PHP_EOL);
        
        echo $this->ansiFormat('Structure recreated', Console::FG_YELLOW);
    }

}
