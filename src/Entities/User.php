<?php

namespace ProjectManagementApi\Entities;

class User {
    private int $id;
    private string $name;
    private string $avatar;
    private string $role;

    public function __construct(int $id, string $name, string $avatar, string $role) {
        $this->id = $id;
        $this->name = $name;
        $this->avatar = $avatar;
        $this->role = $role;
    }

    public function toAssociativeArray(): array {
        return [
            'id' => strval($this->id),
            'name' => $this->name,
            'avatar' => $this->avatar,
            'role' => $this->role
        ];
    }
}
