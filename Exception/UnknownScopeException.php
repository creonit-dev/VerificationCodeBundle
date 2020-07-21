<?php

namespace Creonit\VerificationCodeBundle\Exception;

use Throwable;

class UnknownScopeException extends \Exception
{
    /**
     * @var string
     */
    protected $scopeName;

    public function __construct(string $scopeName, $message = "", $code = 0, Throwable $previous = null)
    {
        if (!$message) {
            $message = "Unknown scope - {$scopeName}";
        }
        $this->scopeName = $scopeName;

        parent::__construct($message, $code, $previous);
    }

    /**
     * @return string
     */
    public function getScopeName(): string
    {
        return $this->scopeName;
    }
}