<?php


namespace vloop\user\entities\user\decorators;


use vloop\user\entities\interfaces\User;

class StaticUser implements User
{
    private $authKey;
    private $origin;
    
    public function __construct(User $origin, string $authKey) { 
        $this->authKey = $authKey;
        $this->origin = $origin;
    }

    function id(): int
    {
        return $this->origin->id();
    }

    function login(string $password): array
    {
        return $this->origin->login($password);
    }

    function logout(): bool
    {
        return $this->origin->logout();
    }

    /**
     * печатает себя в виде массива
     */
    function printYourself(): array
    {
        return $this->origin->printYourself();
    }

    function notGuest(): bool
    {
        return $this->origin->notGuest();
    }
}