<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Initializer\EntityManagerAware;
use Application\Initializer\ElasticsearchAware;
use Application\Entity\User;
use Zend\Http\Response;
use Zend\Authentication\AuthenticationService;


class IndexController extends AbstractActionController implements EntityManagerAware, ElasticsearchAware
{
    private $em;
    private $es;

    public function indexAction()
    {
        $this->headTitle("Indicateurs Magasins");
        


        return new ViewModel();
    }

    public function getEm()
    {
        return $this->em;
    }

    public function setEm($em)
    {
        $this->em = $em;
    }

    public function setEs($es)
    {
        $this->es = $es;
    }

    public function getEs()
    {
        return $this->es;
    }
    
    public function forbiddenAction()
    {
    	$this->getResponse()->setStatusCode(301);
    	$authService = new AuthenticationService();
    	$auth = $authService->getStorage()->read();
    	
    	return new ViewModel(array(
    			'auth' => $auth,
    	));
    }
}
