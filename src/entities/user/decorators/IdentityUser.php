<?php


namespace vloop\user\entities\user\decorators;


use vloop\user\entities\interfaces\User;
use vloop\user\entities\user\UserSQL;
use vloop\user\tables\TableUsers;
use Yii;
use yii\helpers\VarDumper;
use yii\web\IdentityInterface;
/**
 * Объект который поддерживает авторизацию через фремворк.
 *
*/
class IdentityUser implements IdentityInterface, User
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    function id(): int
    {
        return $this->user->id();
    }

    function login(string $password): array
    {
        Yii::$app->user->login($this);
        return $this->printYourself();
    }

    function logout(): bool
    {
        return $this->user->logout();
    }

    /**
     * печатает себя в виде массива
     */
    function printYourself(): array
    {
        return $this->user->printYourself();
    }

    function notGuest(): bool
    {
        return $this->user->notGuest();
    }

    /**
     * Finds an identity by the given ID.
     * @param string|int $id the ID to be looked for
     * @return IdentityInterface|null the identity object that matches the given ID.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentity($id)
    {
        $record = TableUsers::find()->where(['id' => $id])->exists();
        if ($record) {
            return new self(
                new UserSQL(
                    $id
                )
            );
        }
        return null;
    }

    /**
     * Finds an identity by the given token.
     * @param mixed $token the token to be looked for
     * @param mixed $type the type of the token. The value of this parameter depends on the implementation.
     * For example, [[\yii\filters\auth\HttpBearerAuth]] will set this parameter to be `yii\filters\auth\HttpBearerAuth`.
     * @return IdentityInterface|null the identity object that matches the given token.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        $record = TableUsers::find()->where(['access_token' => $token])->one();
        if($record){
            return new self(
                new UserSQL(
                    $record->id
                )
            );
        }
        return null;
    }

    /**
     * Returns an ID that can uniquely identify a user identity.
     * @return string|int an ID that uniquely identifies a user identity.
     */
    public function getId()
    {
        return $this->id();
    }

    /**
     * Returns a key that can be used to check the validity of a given identity ID.
     * The key should be unique for each individual user, and should be persistent
     * so that it can be used to check the validity of the user identity.
     * The space of such keys should be big enough to defeat potential identity attacks.
     * The returned key is used to validate session and auto-login (if [[User::enableAutoLogin]] is enabled).
     * Make sure to invalidate earlier issued authKeys when you implement force user logout, password change and
     * other scenarios, that require forceful access revocation for old sessions.
     * @return string|null a key that is used to check the validity of a given identity ID.
     * @see validateAuthKey()
     */
    public function getAuthKey()
    {
        return $this->printYourself()['auth_key'];
    }

    /**
     * Validates the given auth key.
     * @param string $authKey the given auth key
     * @return bool|null whether the given auth key is valid.
     * @see getAuthKey()
     */
    public function validateAuthKey($authKey)
    {
        return $authKey == $this->getAuthKey();
    }
}