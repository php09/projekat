<?php

class Admin_ManagecategoriesController extends Zend_Controller_Action
{
    
    public function indexAction()
    {
        
        $table = new Zend_Db_Table("cms_product_types");
        $select = $table->select();
        $types = $table->fetchAll()->toArray();
        
        $this->view->types = $types;
        
        //placeholder
        $characteristicId = 1;
        
        $table = new Zend_Db_Table("cms_product_types_product_characteristics");
        $select = $table->select();
        $select->where("product_characteristic_id = ? ", $characteristicId);
        $chars = $table->fetchAll()->toArray();
        
        $this->view->chars = $chars;
        
        
        
    }
    
}
