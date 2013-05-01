<?php
/**
 * This file is part of BcUserBundle.
 *
 * (c) 2013 Florian Eckerstorfer
 */

namespace Bc\Bundle\UserBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Config\Resource\FileResource;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

/**
 * BcUserExtension
 *
 * @package    BcUserBundle
 * @subpackage DependencyInjection
 * @author     Florian Eckerstorfer <florian@eckerstorfer.co>
 * @copyright  2013 Florian Eckerstorfer
 * @license    http://opensource.org/licenses/MIT The MIT License
 * @link       http://bootstrap.braincrafted.com Bootstrap for Symfony2
 */
class BcUserExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));

        foreach (array('services') as $basename) {
            $loader->load(sprintf('%s.xml', $basename));
        }

        if (!isset($config['registration']['enabled'])) {
            throw new \InvalidArgumentException('The option "registration.enabled" must be set.');
        }
        if (!isset($config['registration']['invite_required'])) {
            throw new \InvalidArgumentException('The option "registration.invite_required" must be set.');
        }

        $container->setParameter('bc_user.registration.enabled', $config['registration']['enabled']);
        $container->setParameter('bc_user.registration.invite_required', $config['registration']['invite_required']);

        if (!empty($config['request_invite'])) {
            $this->loadInvite($config['request_invite'], $container, $loader);
        }

        $files = $container->getParameter('validator.mapping.loader.xml_files_loader.mapping_files');
        $validationFile = __DIR__ . '/../Resources/config/validation/orm.xml';

        if (is_file($validationFile)) {
            $files[] = realpath($validationFile);
            $container->addResource(new FileResource($validationFile));
        }

        $container->setParameter('validator.mapping.loader.xml_files_loader.mapping_files', $files);
    }

    private function loadInvite(array $config, ContainerBuilder $container, XmlFileLoader $loader)
    {
        $loader->load('invite.xml');

        $container->setAlias('bc_user.request_invite.form.handler', $config['form']['handler']);
        unset($config['form']['handler']);

        $this->remapParametersNamespaces(
            $config,
            $container,
            array('form' => 'bc_user.request_invite.form.%s')
        );
    }

    protected function remapParametersNamespaces(array $config, ContainerBuilder $container, array $namespaces)
    {
        foreach ($namespaces as $ns => $map) {
            if ($ns) {
                if (!array_key_exists($ns, $config)) {
                    continue;
                }
                $namespaceConfig = $config[$ns];
            } else {
                $namespaceConfig = $config;
            }

            if (is_array($map)) {
                $this->remapParameters($namespaceConfig, $container, $map);
            } else {
                foreach ($namespaceConfig as $name => $value) {
                    $container->setParameter(sprintf($map, $name), $value);
                }
            }
        }
    }
}
