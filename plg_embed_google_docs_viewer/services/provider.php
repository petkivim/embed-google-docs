<?php

defined('_JEXEC') or die('Restricted access');
use Joomla\CMS\Extension\PluginInterface;
use Joomla\CMS\Factory;
use Joomla\CMS\Plugin\PluginHelper;
use Joomla\DI\Container;
use Joomla\DI\ServiceProviderInterface;
use Joomla\Event\DispatcherInterface;
use Joomla\Plugin\Content\EmbedGoogleDocsViewer\Extension\EmbedGoogleDocsViewer;

    return new class() implements ServiceProviderInterface
    {
        public function register(Container $container)
        {
            $container->set(
                PluginInterface::class,
                function (Container $container) {
    
                    $config = (array) PluginHelper::getPlugin('content', 'embed_google_docs_viewer');
                    $subject = $container->get(DispatcherInterface::class);
                    $app = Factory::getApplication();
                    
                    $plugin = new EmbedGoogleDocsViewer($subject, $config);
                    $plugin->setApplication($app);
    
                    return $plugin;
                }
            );
        }
    };