<?php
declare(strict_types=1);

namespace Creonit\VerificationCodeBundle\Event;

use Creonit\VerificationCodeBundle\Scope\VerificationScopeInterface;
use Symfony\Contracts\EventDispatcher\Event;

class ValidateKeyEvent extends Event
{
    protected $key;
    protected VerificationScopeInterface $scope;

    protected array $errors = [];

    public function __construct($key, VerificationScopeInterface $scope)
    {
        $this->key = $key;
        $this->scope = $scope;
    }

    public function getKey()
    {
        return $this->key;
    }

    public function getScope(): VerificationScopeInterface
    {
        return $this->scope;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function addError(string $message)
    {
        $this->errors[] = $message;
    }
}
