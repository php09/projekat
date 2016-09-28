<?php

class Application_Model_DbTable_CmsTypes extends Zend_Db_Table_Abstract
{
    protected $_name = 'cms_product_types';
    
    public function insertType($value) {
        
        $this->insert(array("name" => $value));
        
    }
    
}