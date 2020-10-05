<?php

namespace App\Domain\Model\User;

use JsonSerializable;

class User implements JsonSerializable
{
    private string $id;

    /**
     * User constructor.
     *
     * @param string $id
     */
    public function __construct(string $id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->getId()
        ];
    }
}
