<?php

namespace Creonit\VerificationCodeBundle\Model;


interface VerificationCodeInterface
{
    public function getKey();

    public function setKey($key);

    public function getCode();

    public function setCode($code);

    public function getCreatedAt();

    public function getExpiredAt();

    public function setExpiredAt($expiredAt);

    public function setExpiredAfter(int $seconds);

    public function setVerified(bool $verified);

    public function getScope(): string;
}