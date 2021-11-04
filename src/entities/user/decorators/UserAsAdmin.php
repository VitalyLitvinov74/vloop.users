<?php


namespace vloop\users\entities\user\decorators;


use vloop\entities\contracts\Entity;
use vloop\entities\contracts\Form;

class UserAsAdmin implements Entity
{
    public function __construct(UserInterface $u) { }

    /**
     * @inheritDoc
     */
    public function id()
    {
        // TODO: Implement id() method.
    }

    /**
     * @inheritDoc
     */
    public function printYourself(): array
    {
        // TODO: Implement printYourself() method.
    }

    /**
     * @inheritDoc
     */
    public function changeLineData(Form $form): Entity
    {
        // TODO: Implement changeLineData() method.
    }

    /**
     * @inheritDoc
     */
    public function remove(): void
    {
        // TODO: Implement remove() method.
    }

    /**
     * @inheritDoc
     */
    public function isNull(): bool
    {
        // TODO: Implement isNull() method.
    }
}