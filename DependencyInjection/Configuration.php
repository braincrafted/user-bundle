<?php
/**
 * This file is part of BraincraftedUserBundle.
 * (c) 2013 Florian Eckerstorfer
 */

namespace Braincrafted\Bundle\UserBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Configuration
 *
 * @package    BraincraftedUserBundle
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
        $rootNode = $treeBuilder->root('braincrafted_user');

        $rootNode
            ->children()
                ->arrayNode('registration')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('enabled')->defaultValue(true)->end()
                        ->scalarNode('invite_required')->defaultValue(false)->end()
                    ->end()
                ->end()
                ->scalarNode('db_driver')->defaultValue('orm')->end()
                ->scalarNode('firewall_name')->defaultValue('main')->end()
                ->scalarNode('user_class')->defaultValue('Braincrafted\Bundle\UserBundle\Entity\User')->end()
                ->scalarNode('invite_class')->defaultValue('Braincrafted\Bundle\UserBundle\Entity\Invite')->end()
                ->scalarNode('invite_request_class')->defaultValue('Braincrafted\Bundle\UserBundle\Entity\InviteRequest')->end()
                ->arrayNode('assets')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('output_dir')->defaultValue('')->end()
                    ->end()
                ->end()
            ->end();
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
                                ->scalarNode('type')->defaultValue('braincrafted_user_request_invite')->end()
                                ->scalarNode('handler')->defaultValue('braincrafted_user.request_invite.form.handler.default')->end()
                                ->scalarNode('name')->defaultValue('braincrafted_user_request_invite_form')->end()
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
