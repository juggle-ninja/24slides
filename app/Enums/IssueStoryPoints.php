<?php

namespace App\Enums;

enum IssueStoryPoints: int
{
    case One = 1;
    case Two = 2;
    case Three = 3;
    case Four = 4;
    case Five = 5;
    case Six = 6;
    case Seven = 7;
    case Eight = 8;

    /**
     * @return string
     */
    public function getTextValue(): string
    {
        return match ($this->value) {
            1 => "{$this->value} Point",
            default => "{$this->value} Points"
        };
    }
}
