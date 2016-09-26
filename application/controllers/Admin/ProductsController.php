<?php

class Admin_ProductsController extends Zend_Controller_Action {
    
    public function indexAction() {
        
        $productsCmsTable = new Application_Model_DbTable_CmsProducts();
        
        $products = $productsCmsTable->search();
        
        $this->view->products = $products;
        
        
    }
    
    public function addAction() {
        
    }
    
    public function deleteAction() {
        
    }

    public function editAction() {
        
    }
       
}