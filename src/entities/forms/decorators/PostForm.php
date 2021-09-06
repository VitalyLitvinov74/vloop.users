<?php


namespace vloop\user\entities\forms\decorators;


use vloop\user\entities\interfaces\Form;
use Yii;
use yii\base\Model;
use yii\helpers\VarDumper;

class PostForm implements Form
{
    private $model;

    public function __construct(Model $model) {
        $this->model = $model;
    }

    public function model(): Model
    {
        return $this->model;
    }

    public function validated(): bool {
        $post = Yii::$app->request->post();
        if($this->model->load($post, '') and $this->model->validate()){
            return true;
        }
        return false;
    }

    public function fields(): array
    {
        $post = Yii::$app->request->post();
        if($this->model->load($post, '') and $this->model->validate()){
            return $this->model()->attributes();
        }
        return $this->model->errors;
    }
}