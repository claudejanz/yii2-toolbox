<?php

/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace claudejanz\toolbox\commands;

use Yii;
use yii\console\Controller;

/**
 * This command adds rbac entrys.
 *
 * @moderator Claude Janz <claude.janz@gmail.com>
 * @since 2.0
 */
class RbacController extends Controller {

    public function actionIndex() {
        $auth = Yii::$app->authManager;

        $auth->removeAll();

        // add "view" permission
        $view = $auth->createPermission('view');
        $view->description = 'visualiser un enregistrement';
        $auth->add($view);

        // add "create" permission
        $create = $auth->createPermission('create');
        $create->description = 'créer enregistrement';
        $auth->add($create);
        
        // add "update" permission
        $update = $auth->createPermission('update');
        $update->description = 'update enregistrement';
        $auth->add($update);
        
// add an own rule the rule
        $rule = new \claudejanz\contextAccessFilter\rules\OwnRule();
        $auth->add($rule);

        // add the "updateOwn" permission and associate the rule with it.
        $updateOwn = $auth->createPermission('updateOwn');
        $updateOwn->description = 'update own enregistrement';
        $updateOwn->ruleName = $rule->name;
        $auth->add($updateOwn);
        $auth->addChild($updateOwn,$update);
        
        // add "publish" permission
        $publish = $auth->createPermission('publish');
        $publish->description = 'publish enregistrement';
        $auth->add($publish);
        
        // add "delete" permission
        $delete = $auth->createPermission('delete');
        $delete->description = 'delete enregistrement';
        $auth->add($delete);
        
        // add the "deleteOwn" permission and associate the rule with it.
        $deleteOwn = $auth->createPermission('deleteOwn');
        $deleteOwn->description = 'delete own enregistrement';
        $deleteOwn->ruleName = $rule->name;
        $auth->add($deleteOwn);
        $auth->addChild($deleteOwn,$delete);

        
        /**
         * USER
         */
        // add "normal" role and give this role the "create" permission
        $normal = $auth->createRole('normal');
        $auth->add($normal);
        $auth->addChild($normal, $view);

        // add "editor" role and give this role the "create" permission
        // as well as the permissions of the "normal" role
        $editor = $auth->createRole('editor');
        $auth->add($editor);
        $auth->addChild($editor, $create);
        $auth->addChild($editor, $updateOwn);
        $auth->addChild($editor, $deleteOwn);
        $auth->addChild($editor, $normal);

        // add "moderator" role and give this role the "publish" permission
        // as well as the permissions of the "editor" role
        $moderator = $auth->createRole('moderator');
        $auth->add($moderator);
        $auth->addChild($moderator, $publish);
        $auth->addChild($moderator, $editor);
        
        
        // add "admin" role and give this role the "update" permission
        // as well as the permissions of the "moderator" role
        $admin = $auth->createRole('admin');
        $auth->add($admin);
        $auth->addChild($admin, $update);
        $auth->addChild($admin, $delete);
        $auth->addChild($admin, $moderator);

        // Assign roles to users. 10, 14 and 26 are IDs returned by IdentityInterface::getId()
        // usually implemented in your User model.
        $auth->assign($normal, 3);
        $auth->assign($admin, 2);
        $auth->assign($admin, 1);
    }

}
