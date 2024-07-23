<?php

namespace HaschaDev\Contracts\Page;

use HaschaDev\Services\Page\Routerable;

interface Pageable
{
    public function setRouter(string $routeName): void;
    public function routerable(): Routerable;
}