<?php
/**
 * This file is part of braincrafted/user-bundle.
 *
 * (c) 2013 Florian Eckerstorfer
 */

namespace Bc\Bundle\UserBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Configuration
 *
 * @package    braincrafted/user-bundle
 * @subpackage DependencyInjection
 * @author     Florian Eckerstorfer <florian@eckerstorfer.co>
 * @copyright  2013 Florian Eckerstorfer
 * @license    http://opensource.org/licenses/MIT The MIT License
 * @link       http://bootstrap.braincrafted.com Bootstrap for Symfony2
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('bc_user');

        $this->addRequestInviteSection($rootNode);

        return $treeBuilder;
    }

    private function addRequestInviteSection(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('request_invite')
                    ->addDefaultsIfNotSet()
                    ->canBeUnset()
                    ->children()
                        ->arrayNode('form')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('type')->defaultValue('bc_user_request_invite')->end()
                                ->scalarNode('handler')->defaultValue('bc_user.request_invite.form.handler.default')->end()
                                ->scalarNode('name')->defaultValue('bc_user_request_invite_form')->end()
                                ->arrayNode('validation_groups')
                                    ->prototype('scalar')->end()
                                    ->defaultValue(array('RequestInvite'))
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();
    }
}
