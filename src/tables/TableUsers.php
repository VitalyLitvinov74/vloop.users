<?php


namespace vloop\user\tables;


use vloop\user\tables\query\BaseQuery;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * @property int $id [int(11)]
 * @property string $name [varchar(32)]
 * @property string $password_hash [varchar(32)]
 * @property string $auth_key [varchar(32)]
 * @property string $access_token [varchar(32)]
 * @property string $login [varchar(255)]
 */
class TableUsers extends ActiveRecord
{

    public static function tableName()
    {
        return 'vloop_users'; // TODO: Change the autogenerated stub
    }

    public function rules()
    {
        return [
            [['password_hash', 'auth_key', 'access_token', 'login'], 'unique']
        ];
    }

    static function find()
    {
        return new BaseQuery(get_called_class()); // TODO: Change the autogenerated stub
    }
}