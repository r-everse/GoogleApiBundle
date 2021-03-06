<?php

namespace HappyR\Google\ApiBundle\DependencyInjection;

use HappyR\Google\ApiBundle\Services\GoogleClient;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class HappyRGoogleApiExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $this->loadClients($config['clients'], $container);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
    }

    private function loadClients(array $clients, ContainerBuilder $container)
    {
        $first = true;
        foreach ($clients as $name => $client) {
            if ($first) {
                $container->setParameter('happy_r_google_api', $client);
                $first = false;
            }

            $clientId = sprintf("happyr.google.api.%s.client", $name);

            $clientDef = new Definition(GoogleClient::class, [$client]);
            $container->setDefinition($clientId, $clientDef);
        }
    }
}
