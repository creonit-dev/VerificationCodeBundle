<?php
declare(strict_types = 1);

namespace Creonit\VerificationCodeBundle\Event;

final class VerificationEvents
{
    public const VALIDATE_KEY = 'creonit_verification_code.validate_key';
    public const CREATE_CODE = 'creonit_verification_code.create_code';
    public const VERIFICATION_CODE = 'creonit_verification_code.verification_code';
}