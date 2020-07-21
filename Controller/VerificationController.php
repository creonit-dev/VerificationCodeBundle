<?php

namespace Creonit\VerificationCodeBundle\Controller;

use Creonit\RestBundle\Annotation\Parameter\PathParameter;
use Creonit\RestBundle\Annotation\Parameter\RequestParameter;
use Creonit\RestBundle\Handler\RestHandler;
use Creonit\VerificationCodeBundle\CodeManager;
use Creonit\VerificationCodeBundle\Context\CodeContext;
use Creonit\VerificationCodeBundle\Exception\UnknownScopeException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * @Route("/verificationCode")
 */
class VerificationController extends AbstractController
{
    /**
     * Генерация кода верификации
     *
     * @PathParameter("scope", description="Группа верификации", required=false)
     * @RequestParameter("key", required=true, description="Ключ верификации")
     *
     * @Route("/{scope}", methods={"POST"}, defaults={"scope": "default"})
     */
    public function createCode(RestHandler $handler, CodeManager $codeManager, string $scope)
    {
        try {
            $scope = $codeManager->getScope($scope);

        } catch (UnknownScopeException $e) {
            $handler->error->set('path/scope', $e->getMessage())->send();
        }

        $handler->validate([
            'request' => [
                'key' => $scope->getKeyConstraints(),
            ],
        ]);

        $request = $handler->getRequest();

        $context = new CodeContext($request->request->get('key'), $scope->getName());

        if ($nextTime = $codeManager->getNextAttemptTime($context)) {
            $handler->error
                ->set('request/time', $nextTime)
                ->send("Генерация недоступна", 1);
        }

        return $handler->response($codeManager->createCode($context));
    }

    /**
     * Верификация кода
     *
     * @PathParameter("scope", description="Группа верификации", required=false)
     *
     * @RequestParameter("key", required=true, description="Ключ верификации")
     * @RequestParameter("code", required=true, description="Код верификации")
     *
     * @Route("/{scope}", methods={"PUT"}, defaults={"scope": "default"})
     */
    public function verificationCode(RestHandler $handler, CodeManager $codeManager, string $scope)
    {
        try {
            $scope = $codeManager->getScope($scope);

        } catch (UnknownScopeException $e) {
            $handler->error->set('path/scope', $e->getMessage())->send();
        }

        $handler->validate([
            'request' => [
                'key' => $scope->getKeyConstraints(),
                'code' => [new NotBlank()],
            ],
        ]);

        $request = $handler->getRequest();

        $context = new CodeContext($request->request->get('key'), $scope->getName());
        $context->setCode($request->request->get('code'));

        return $handler->response(['verified' => $codeManager->verificationCode($context)]);
    }
}