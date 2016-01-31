<?php
namespace Application\Listener;

class DispatchErrorHandlerListener {

    public function __invoke(MvcEvent $e)
    {
        $exception = $e->getParam('exception');

        //it is just a sample, you can create service for logger
        $writer = new \Zend\Log\Writer\Stream('./data/logs/'.date('Y-m-d').'-log.txt');
        $log      = new \Zend\Log\Logger();
        $log->addWriter($writer);

        $log->err($exception);
    }
} 