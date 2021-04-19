<?php

namespace Creonit\VerificationCodeBundle\Normalizer;


use Creonit\VerificationCodeBundle\Model\VerificationCodeInterface;

class VerificationCodeNormalizer extends AbstractNormalizer
{
    /**
     * @param VerificationCodeInterface $object
     * @param string|null $format
     * @param array $context
     */
    public function normalize($object, string $format = null, array $context = [])
    {
        $data = [
            'key' => $object->getKey(),
            'createdAt' => $object->getCreatedAt(),
            'expiredAt' => $object->getExpiredAt(),
        ];

        return $this->normalizer->normalize($data, $format, $context);
    }

    public function supportsNormalization($data, string $format = null)
    {
        return $data instanceof VerificationCodeInterface;
    }
}