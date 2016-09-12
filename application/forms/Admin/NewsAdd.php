<?php

class Application_Form_Admin_NewsAdd extends Zend_Form{
    
    public function init() {
        
        $title = new Zend_Form_Element_Text('title');
		$title->addFilter('StringTrim')
			->addValidator('StringLength', false, array('min' => 2, 'max' => 500))
			->setRequired(true);
		$this->addElement($title);
        
        $body = new Zend_Form_Element_Textarea('body');
		$body->setRequired(false);
		$this->addElement($body);
                
        $tags = new Zend_Form_Element_Text('tags');
		$tags->addFilter('StringTrim')
			->addValidator('StringLength', false, array('min' => 2, 'max' => 255))
			->setRequired(true);
		$this->addElement($tags);
                
                
        $category = new Zend_Form_Element_Select('category');
        $category->addMultiOptions( array("test1" => 'Test') );   //TODO: fill with existing categories
        $this->addElement($category);
        
    }
    
}
