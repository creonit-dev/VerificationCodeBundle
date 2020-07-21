<?php

namespace Creonit\VerificationCodeBundle\Scope;


use Creonit\VerificationCodeBundle\Config\ParameterBag;
use Creonit\VerificationCodeBundle\Generator\CodeGeneratorInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class VerificationScope implements VerificationScopeInterface
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var CodeGeneratorInterface
     */
    protected $codeGenerator;

    /**
     * @var ParameterBag
     */
    protected $config;

    public function __construct(string $name)
    {
        $this->name = $name;
        $this->config = new ParameterBag();
    }

    /**
     * @param CodeGeneratorInterface $codeGenerator
     *
     * @return $this
     */
    public function setCodeGenerator(CodeGeneratorInterface $codeGenerator)
    {
        $this->codeGenerator = $codeGenerator;
        return $this;
    }

    /**
     * @param array $config
     *
     * @return $this
     */
    public function setConfig(array $config)
    {
        $this->config = new ParameterBag($config);
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function generateCode(string $key)
    {
        return $this->codeGenerator->generate($key);
    }

    public function getKeyConstraints(): array
    {
        $constraints = [new NotBlank()];

        if ($pattern = $this->config->get('key_pattern')) {
            $constraints[] = new Regex(['pattern' => $pattern]);
        }

        return $constraints;
    }

    public function getMaxAge(): int
    {
        return (int)$this->config->get('max_age', 0);
    }

    public function getGenerationAttemptTime(): int
    {
        return (int)$this->config->get('attempt_time', 0);
    }
}