<?php


namespace vloop\users\entities\interfaces;


use vloop\users\entities\rbac\Role;

interface AccessCredentials extends \Iterator
{
    public function list(): array;

    public function add(): AccessCredential;

    public function remove(AccessCredential $itemName): bool;
}