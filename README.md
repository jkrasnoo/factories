# Factory Libraries for use with ZendSkeletonApplication

## Introduction

This is a library of often needed factories that Zend Framework doesn't provide
for the reason they believe it belongs in userland. Meaning that most often users
create and implement the factory or class themselves.

## Installation using Composer

Installing the library using Composer is simple.

```bash
$ composer require jkrasnoo\factories
```

## Components

### Cache Session Save Handler Factory

This is a session save handler cache factory. To use this factory to attach the Zend\Cache save
handler to the service manager you should follow the configuration below. You should put this in
a global config.


```php
<?php
use Zend\Session\SaveHandler\SaveHandlerInterface;
use Jkrasnoo\Factories\Service\CacheSessionSaveHandlerFactory;

return [
    'factories' => [
        SaveHandlerInterface::class => CacheSessionSaveHandlerFactory::class
     ]
];

```

This also belongs in a separate global config. The first config is if you already have
configured a cache.

```php
<?php

return [
    'session_save_handler' => [
        'cache' => 'Your/Cache/Service/Name'
    ]
];
```

This config is to have the factory create a separate cache that is just for the handler. It can not
be accessed through the service manager. It uses a  `Zend\Cache\StorageFactory` configuration.

```php
<?php

return [
    'session_save_handler' => [
        'cache' => [
            'adapter' => [
                'name'      => 'memcache',
                'options'   => [
                    'minTtl'  => 1,
                    'maxTtl'  => 0,
                    'servers' => [
                        // list of servers here    
                    ]
                ]
            ]
        ]
    ]  
];
```