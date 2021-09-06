<?php


namespace vloop\user\entities\rbac;


use vloop\user\entities\interfaces\AccessCredential;
use vloop\user\entities\interfaces\UserAuthorization;
use vloop\user\entities\interfaces\User;
use Yii;

class UserAuthorizationByRBAC implements UserAuthorization
{
    private $user;
    private $permissions;
    private $roles;
    private $auth;

    public function __construct(User $user, Roles $roles, Permissions $permissions) {
        $this->user = $user;
        $this->roles = $roles;
        $this->permissions = $permissions;
        $this->auth = Yii::$app->authManager;
    }

    /**
     * @param string $permissionName - Название разрешения, которое нужно проверить.
     * @return bool - true/false - разрешение имеется/не имеется
     */
    public function checkAccess(string $permissionName): bool
    {
        // TODO: Implement checkAccess() method.
    }

    /**
     * @param string $roleName - Название роли (например, "Администратор")
     * @return bool - true/false - разрешение имеется/не имеется
     */
    public function checkRole(string $roleName): bool
    {

    }

    public function attachRole(AccessCredential $Role)
    {

    }

    public function givePermission(AccessCredential $permission)
    {

    }

    public function attachRule()
    {

    }
}