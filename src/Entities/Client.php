<?php

namespace ProjectManagementApi\Entities;

use JsonSerializable;

class Client implements JsonSerializable
{
    private int $id;
    private string $name;
    private ?string $logo;

    public function jsonSerialize(): mixed
    {
        return
            [
                'id' => $this->id,
                'name' => $this->name,
                'logo' => $this->logo,
            ];
    }
}
