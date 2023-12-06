<?php

namespace App\Helpers;

// can use class or create simple php file with functions and autoload
final class GlobalHelper
{
    public static function getCacheKey(): string
    {
        return request()->getPathInfo() . '|' . serialize(request()->all());
    }
}
