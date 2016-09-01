<?php

class SessionController extends Zend_Controller_Action {
    
    public function loginAction() {
        
        $this->view->dontShowPrice = true;
        $this->view->dontShowInformation = false;
        
    }
    
}
