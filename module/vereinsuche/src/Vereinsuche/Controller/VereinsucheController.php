<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/Vereinsuche for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Vereinsuche\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class VereinsucheController extends AbstractActionController
{
    public function indexAction()
    {
         return new ViewModel(array(
             'vereine' => $this->getVereinTable()->fetchAll(),
         ));
    }

    public function getVereinTable()
    {
        if (!$this->vereinTable) {
            $sm = $this->getServiceLocator();
            $this->vereinTable = $sm->get('Vereinsuche\Model\VereinTable');
        }
        return $this->vereinTable;
    }
    
    protected $vereinTable;
    
}
