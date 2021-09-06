<?php


namespace vloop\user\entities\forms;


use yii\base\Model;

class LoginForm extends Model
{
    public $login;
    public $password;

    public function rules()
    {
        return [
            [['login', 'password'], 'required'],
            [['login', 'password'], 'string', 'max' => 255, 'min' => 4]
        ];
    }
}