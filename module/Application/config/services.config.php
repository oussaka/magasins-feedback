<?php
use Application\Service\ErrorHandling as ErrorHandlingService;
use Zend\Log\Logger;
use Zend\Log\Writer\Stream as LogWriterStream;

return array(
    'factories' => array(
        'elasticsearch' => function ($sm) {
            $config = $sm->get('config');
            $srv = new \Elastica\Client(
                array(
                    'host' => $config['elasticsearch']['connection']['params']['host'],
                    'port' => $config['elasticsearch']['connection']['params']['port']
                )
            );
            return $srv;
        },
        'doctrine.cache.my_memcache' => function ($sm) {
            $cache = new \Doctrine\Common\Cache\MemcacheCache();
            $memcache = new \Memcache();
            $config = $sm->get('config');
            $memcache->connect(
                $config['memcache']['host'],
                $config['memcache']['port']
            );
            $cache->setMemcache($memcache);
            return $cache;
        },
        'Application\Service\ErrorHandling' =>  function($sm) {
                $logger = $sm->get('Zend\Log');
                $service = new ErrorHandlingService($logger);
                return $service;
            },
        'Zend\Log' => function ($sm) {
                $filename = 'log_' . date('F') . '.txt';
                $log = new Logger();
                $writer = new LogWriterStream('./data/logs/' . $filename);
                $log->addWriter($writer);

                return $log;
        },

    )
);
