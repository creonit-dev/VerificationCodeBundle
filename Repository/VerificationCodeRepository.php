<?php

namespace Creonit\VerificationCodeBundle\Repository;


use Creonit\VerificationCodeBundle\Context\CodeContext;
use Creonit\VerificationCodeBundle\Model\VerificationCode;
use Creonit\VerificationCodeBundle\Model\VerificationCodeInterface;
use Creonit\VerificationCodeBundle\Model\VerificationCodeQuery;
use Propel\Runtime\ActiveQuery\Criteria;

class VerificationCodeRepository implements VerificationCodeRepositoryInterface
{
    public function create(CodeContext $context): VerificationCodeInterface
    {
        $code = new VerificationCode();

        $code
            ->setScope($context->getScope())
            ->setKey($context->getKey())
            ->setCode($context->getCode())
            ->setActive($context->isActive());

        if ($context->getExpiredAfter()) {
            $code->setExpiredAfter($context->getExpiredAfter());

        } else {
            $code->setExpiredAt($context->getExpiredAt());
        }

        return $code;
    }

    public function save(VerificationCodeInterface $verificationCode)
    {
        if (!$verificationCode instanceof VerificationCode) {
            throw new \InvalidArgumentException("Unsupported class - " . get_class($verificationCode));
        }

        return $verificationCode->save();
    }

    protected function getQuery(CodeContext $context)
    {
        return VerificationCodeQuery::create()
            ->filterByScope($context->getScope())
            ->filterByKey($context->getKey())
            ->_if(!empty($context->getCode()))
            ->filterByCode($context->getCode())
            ->_endif()
            ->filterByActive($context->isActive())
            ->_if($context->isActive())
                ->filterByVerified(false)
                ->filterByExpiredAt(new \DateTime(), Criteria::GREATER_THAN)
                ->_or()
                ->filterByExpiredAt(null)
            ->_endif();
    }

    public function findByContext(CodeContext $context): ?VerificationCodeInterface
    {
        return $this->getQuery($context)->findOne();
    }

    public function deactivate(CodeContext $context)
    {
        return $this->getQuery($context)->update(['Active' => false]);
    }
}