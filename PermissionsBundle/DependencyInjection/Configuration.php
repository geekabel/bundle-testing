<?php

/*
 * This file is part of the EloyekunlePermissionsBundle package.
 *
 * (c) Elijah Oyekunle <https://elijahoyekunle.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Eloyekunle\PermissionsBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('eloyekunle_permissions');
        $rootNode = method_exists(TreeBuilder::class, 'getRootNode') ? $treeBuilder->getRootNode() : $treeBuilder->root('eloyekunle_permissions');
        //$rootNode = $treeBuilder->getRootNode();

        $supportedDrivers = ['orm','mongodb'];

        $rootNode
            ->addDefaultsIfNotSet()
            ->children()
                ->scalarNode('db_driver')
                    ->validate()
                        ->ifNotInArray($supportedDrivers)
                        ->thenInvalid('The driver %s is not supported. Please choose one of '.json_encode($supportedDrivers))
                    ->end()
                    ->cannotBeOverwritten()
                    ->defaultValue('orm')
                ->end()
                ->scalarNode('role_class')->isRequired()->cannotBeEmpty()->end()
                ->scalarNode('model_manager_name')->defaultNull()->end()
            ->end();

        $this->addModuleSection($rootNode);

        return $treeBuilder;
    }

    private function addModuleSection(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('module')
                ->addDefaultsIfNotSet()
                ->canBeUnset()
                ->children()
                ->scalarNode('definitions_path')->isRequired()->cannotBeEmpty()->end()
                ->end()
           ;
    }
}
