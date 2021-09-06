<?php


namespace vloop\user\entities\user;

use vloop\user\entities\interfaces\User;
use vloop\user\entities\interfaces\User as UserInterface;
use vloop\user\entities\user\decorators\IdentityUser;
use vloop\user\tables\TableUsers;
use Yii;
use yii\base\Exception;
use yii\web\IdentityInterface;

/**
 * Обработать если такого пользователя не существует.
 */
class UserSQL implements User
{
    private $id;
    private $record = false;

    public function __construct(int $id)
    {
        $this->id = $id;
    }

    function id(): int
    {
        return $this->id;
    }

    function login(string $password): array
    {
        $secure = Yii::$app->security;
        $hash = $this->record()->password_hash;
        $userComponent = Yii::$app->user;
        if ($secure->validatePassword($password, $hash)) {
            try {
                $this->record()->access_token = Yii::$app->security->generateRandomString(32);
            } catch (Exception $e) {
                return (new NullUser(['string'=>'Не удалось сгенерировать рандомную строку']))->printYourself();
            }
            $this->record()->save();
            $userComponent->login(new IdentityUser($this));
            return $this->printYourself();
        }
        return (new NullUser(["login"=>"Не верный логин или пароль"]))->printYourself();
    }

    function logout(): bool
    {
        return Yii::$app->user->logout(true);
    }

    /**
     * печатает себя в виде массива
     */
    function printYourself(): array
    {
        return $this->record()->toArray();
    }

    function notGuest(): bool
    {
        return true;
    }

    private function record()
    {
        if ($this->record !== false) {
            return $this->record;
        }
        $this->record = TableUsers::findOne(['id' => $this->id]);
        return $this->record;
    }
}