# Doctrine Encoded Cache Bundle

This bundle integrates a Symfony2 application with the `trt/doctrine-encoded-cache` library.

##Why cache encoding?
Because sometimes there is the need to make the cached data unreadable. 
Think about high confidential data.  
Only database servers are authorized to store datas.
 
## How?
Cached data will be encrypted/decripted with AES256 (**php-mcrypt extension is required**)
 
## Installation

run `php composer.phar require trt/doctrine-encrypted-cache-bundle:~0.1`

## Create your KeyProvider

Put the following lines with Symfony Kernel 

```php
    public function registerBundles()
    {
        $bundles = array(

            new Doctrine\Bundle\DoctrineCacheBundle\DoctrineCacheBundle(),
            new Trt\Doctrine\Cache\Bundle\DoctrineEncodedCacheBundle()
        );
        
    }
```

For security reason it's your responsability to store the encoding key in a safe place, so a key provider service is mandatory.

Create your own service implementing the `KeyProvider` interface.

Example:

```php
class CacheKeyProvider implements \Trt\Doctrine\Cache\Key\KeyProvider
{

    /**
     * Provide the encoding key string.
     *
     * @return String
     */
    public function getKey()
    {
        return $this->fetchKeyFromASafePlace();
    }
}
```

Register the service:

```yml
services:
  my_bundle.cache.key_provider:
   class: My\Bundle\CacheKeyProvider
```

## Full Configuration

According to the [DoctrineCacheBundle](https://github.com/doctrine/DoctrineCacheBundle) documentation, configure the cache service

```yml
## An Example with apc cache
doctrine_cache:
    aliases:
        cache_apc: my_apc_cache

    providers:
        my_apc_cache:
            type: apc
            namespace: my_apc_cache_ns
            aliases:
                - apc_cache

doctrine_encoded_cache:
  key_provider: my_bundle.cache.key_provider #Your key provider service
  cache: apc_cache #The doctrine cache service


# Enable the doctrine ORM cache
doctrine:
	orm:
	    result_cache_driver:
	        type: service
	        id: doctrine_encoded_cache 
	    metadata_cache_driver:
	        type: service
	        id: doctrine_encoded_cache
	    query_cache_driver:
	        type: service
	        id: doctrine_encoded_cache
```
