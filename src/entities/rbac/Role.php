<?php


namespace vloop\users\entities\rbac;


use vloop\users\entities\interfaces\AccessCredential;
use Yii;

class Role implements AccessCredential
{
    private $name;
    private $rules;

    public function __construct(string $name)
    {
        $this->name = $name;
        $this->rules = new RulesRBAC();
    }

    public function name(): string
    {
        return $this->name;
    }

    public function rules(): array
    {
        return $this->rules->list();
    }
}