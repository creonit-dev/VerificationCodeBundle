<?php

namespace Creonit\VerificationCodeBundle\Repository;

use Creonit\VerificationCodeBundle\Context\CodeContext;
use Creonit\VerificationCodeBundle\Model\VerificationCodeInterface;

interface VerificationCodeRepositoryInterface
{
    public function create(CodeContext $context): VerificationCodeInterface;

    public function save(VerificationCodeInterface $verificationCode);

    public function findByContext(CodeContext $context): ?VerificationCodeInterface;

    public function deactivate(CodeContext $context);
}