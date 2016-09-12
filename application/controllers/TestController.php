<?php

class TestController extends Zend_Controller_Action{
    
    
    public function testAction() {
        Zend_Layout::getMvcInstance()->disableLayout();
        
        $user = Zend_Auth::getInstance()->hasIdentity();
        
        if(!$user) {
            
            $redirector = $this->getHelper('Redirector');
		$redirector instanceof Zend_Controller_Action_Helper_Redirector;

		$redirector->setExit(true)
			->gotoRoute(array(

				'controller' => 'admin_session',
				'action' => 'login'

			), 'default', true);
            
        }
        
    }
    
    
}