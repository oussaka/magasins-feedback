<?php
namespace Indicateur;

class Module
{
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getServiceConfig()
    {
        return array(
        );
    }

    public function getControllerConfig()
    {
        return array(
            'initializers' => array(
            ),
            'factories' => array(
                'Indicateur\Controller\ScoreAjax' => function ($sm) {

                        $authService = new \Zend\Authentication\AuthenticationService;
                        if ($authService->hasIdentity()) {
                            // Identity exists; get it
                            $etabId = $authService->getIdentity()->et_code_fk;
                            $puiId = $authService->getIdentity()->pui_code_fk;
                            $userId = $authService->getIdentity()->user_code_pk;
                        }

                        $controller = new \Indicateur\Controller\ScoreAjaxController();
                        $controller->setEtabId($etabId);
                        $controller->setPuiId($puiId);
                        $controller->setUserId($userId);
                        // $locator = $sm->getServiceLocator();
                        // $controller->setCommentForm($locator->get('commentForm'));
                        // $controller->setCommentService($locator->get('commentService'));
                        return $controller;
                }
            ),
        );
    }
}
