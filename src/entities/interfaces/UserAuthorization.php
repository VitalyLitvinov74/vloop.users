<?php


namespace vloop\user\entities\interfaces;


interface UserAuthorization
{
    /**
     * @param string $permissionName - Название разрешения, которое нужно проверить.
     * @return bool - true/false - разрешение имеется/не имеется
     */
    public function checkAccess(string $permissionName): bool;

    /**
     * @param string $roleName - Название роли (например, "Администратор")
     * @return bool - true/false - разрешение имеется/не имеется
     */
    public function checkRole(string $roleName): bool;

    public function attachRole(AccessCredential $Role);

    public function givePermission(AccessCredential $permission);

    public function attachRule();
}