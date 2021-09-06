<?php


namespace vloop\user\entities\interfaces;


use vloop\user\entities\rbac\Role;

interface AccessCredentials extends \Iterator
{
    public function list(): array;

    public function add(): AccessCredential;

    public function remove(AccessCredential $itemName): bool;
}