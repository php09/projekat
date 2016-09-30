<?php

class Application_Form_Admin_ProductAdd extends Zend_Form
{
    
    public function init() {
        
        $title = new Zend_Form_Element_Text("title");
        $title;
        $this->addElement($title);
        
        $class = new Zend_Form_Element_Select("class");
        $class;
        $this->addElement($class);
        
        $type = new Zend_Form_Element_Select("type");
        $type;
        $this->addElement($type);
        
        $vendor = new Zend_Form_Element_Text("vendor");
        $vendor;
        $this->addElement($vendor);
        
        $model = new Zend_Form_Element_Text("model");
        $model;
        $this->addElement($model);
        
        $characteristics = new Zend_Form_Element_Text("characteristics");
        $characteristics; 
       $this->addElement($characteristics);
        
                
    }
    
}
