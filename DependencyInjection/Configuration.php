<?php

namespace Creonit\VerificationCodeBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('creonit_verification_code');

        $rootNode = $treeBuilder->getRootNode();
        $this->addGenerator($rootNode);
        $this->addScopes($rootNode);

        return $treeBuilder;
    }

    protected function addGenerator(ArrayNodeDefinition $rootNode)
    {
        $rootNode
            ->children()
                ->arrayNode('generator')
                    ->children()
                        ->scalarNode('service')->defaultValue('creonit_verification_code.generator.number')
                            ->beforeNormalization()
                                ->ifTrue(function($v) {
                                    return \is_string($v) && 0 === strpos($v, '@');
                                })
                                ->then(function($v) {
                                    return substr($v, 1);
                                })
                            ->end()
                        ->end()
                        ->arrayNode('config')
                            ->variablePrototype()
                        ->end()
                    ->end()
            ->end();
    }

    protected function addScopes(ArrayNodeDefinition $rootNode)
    {
        $rootNode
            ->children()
            ->arrayNode('scopes')
                ->normalizeKeys(false)
                ->useAttributeAsKey('key')
                ->variablePrototype()
            ->end();
    }
}