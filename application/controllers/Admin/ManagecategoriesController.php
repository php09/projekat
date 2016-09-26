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
        
        Zend_Layout::getMvcInstance()->disableLayout();

        $request = $this->getRequest();
        
        $id = $request->getParam("types");
        
        $table = new Zend_Db_Table("cms_product_types");
        $table->delete("id = " . $id);
        
    }
    
    public function producttypesinsertAction() {
        
        Zend_Layout::getMvcInstance()->disableLayout();

        $request = $this->getRequest();
        
        $name = $request->getParam("name");
        $request instanceof Zend_Controller_Request_Http;
        
        $table = new Zend_Db_Table("cms_product_types");
        $table->insert( array("name" => $name) );
        
        
    }
    
    
}
