<?php

namespace App\Models\Type;

enum AuthorityType
{
    case Admin;
    case General;

    public function label(): string
    {
        return match($this) {
            // name => value
            self::Admin => '管理者',
            self::General => '一般',
        };
    }
}
?>