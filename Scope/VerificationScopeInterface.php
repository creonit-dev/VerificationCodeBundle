<?php

namespace Creonit\VerificationCodeBundle\Scope;

use Symfony\Component\Validator\Constraint;

interface VerificationScopeInterface
{
    public function getName(): string;

    public function generateCode(string $key);

    public function getMaxAge(): int;

    public function getGenerationAttemptTime(): int;

    /**
     * @return Constraint[]
     */
    public function getKeyConstraints(): array;
}