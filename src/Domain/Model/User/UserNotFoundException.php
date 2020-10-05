<?php

namespace App\Domain\Model\User;

use Exception;
use JsonSerializable;

class UserNotFoundException extends Exception implements JsonSerializable
{

    /**
     * @inheritDoc
     */
    public function jsonSerialize(): array
    {
        return [
            'message' => $this->getMessage(),
            'code' => $this->getCode(),
            'line' => $this->getLine(),
            'file' => $this->getFile()
        ];
    }
}
