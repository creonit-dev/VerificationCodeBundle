<?php

namespace Creonit\VerificationCodeBundle\Model;

use Creonit\VerificationCodeBundle\Model\Base\VerificationCode as BaseVerificationCode;

/**
 * Skeleton subclass for representing a row from the 'verification_code' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 */
class VerificationCode extends BaseVerificationCode implements VerificationCodeInterface
{
    public function setExpiredAfter(int $seconds)
    {
        $expiredAt = null;

        if ($seconds > 0) {
            $expiredAt = sprintf('+%d seconds', $seconds);
        }

        return $this->setExpiredAt($expiredAt);
    }

    public function getScope(): string
    {
        return (string)parent::getScope();
    }

    public function isVerified(): bool
    {
        return parent::isVerified();
    }
}
