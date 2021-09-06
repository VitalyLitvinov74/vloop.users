<?php


namespace vloop\user\entities\interfaces;


use yii\web\IdentityInterface;

interface User
{
    /**
     * @return int - идентификатор пользователя
    */
    function id(): int;

    /**
     * @param string $password - пароль или access token
     * @return array - если удачно то напечатает себя, если нет то выдаст ошибку.
     */
    function login(string $password): array;

    /**
     * @return bool - выходит из системы
    */
    function logout(): bool;

    /**
     * @return array - печатает себя в виде массива
    */
    function printYourself():array;

    /**
     * @return bool - паттерн null object
    */
    function notGuest(): bool;
}