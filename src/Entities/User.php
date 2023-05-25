<?php

namespace ProjectManagementApi\Entities;

use JsonSerializable;


class User implements JsonSerializable
{
    private int $id;
    private string $name;
    private string $avatar;
    private string $role;

    // public function __construct(int $id, string $name, string $avatar, string $role)
    // {
    //     $this->id = $id;
    //     $this->name = $name;
    //     $this->avatar = $avatar;
    //     $this->role = $role;
    // }

    public function toAssociativeArray(): array
    {
        return [
            'id' => strval($this->id),
            'name' => $this->name,
            'avatar' => $this->avatar,
            'role' => $this->role
        ];
    }

    public function jsonSerialize(): mixed {
        return [
            'id' => strval($this->id),
            'name' => $this->name,
            'avatar' => $this->avatar,
            'role' => $this->role


            //'deadline' => $this->deadline->format(DateTime::ISO8601)
        ];
    }
}
