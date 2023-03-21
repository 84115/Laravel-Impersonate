<?php

namespace J84115\Impersonate\Interfaces;

interface ImpersonateUser
{
    public function canImpersonate(): bool;
}
