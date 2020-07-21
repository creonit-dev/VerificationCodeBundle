<?php

namespace Creonit\VerificationCodeBundle\DependencyInjection;

use Creonit\VerificationCodeBundle\Generator\CodeGeneratorInterface;
use Creonit\VerificationCodeBundle\Scope\VerificationScope;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ChildDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class CreonitVerificationCodeExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yaml');

        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $this->initGenerator($container, $config['generator'] ?? []);
        $this->initScopes($container, $config['scopes'] ?? []);
    }

    protected function initGenerator(ContainerBuilder $container, array $config)
    {
        $defaultGeneratorId = $config['service'] ?? 'creonit_verification_code.generator.number';
        $defaultGeneratorConfig = $config['config'] ?? [];

        $container->setParameter('creonit_verification_code.default_generator_id', $defaultGeneratorId);
        $container->setParameter('creonit_verification_code.default_generator_config', $defaultGeneratorConfig);

        $definition = $this->createGeneratorDefinition($defaultGeneratorId, $defaultGeneratorConfig);

        $container->setDefinition('creonit_verification_code.generator.default', $definition);
        $container->setAlias(CodeGeneratorInterface::class, 'creonit_verification_code.generator.default');
    }

    protected function createGeneratorDefinition(string $parent, array $config)
    {
        $definition = new ChildDefinition($this->normalizeServiceId($parent));
        $definition->addMethodCall('setConfig', [$config]);

        return $definition;
    }

    protected function initScopes(ContainerBuilder $container, array $scopes)
    {
        if (empty($scopes)) {
            $scopes = [
                'default' => [],
            ];
        }

        $defaultConfig = [
            'generator' => [
                'service' => $container->getParameter('creonit_verification_code.default_generator_id'),
                'config' => $container->getParameter('creonit_verification_code.default_generator_config'),
            ],
            'max_age' => 0,
        ];

        $codeManagerDefinition = $container->getDefinition('creonit_verification_code.code_manager');

        foreach ($scopes as $name => $config) {
            $config = array_merge($defaultConfig, $config);

            $scopeDefinition = $this->createScopeDefinition($name, $config);
            $codeManagerDefinition->addMethodCall('addScope', [$scopeDefinition]);
        }
    }

    protected function createScopeDefinition(string $name, array $config)
    {
        $definition = new ChildDefinition(VerificationScope::class);
        $definition
            ->setArgument('$name', $name)
            ->setPublic(false)
            ->setClass(VerificationScope::class);

        $generatorConfig = $config['generator'];
        $generator = $this->createGeneratorDefinition($generatorConfig['service'], $generatorConfig['config'] ?? []);

        unset($config['generator']);

        $definition
            ->addMethodCall('setConfig', [$config])
            ->addMethodCall('setCodeGenerator', [$generator]);

        return $definition;
    }

    protected function normalizeServiceId(string $id)
    {
        return preg_replace('/^@{1,2}/', '', $id);
    }
}