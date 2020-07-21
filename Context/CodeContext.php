<?php

namespace Creonit\VerificationCodeBundle\Context;


class CodeContext
{
    protected $scope;
    protected $key;
    protected $code = '';
    protected $active = true;
    protected $expiredAfter = 0;

    /**
     * @var \DateTimeInterface|null
     */
    protected $expiredAt;

    public function __construct(string $key, string $scope = 'default')
    {
        $this->key = $key;
        $this->scope = $scope;
    }

    /**
     * @return string
     */
    public function getScope(): string
    {
        return $this->scope;
    }

    /**
     * @param string $scope
     *
     * @return $this
     */
    public function setScope(string $scope)
    {
        $this->scope = $scope;
        return $this;
    }

    /**
     * @return string
     */
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * @param string $key
     *
     * @return $this
     */
    public function setKey(string $key)
    {
        $this->key = $key;
        return $this;
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @param string $code
     *
     * @return $this
     */
    public function setCode(string $code)
    {
        $this->code = $code;
        return $this;
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->active;
    }

    /**
     * @param bool $active
     *
     * @return $this
     */
    public function setActive(bool $active)
    {
        $this->active = $active;
        return $this;
    }

    /**
     * @return int
     */
    public function getExpiredAfter(): int
    {
        return $this->expiredAfter;
    }

    /**
     * @param int $expiredAfter
     *
     * @return $this
     */
    public function setExpiredAfter(int $expiredAfter)
    {
        $this->expiredAfter = $expiredAfter;
        return $this;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getExpiredAt(): ?\DateTimeInterface
    {
        return $this->expiredAt;
    }

    /**
     * @param \DateTimeInterface|null $expiredAt
     *
     * @return $this
     */
    public function setExpiredAt(?\DateTimeInterface $expiredAt)
    {
        $this->expiredAt = $expiredAt;
        return $this;
    }
}