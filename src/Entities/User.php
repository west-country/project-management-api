<?php

namespace ProjectManagementApi\Entities;

use JsonSerializable;

class User implements JsonSerializable
{
    private int $id;
    private string $name;
    private string $avatar;
    private string $role;

    public function jsonSerialize(): mixed
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'avatar' => $this->avatar,
            'role' => $this->role
        ];
    }
}
