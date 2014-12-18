<?php
/**
 * Created by PhpStorm.
 * User: toretto
 * Date: 17/12/14
 * Time: 21:52
 */

namespace Trt\Doctrine\Cache\Bundle\Compiler;


use Doctrine\Common\Cache\Cache;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Trt\Doctrine\Cache\Key\KeyProvider;

class CompilerPass implements CompilerPassInterface
{

    /**
     * You can modify the container here before it is dumped to PHP code.
     *
     * @param ContainerBuilder $container
     *
     * @api
     */
    public function process(ContainerBuilder $container)
    {
        if (
            !$container->hasDefinition('doctrine_encoded_cache.cache') ||
            $container->hasDefinition('doctrine_encoded_cache.cache') instanceof Cache
        ) {

            throw new \InvalidArgumentException(
                sprintf(
                    "The cache service [%s] must be instance of %s",
                    $container->getAlias('doctrine_encoded_cache.cache'),
                    'Doctrine\Common\Cache\Cache'
                )
            );
        }


        if (
            !$container->hasDefinition('doctrine_encoded_cache.key.provider') ||
            $container->hasDefinition('doctrine_encoded_cache.key.provider') instanceof KeyProvider
        ) {

            throw new \InvalidArgumentException(
                sprintf(
                    "The cache service [%s] must be instance of %s",
                    $container->getAlias('doctrine_encoded_cache.key.provider'),
                    'Trt\Doctrine\Cache\Key\KeyProvider'
                )
            );
        }


    }
}