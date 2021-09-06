<?php


namespace vloop\user\entities\user\decorators;


use vloop\user\entities\interfaces\User;
use vloop\user\entities\interfaces\Users;
use yii\helpers\VarDumper;

class RestUsers implements Users
{
    private $origin;
    private $needleFields;
    /**@var array*/
    private $arr = false;

    public function __construct(Users $origin, array $needleFieldsForUsers = [])
    {
        $this->origin = $origin;
        if(!$needleFieldsForUsers){
            $needleFieldsForUsers = [
                'id',
                'name',
                'access_token'
            ];
        }
        $this->needleFields = $needleFieldsForUsers;
    }

    /**
     * @return User[]
     */
    public function all(): array
    {
        $origList = $this->origin->all();;
        if($this->arr !== false){
            return $this->arr;
        }
        $this->arr = [];
        foreach ($origList as $item) {
            $this->arr[] = new RestUser($item, $this->needleFields);
        }
        return $this->arr;
    }

    /**
     * @param User $user - пользователь которого нужно удалить
     * @return bool - удачно ли удален пользователь из системы
     */
    public function remove(User $user): bool
    {
        return $this->origin->remove($user);
    }

    /**
     * Производит поиск в бд, а не в all.
     * @param array $criteria - условия которые нужно применить к выборке
     * @return User - может вернуть NullObject
     */
    public function oneByCriteria(array $criteria): User
    {
        $orig = $this->origin->oneByCriteria($criteria);
        return new RestUser($orig, $this->needleFields);
    }

    /**
     * @param string $name - имя (ФИО) пользователя.
     * @param string $login - логин который нужно задать пользователю
     * @param string $password - Пароль который нужно задать пользователю
     * @return User - новый пользователь которого удалось зарегистрировать.
     */
    public function registerNew(string $name, string $login, string $password): User
    {
        $user = $this->origin->registerNew($name, $login, $password);
        return new RestUser($user, $this->needleFields);
    }
}