<?php

namespace Creonit\VerificationCodeBundle\Generator;

use Creonit\VerificationCodeBundle\Config\ParameterBag;

abstract class AbstractCodeGenerator implements CodeGeneratorInterface
{
    /**
     * @var ParameterBag
     */
    protected $config;

    public function __construct()
    {
        $this->config = new ParameterBag();
    }

    public function setConfig(array $config)
    {
        $this->validateConfig($config);
        $this->config = new ParameterBag($config);

        return $this;
    }

    protected function getParameter(string $key, $default = null)
    {
        return $this->config->get($key, $default);
    }

    protected function validateConfig(array $config)
    {
    }
}