<?php

namespace J84115\Impersonate\Interfaces;

interface ImpersonateUser
{
    public function impersonator(): bool;
    public function impersonatable(): bool;
}
