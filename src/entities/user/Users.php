<?php


namespace vloop\user\entities\user;

use Faker\ORM\Spot\ColumnTypeGuesser;
use vloop\user\entities\interfaces\User;
use vloop\user\entities\interfaces\Users as UsersInterface;
use vloop\user\entities\user\decorators\StaticUser;
use vloop\user\tables\TableUsers;
use Yii;
use yii\base\Exception;

class Users implements UsersInterface
{
    private $position = 0;
    private $needle;

    /**
     * Если массив пустой то будет произведен поиск по всем пользователям
     * @param array $ids - массив ид юзеров коотрый нужно получить
     */
    public function __construct(array $ids = [])
    {
        $this->needle = $ids;
    }

    private function records()
    {
        $records = TableUsers::find()->select(['id', 'auth_key']);
        if ($this->needle) {
            $records->where(['id' => $this->needle]);
        }
        return $records->readAll();
    }

    public function remove(User $user): bool
    {
        return TableUsers::deleteAll(['id' => $user->id()]);
    }

    /**
     * @return User[]
     */
    public function all(): array
    {
        $records = $this->records();
        $new = [];
        foreach ($records as $record) {
            $new[] = new StaticUser(
                new UserSQL($record['id']),
                $record['auth_key']
            );
        }
        return $new;
    }

    /**
     * Производит поиск в бд, а не в all.
     * @param array $criteria
     * @return User - может вернуть NullObject
     */
    public function oneByCriteria(array $criteria): User
    {
        $user = TableUsers::find()->where($criteria)->readOne();
        if ($user) {
            return new StaticUser(
                new UserSQL(
                    $user['id']
                ),
                $user['auth_key']
            );
        }
        return new NullUser([
            'login'=>'Пользователь с таким логином не найден.'
        ]);
    }

    /**
     * @param string $name - имя (ФИО) пользователя.
     * @param string $login - логин который нужно задать пользователю
     * @param string $password - Пароль который нужно задать пользователю
     * @return User - новый пользователь которого удалось зарегистрировать.
     */
    public function registerNew(string $name, string $login, string $password): User
    {
        $secure = Yii::$app->security;
        try {
            $record = new TableUsers([
                'name' => $name,
                'login' => $login,
                'password_hash' => $secure->generatePasswordHash($password),
                'access_token' => $secure->generateRandomString(32),
                'auth_key' => $secure->generateRandomString(32)
            ]);
        } catch (Exception $e) {
            return new NullUser(["password" => "Не удалось сгенерировать хеш пароля.",
                    "message"=>$e->getMessage()
                ]);
        }
        try {
            if ($record->save()) {
                return new StaticUser(
                    new UserSQL(
                        $record->id
                    ),
                    $record->auth_key
                );
            }
            return new NullUser([
                "user" => "Текущий пользователь уже существует."
            ]);
        } catch (\yii\db\Exception $exception) {
            return new NullUser([
                "title" => "Не удалось сохранить данные в бд. Не хватает полей для записи.",
                "fields" => $record->getAttributes()
            ]);
        }

    }
}