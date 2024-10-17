<?php

namespace App\Traits;

trait HasBadgeCount
{
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
