<?php


namespace vloop\user\entities\user;


use vloop\user\entities\interfaces\User;

class NullUser implements User
{
    private $self;

    public function __construct($self = []) {
        $this->self = $self;
    }

    /**
     * @return int - идентификатор пользователя
     */
    function id(): int
    {
        return 0;
    }

    /**
     * @return bool - выходит из системы
     */
    function logout(): bool
    {
        return false;
    }

    /**
     * @return array - печатает себя в виде массива
     */
    function printYourself(): array
    {
        return $this->self;
    }

    /**
     * @return bool - паттерн null object
     */
    function notGuest(): bool
    {
        return false;
    }

    /**
     * @param string $password - пароль или access token
     * @return bool - удачно ли авторизовался
     */
    function login(string $password): array
    {
        return $this->printYourself();
    }
}