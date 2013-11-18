<?php
/**
 * This file is part of BraincraftedUserBundle.
 * (c) 2013 Florian Eckerstorfer
 */

namespace Braincrafted\Bundle\UserBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Config\Resource\FileResource;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

/**
 * BraincraftedUserExtension
 *
 * @package    BraincraftedUserBundle
 * @subpackage DependencyInjection
 * @author     Florian Eckerstorfer <florian@eckerstorfer.co>
 * @copyright  2013 Florian Eckerstorfer
 * @license    http://opensource.org/licenses/MIT The MIT License
 * @link       http://bootstrap.braincrafted.com Bootstrap for Symfony2
 */
class BraincraftedUserExtension extends Extension implements PrependExtensionInterface
{
    /** @var string */
    private $formTemplate = 'BraincraftedUserBundle:Form:form_div_layout.html.twig';

    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));

        foreach (array('services', 'registration', 'admin') as $basename) {
            $loader->load(sprintf('%s.xml', $basename));
        }

        if (!isset($config['registration']['enabled'])) {
            throw new \InvalidArgumentException('The option "registration.enabled" must be set.');
        }
        $container->setParameter('braincrafted_user.registration.enabled', $config['registration']['enabled']);

        if (!isset($config['registration']['invite_required'])) {
            throw new \InvalidArgumentException('The option "registration.invite_required" must be set.');
        }
        $container->setParameter('braincrafted_user.registration.invite_required', $config['registration']['invite_required']);

        if (!isset($config['db_driver'])) {
            throw new \InvalidArgumentException('The option "db_driver" must be set.');
        }
        if (!isset($config['firewall_name'])) {
            throw new \InvalidArgumentException('The option "firewall_name" must be set.');
        }

        if (!isset($config['user_class'])) {
            throw new \InvalidArgumentException('The option "braincrafted_user.user_class" must be set.');
        }
        $container->setParameter('braincrafted_user.user.class', $config['user_class']);

        if (!isset($config['invite_class'])) {
            throw new \InvalidArgumentException('The option "braincrafted_user.invite_class" must be set.');
        }
        $container->setParameter('braincrafted_user.invite.class', $config['invite_class']);

        if (!isset($config['invite_request_class'])) {
            throw new \InvalidArgumentException('The option "braincrafted_user.invite_request_class" must be set.');
        }
        $container->setParameter('braincrafted_user.invite_request.class', $config['invite_request_class']);

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

    /**
     * {@inheritDoc}
     */
    public function prepend(ContainerBuilder $container)
    {
        $bundles = $container->getParameter('kernel.bundles');

        // Configure FOSUserBundle
        if (isset($bundles['FOSUserBundle'])) {
            $this->configureFosUserBundle($container);
        }

        // Configure Twig if TwigBundle is activated and the option
        // "braincrafted_bootstrap.auto_configure.twig" is set to TRUE (default value).
        if (isset($bundles['TwigBundle'])) {
            $this->configureTwigBundle($container);
        }

        // Configure AsseticBundle
        if (isset($bundles['AsseticBundle'])) {
            $this->configureAsseticBundle($container);
        }
    }

    /**
     * Configures FosUserBundle.
     *
     * @param ContainerBuilder $container The service container
     *
     * @return void
     *
     * @SuppressWarnings(PHPMD.UnusedLocalVariable)
     */
    private function configureFosUserBundle(ContainerBuilder $container)
    {
        $configs = $container->getExtensionConfig($this->getAlias());
        $config = $this->processConfiguration(new Configuration(), $configs);

        if ($config['registration']['invite_required']) {
            $registrationValidationGroups = array('Default', 'Registration', 'RegistrationWithInvite');
        } else {
            $registrationValidationGroups = array('Default', 'Registration');
        }

        foreach ($container->getExtensions() as $name => $extension) {
            switch ($name) {
                case 'fos_user':
                    $container->prependExtensionConfig(
                        $name,
                        array(
                            'db_driver'     => $config['db_driver'],
                            'firewall_name' => $config['firewall_name'],
                            'user_class'    => 'Braincrafted\Bundle\UserBundle\Entity\User',
                            'registration'  => array(
                                'form' => array(
                                    'type'                  => 'braincrafted_user_registration',
                                    'validation_groups'     => $registrationValidationGroups,
                                    'handler'               => 'braincrafted_user.registration.form.handler'
                                )
                            )
                        )
                    );
                    break;
            }
        }
    }


    /**
     * Configures the TwigBundle.
     *
     * @param ContainerBuilder $container The service container
     *
     * @return void
     */
    private function configureTwigBundle(ContainerBuilder $container)
    {
        foreach ($container->getExtensions() as $name => $extension) {
            switch ($name) {
                case 'twig':
                    $container->prependExtensionConfig(
                        $name,
                        array('form'  => array('resources' => array($this->formTemplate)))
                    );
                    break;
            }
        }
    }

    /**
     * Configures AsseticBundle.
     *
     * @param ContainerBuilder $container The service container
     *
     * @return void
     *
     * @SuppressWarnings(PHPMD.UnusedLocalVariable)
     */
    private function configureAsseticBundle(ContainerBuilder $container)
    {
        $configs = $container->getExtensionConfig($this->getAlias());
        $config = $this->processConfiguration(new Configuration(), $configs);

        foreach ($container->getExtensions() as $name => $extension) {
            switch ($name) {
                case 'assetic':
                    $container->prependExtensionConfig(
                        $name,
                        array(
                            'assets'    => $this->buildAsseticConfig($config)
                        )
                    );
                    break;
            }
        }
    }

    /**
     * Builds the configuration for AsseticBundle.
     *
     * @param array $config The BraincraftedUserAdmin configuration
     *
     * @return array The configuration for AsseticBundle
     */
    private function buildAsseticConfig(array $config)
    {
        $output = array(
            'braincrafted_user_admin_css' => array(
                'inputs'    => array(
                    __DIR__.'/../Resources/sass/user-admin.scss'
                ),
                'filters'   => array('cssrewrite'),
                'output'    => $config['assets']['output_dir'].'/css/user-admin.css'
            )
        );

        return $output;
    }

    private function loadInvite(array $config, ContainerBuilder $container, XmlFileLoader $loader)
    {
        $loader->load('invite.xml');

        $container->setAlias('braincrafted_user.request_invite.form.handler', $config['form']['handler']);
        unset($config['form']['handler']);

        $this->remapParametersNamespaces(
            $config,
            $container,
            array('form' => 'braincrafted_user.request_invite.form.%s')
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
