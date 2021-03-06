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

use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Alias;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class EloyekunlePermissionsExtension extends Extension
{
    /**
     * @var array
     */
    private static $doctrineDrivers = array(
        'orm' => [
            'registry' => 'doctrine',
            'tag' => 'doctrine.event_subscriber',
        ],
        'mongodb' => [
            'registry' => 'doctrine_mongodb',
            'tag' => 'doctrine_mongodb.odm.event_subscriber',
        ],
    );

    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $processor = new Processor();
        $configuration = new Configuration();

        $config = $processor->processConfiguration($configuration, $configs);

        $loader = new XmlFileLoader(
            $container,
            new FileLocator(dirname(__DIR__) . '/Resources/config')
        );

        $loader->load('doctrine.xml');
        $container->setAlias(
            'eloyekunle_permissions.doctrine_registry',
            new Alias(self::$doctrineDrivers[$config['db_driver']]['registry'], false)
        );
        $container->setParameter($this->getAlias() . '.backend_type_' . $config['db_driver'], true);

        if (isset(self::$doctrineDrivers[$config['db_driver']])) {
            $definition = $container->getDefinition('eloyekunle_permissions.object_manager');
            $definition->setFactory([new Reference('eloyekunle_permissions.doctrine_registry'), 'getManager']);
        }

        $this->remapParametersNamespaces($config, $container, [
            '' => [
                'db_driver' => 'eloyekunle_permissions.storage',
                'role_class' => 'eloyekunle_permissions.model.role.class',
                'model_manager_name' => 'eloyekunle_permissions.model_manager_name',
            ],
        ]
        );

        $this->loadRole($config, $container, $loader);

        if (!empty($config['module'])) {
            $this->loadPermissions($config['module'], $container, $loader);
        }
    }

    /**
     * @param array            $config
     * @param ContainerBuilder $container
     * @param array            $map
     */
    protected function remapParameters(array $config, ContainerBuilder $container, array $map)
    {
        foreach ($map as $name => $paramName) {
            if (array_key_exists($name, $config)) {
                $container->setParameter($paramName, $config[$name]);
            }
        }
    }

    /**
     * @param array            $config
     * @param ContainerBuilder $container
     * @param array            $namespaces
     */
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

    private function loadRole(array $config, ContainerBuilder $container, XmlFileLoader $loader)
    {
        $loader->load('role.xml');
        $loader->load('doctrine_role.xml');

        $container->setAlias('eloyekunle_permissions.role_manager', new Alias('eloyekunle_permissions.role_manager.default', true)
        );
    }

    private function loadPermissions(array $config, ContainerBuilder $container, XmlFileLoader $loader)
    {
        $loader->load('permissions.xml');

        $this->remapParametersNamespaces(
            $config,
            $container,
            [
                '' => [
                    'definitions_path' => 'eloyekunle_permissions.module.definitions_path',
                ],
            ]
        );
    }
}
