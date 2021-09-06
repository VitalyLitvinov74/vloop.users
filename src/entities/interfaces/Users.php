<?php


namespace vloop\user\entities\interfaces;


use yii\db\Query;

interface Users
{
    /**
     * @return User[]
    */
    public function all(): array;

    /**
     * @param string $name - имя (ФИО) пользователя.
     * @param string $login - логин который нужно задать пользователю
     * @param string $password - Пароль который нужно задать пользователю
     * @return User - новый пользователь которого удалось зарегистрировать.
     */
    public function registerNew(string $name, string $login, string $password): User;

    /**
     * @param User $user - пользователь которого нужно удалить
     * @return bool - удачно ли удален пользователь из системы
     */
    public function remove(User $user): bool;

    /**
     * Производит поиск в бд, а не в all.
     * @param array $criteria - условия которые нужно применить к выборке
     * @return User - может вернуть NullObject
     */
    public function oneByCriteria(array $criteria): User;
}