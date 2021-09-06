<?php


namespace vloop\user\entities\forms;


use yii\rest\Serializer;

class RestSerializer extends Serializer
{
    protected function serializeModelErrors($model)
    {
        $this->response->setStatusCode(422, 'Data Validation Failed.');
        $result = [];
        foreach ($model->getFirstErrors() as $name => $message) {
            $result[] = [
                'field' => $name,
                'detail' => $message,
            ];
        }
        return [
            'errors'=>$result
        ];
    }
}