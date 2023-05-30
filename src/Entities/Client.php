<?php

namespace ProjectManagementApi\Entities;

use JsonSerializable;
use ProjectManagementApi\Exceptions\InvalidUserArrayDatatypeException;
use ProjectManagementApi\Entities\User;

class Client implements JsonSerializable
{
    // {
    //     "id": "1",
    //     "name": "Yadel",
    //     "logo": "http://dummyimage.com/200x200.png/ff4444/ffffff"
    //   },
    private int $id; //
    private string $name; //
    private ?string $logo; //

    public function jsonSerialize(): mixed
    {
        return
            [
                // 'id' => strval($this->id),
                'id' => $this->id,
                'name' => $this->name,
                'logo' => $this->logo,
            ];
    }
}