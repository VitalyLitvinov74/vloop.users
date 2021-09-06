<?php


namespace vloop\user\controllers;

use vloop\user\entities\forms\CreateUserForm;
use vloop\user\entities\forms\decorators\PostForm;
use vloop\user\entities\forms\LoginForm;
use vloop\user\entities\user\decorators\RestUser;
use vloop\user\entities\user\decorators\RestUsers;
use vloop\user\entities\user\NullUser;
use vloop\user\entities\user\Users;
use Yii;
use yii\filters\AccessControl;
use yii\filters\auth\QueryParamAuth;
use yii\rest\Controller;

class UserController extends Controller
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['access'] = [
            'class' => AccessControl::class,
            'only' => ['login', 'logout', 'create'],
            'rules' => [
                [
                    'allow' => true,
//                    'actions' => ['login', 'create'],
                    'roles' => ['?'],
                ],
//                [
//                    'allow' => true,
//                    'actions' => ['logout', 'create'],//TODO: Организовать RBAC непосредственно в экшене.
//                    'roles' => ['@'],
//                ],
            ],
        ];
//        $behaviors['authenticator'] = [
//            'class' => QueryParamAuth::class,
//            'tokenParam' => 'access_token',
//            'only' => ['create', 'check-auth']
//        ];
        return $behaviors;
    }

    public function actionLogin()
    {
        //TODO: слишком много логики в контроллере. Упростить на след. этапе.
        $post = new PostForm(
            $form = new LoginForm()
        );
        if ($post->validated()) {
            $users = new RestUsers(
                new Users(),
                ['name', 'access_token', 'errors'] //белый список полей которые можно возвращать
            );
            return $users
                ->oneByCriteria(['login' => $form->login])
                ->login($form->password)
            ;
        }
        $restNull = new RestUser(
            new NullUser($form->errors),
            ['errors']
        );
        return $restNull->printYourself();
    }

    public function actionCreate()
    {
        //TODO: слишком много логики в контроллере. Упростить на след. этапе.
        $post = new PostForm(
            $form = new CreateUserForm()
        );

        if ($post->validated()) {
            $users = new RestUsers(
                new Users(),
                ['name', 'login', 'errors']
            );
            $newUser = $users
                ->registerNew(
                    $form->name,
                    $form->login,
                    $form->password
                );
            return $newUser->printYourself();
        }
        $restNull = new RestUser(
            new NullUser($form->errors),
            ['name', 'login', 'errors']
        );
        return $restNull->printYourself();
    }

    public function actionCheckAuth()
    {
        return Yii::$app->user->isGuest;
    }


}