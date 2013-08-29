<?php

namespace SM\Bundle\AdminBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\VariableNodeDefinition;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('sm_admin');

        $rootNode->children()
                    ->arrayNode('dashboard')
                        ->defaultValue(array(array('class' => 'SM\Bundle\AdminBundle\Entity\Page', 'group' => 'User', 'label' => 'User')))
                            ->prototype('array')
                                ->children()
                                    ->scalarNode('class')->cannotBeEmpty()->end()
                                    ->scalarNode('group')->defaultValue('User')->end()
                                    ->scalarNode('label')->defaultValue('User')->end()
                                    ->booleanNode('acl')->end()
                                    ->arrayNode('action')->defaultValue(array())->prototype('scalar')->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()

                    ->variableNode('templates')->defaultValue("1")->end()
                ->end();

        // Here you should define the parameters that are allowed to
        // configure your bundle. See the documentation linked above for
        // more information on that topic.

        return $treeBuilder;
    }
}
