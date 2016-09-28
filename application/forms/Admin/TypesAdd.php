<?php

class Application_Form_Admin_TypesAdd extends Zend_Form
{
    public function init() {
        
        $type = new Zend_Form_Element_Text("type");
        $this->addElement($type);
        
    }
}
