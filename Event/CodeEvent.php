<?php

namespace Creonit\VerificationCodeBundle\Event;

use Creonit\VerificationCodeBundle\Model\VerificationCodeInterface;
use Symfony\Contracts\EventDispatcher\Event;

abstract class CodeEvent extends Event
{
    /**
     * @var VerificationCodeInterface
     */
    protected $verificationCode;

    public function __construct(VerificationCodeInterface $verificationCode)
    {
        $this->verificationCode = $verificationCode;
    }

    /**
     * @return VerificationCodeInterface
     */
    public function getVerificationCode(): VerificationCodeInterface
    {
        return $this->verificationCode;
    }

    /**
     * @param VerificationCodeInterface $verificationCode
     *
     * @return $this
     */
    public function setVerificationCode(VerificationCodeInterface $verificationCode)
    {
        $this->verificationCode = $verificationCode;
        return $this;
    }
}