<?php

namespace Creonit\VerificationCodeBundle\Generator;

interface CodeGeneratorInterface
{
    public function generate(string $key);

    public function setConfig(array $config);
}