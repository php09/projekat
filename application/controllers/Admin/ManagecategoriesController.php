<?php

class Admin_ManagecategoriesController extends Zend_Controller_Action
{
    
    public function indexAction()
    {
        //placeholder
        $characteristicId = 1;
        
        $table = new Zend_Db_Table("cms_product_types_product_characteristics");
        $select = $table->select();
        $select->where("product_characteristic_id = ? ", $characteristicId);
        $chars = $table->fetchAll()->toArray();
        
        $this->view->chars = $chars;
        
    }
    
    
    public function producttypesAction() {
        Zend_Layout::getMvcInstance()->disableLayout();

        $request = $this->getRequest();
        $request instanceof Zend_Controller_Request_Http;
        
        if(!$request->isXmlHttpRequest()) {
            $redirector = $this->getHelper('Redirector');
            $redirector->setExit(true)
                ->gotoRoute(array(
                    'controller' => 'admin_dashboard',
                    'action' => 'index'
                    ), 'default', true);
        }
        $table = new Zend_Db_Table("cms_product_types");
        $select = $table->select();
        $types = $table->fetchAll()->toArray();
        
        $this->view->types = $types;
    }
    
    public function producttypesdeleteAction() {
        $request = $this->getRequest();
            
            if(!$request->isPost() || $request->getPost('task') != 'typeinsert' ) {
                
                $redirector = $this->getHelper('Redirector');
                $redirector->setExit(true)
                            ->gotoRoute(array(
                                'controller' => 'admin_managecategories',
                                'action' => 'index'
                                ), 'default', true);
            }
            
            $flashMessenger = $this->getHelper('FlashMessenger');
            
            try {
                
            $value = $request->getPost("type");
            
//            if($id <= 0) {
//                
//                throw new Application_Model_Exception_InvalidInput("Invalid member id: " . $id );
//                
//            }
            
            $cmsTypeTable = new Application_Model_DbTable_CmsTypes();
    
                $cmsTypeTable->insertType($value);
                
                
                $flashMessenger->addMessage("Member " . $member["first_name"] . " " . $member["last_name"] . " has been enabled." , "success");
                
                $redirector = $this->getHelper('Redirector');
                $redirector->setExit(true)
                            ->gotoRoute(array(
                                'controller' => 'admin_managecategories',
                                'action' => 'index'
                                ), 'default', true);

            } catch (Application_Model_Exception_InvalidInput $ex) {

                $flashMessenger->addMessage($ex->getMessage());
                
                $redirector = $this->getHelper('Redirector');
                $redirector->setExit(true)
                            ->gotoRoute(array(
                                'controller' => 'admin_managecategories',
                                'action' => 'index'
                                ), 'default', true);
                
            }
        
        
    }
    
    public function producttypesinsertAction() {

//        $typesTable = new Application_Model_DbTable_CmsTypes();
//        $typesTable->insertType("test");
//        echo "<pre>"; 
//        var_dump($this->getRequest()->getParams());
//        die();
        
        $request = $this->getRequest();
            
            if(!$request->isPost() || $request->getPost('task') != 'typeinsert' ) {
                
                $redirector = $this->getHelper('Redirector');
                $redirector->setExit(true)
                            ->gotoRoute(array(
                                'controller' => 'admin_managecategories',
                                'action' => 'index'
                                ), 'default', true);
            }
            
            $flashMessenger = $this->getHelper('FlashMessenger');
            
            try {
                
            $value = $request->getPost("type");
            
//            if($id <= 0) {
//                
//                throw new Application_Model_Exception_InvalidInput("Invalid member id: " . $id );
//                
//            }
            
            $cmsTypeTable = new Application_Model_DbTable_CmsTypes();
    
                $cmsTypeTable->insertType($value);
                
                
                $flashMessenger->addMessage("Member " . $member["first_name"] . " " . $member["last_name"] . " has been enabled." , "success");
                
                $redirector = $this->getHelper('Redirector');
                $redirector->setExit(true)
                            ->gotoRoute(array(
                                'controller' => 'admin_managecategories',
                                'action' => 'index'
                                ), 'default', true);

            } catch (Application_Model_Exception_InvalidInput $ex) {

                $flashMessenger->addMessage($ex->getMessage());
                
                $redirector = $this->getHelper('Redirector');
                $redirector->setExit(true)
                            ->gotoRoute(array(
                                'controller' => 'admin_managecategories',
                                'action' => 'index'
                                ), 'default', true);
                
            }
        
        
        
        
        
    }
    
    
}
