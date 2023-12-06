<?php

namespace App\Enums;

enum IssueStatus: int
{
    case Todo = 1;
    case In_progress = 2;
    case In_testing = 3;
    case Done = 4;
    case Backlog = 5;


    /**
     * @return string
     */
    public function getTextValue(): string
    {
        return str_replace('_', ' ', $this->name);
    }
}
