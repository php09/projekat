<?php

class SessionController extends Zend_Controller_Action {
    
    public function init() {
        $this->view->dontShowPrice = true;
        $this->view->dontShowInformation = false;
    }
    
    public function loginAction() {
        
    }
    
    
    public function passwordAction() {
        
    }
    
    
    public function registerAction() {
        
    }
    
    public function userpanelAction() {
        $this->view->dontShowInformation = true;
    }
}
