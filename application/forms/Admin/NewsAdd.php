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
        
        $newsPhoto = new Zend_Form_Element_File('news_main_photo');
		$newsPhoto->addValidator('Count', true, 1)
			->addValidator('MimeType', true, array('image/jpeg', 'image/gif', 'image/png'))
			->addValidator('ImageSize', false, array(
				'minwidth' => 600,
				'minheight' => 400,
				'maxwidth' => 2000,
				'maxheight' => 2000
			))
			->addValidator('Size', false, array(
				'max' => '10MB'
			))
			// disable move file to destination when calling method getValues()
			->setValueDisabled(true)
			->setRequired(false);
		
		$this->addElement($newsPhoto);
        
    }
    
}
