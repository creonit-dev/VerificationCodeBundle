<?php

namespace Creonit\VerificationCodeBundle\DataCollector;

use Creonit\VerificationCodeBundle\Event\CreateCodeEvent;
use Creonit\VerificationCodeBundle\Model\VerificationCodeInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\DataCollector\DataCollector;

class VerificationCodeCollector extends DataCollector
{
    /**
     * @var VerificationCodeInterface[]
     */
    protected $codes = [];

    public function collect(Request $request, Response $response, \Throwable $exception = null)
    {
        $this->data = [
            'codes' => $this->codes,
        ];
    }

    public function getName()
    {
        return 'creonitVerificationCode.verificationCode';
    }

    public function reset()
    {
        $this->data = [
            'codes' => [],
        ];
    }

    public function onCreateCode(CreateCodeEvent $event)
    {
        $this->addCode($event->getVerificationCode());
    }

    protected function addCode(VerificationCodeInterface $code)
    {
        $this->codes[] = $code;
    }

    /**
     * @return VerificationCodeInterface[]
     */
    public function getCodes(): array
    {
        return $this->data['codes'] ?? [];
    }
}