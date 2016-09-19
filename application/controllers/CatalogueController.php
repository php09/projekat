<?php

class CatalogueController extends Zend_Controller_Action {
    
    public function indexAction() {
    
           $this->view->dontShowPrice = true;
           
           $productsTable = new Application_Model_DbTable_CmsProducts();
           
           $products = $productsTable->search();
           
           if(empty($products)) {
//            throw new Zend_Controller_Router_Exception('No news were found.' , 404);
            }
            
            $this->view->products = $products;
            

           
    }
    
    
    public function productAction() {
        $this->view->dontShowPrice = false;
    }
    
    
    
}