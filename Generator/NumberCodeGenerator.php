<?php

namespace Creonit\VerificationCodeBundle\Generator;

use Creonit\VerificationCodeBundle\Generator\Exception\InvalidConfigurationException;

class NumberCodeGenerator extends AbstractCodeGenerator
{
    public function generate(string $key)
    {
        $numbers = range(1, 9);
        $length = $this->getParameter('length');

        $code = '';
        while ($length--) {
            $code .= $numbers[random_int(0, count($numbers) - 1)];
        }

        return $code;
    }

    protected function validateConfig(array $config)
    {
        $requiredFields = ['length'];

        if (!empty($undefinedFields = array_diff($requiredFields, array_keys($config)))) {
            throw new InvalidConfigurationException(sprintf('Not defined parameters [%s]', implode(', ', $undefinedFields)));
        }
    }
}