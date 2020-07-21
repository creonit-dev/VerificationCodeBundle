<?php

namespace Creonit\VerificationCodeBundle\Normalizer;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareTrait;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

abstract class AbstractNormalizer implements NormalizerInterface
{
    use NormalizerAwareTrait;
}