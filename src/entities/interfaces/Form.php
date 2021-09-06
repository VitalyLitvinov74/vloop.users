<?php


namespace vloop\users\entities\interfaces;


use yii\base\Model;

/**
 * Описывает контракт для паттерна цепочки обязанностей
*/
interface Form
{
    public function model(): Model;

    public function fields(): array;
}