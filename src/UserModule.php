<?php


namespace vloop\user;


use Yii;
use yii\base\Module;
use yii\helpers\VarDumper;

class UserModule extends Module
{
    public function init()
    {
        parent::init();
        $this->controllerNamespace = 'vloop\user\controllers';
        Yii::$app->setComponents([
            'authManager' => [
                'class' => 'yii\rbac\DbManager',
                'itemTable' => 'vloop_permissions',
                'ruleTable' => 'vloop_rules',
                'assignmentTable' => "vloop_permissions_users",
                'itemChildTable' => 'vloop_role_paths',
            ],
            'response'=>[
                'class' => 'yii\web\Response',
                'on beforeSend' => function ($event) {
                    $response = $event->sender;
                    if ($response->data !== null and isset($response->data['errors']) and !(Yii::$app instanceof \yii\console\Application)) {
                        Yii::$app->response->setStatusCode(422);
                    }
                },
            ],
        ]);
    }
}