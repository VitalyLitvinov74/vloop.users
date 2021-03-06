<?php


namespace vloop\users\entities\forms;


use vloop\users\tables\TableUsers;
use yii\base\Model;
use yii\helpers\VarDumper;

class CreateUserForm extends Model
{
    public $password;
    public $name;
    public $login;

    public function rules()
    {
        return [
            ['name', 'required'],
            [['name', 'password', 'login'], 'string', 'min'=>4, 'max'=>32]
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Имя',
            'login' => 'Логин',
            'password' => 'Пароль'
        ];
    }

    /**
     * Устанавливаем значения по дефолту
    */
    public function afterValidate()
    {
        parent::afterValidate();
        if(!$this->password){
            $this->password = $this->createPassword('');
        }
        if(!$this->login){
            $this->login = $this->createLogin('');
        }
    }

    /**
     * @param string $login
     * @return string|string
     */
    private function createLogin(string $login = "")
    {
        if (!$login) {
            $lastID = $this->lastId() + 1;
            $login = 'user' . $lastID;
        }
        $loginNotUnique = TableUsers::find()->where(['login' => $login])->exists();
        if ($loginNotUnique) {
            $login = $login . rand(1000, 10000);
            $login = $this->createLogin($login); //рекурсивно прогоняем, и каждый раз проверяем уникальный ли это логин
        }
        return $login;
    }

    private function createPassword(string $password){
        if(!$password){
            $password = time();
        }
        return $password;
    }

    private function lastId()
    {
        $lastID = TableUsers::find()->select('id')->orderBy(['id' => SORT_DESC])->readOne()['id'];
        if (!$lastID) {
            $lastID = 0;
        }
        return $lastID;
    }
}