<?php

class Zend_View_Helper_NewsImgUrl extends Zend_View_Helper_Abstract
{
	public function newsImgUrl($news) {
		
		$newsImgFileName = $news['id'] . '.jpg';
		
		$newsImgFilePath = PUBLIC_PATH . '/uploads/news-main-photos/' . $newsImgFileName;                    ;
		
		//Helper ima property view koji je Zend_View
		// i preko kojeg pozivamo ostale view helpere
		//na primer $this->view->baseUrl()
		
		
		if (is_file($newsImgFilePath)) {
			
			return $this->view->baseUrl('/uploads/news-main-photos/' . $newsImgFileName);
			
		} else {
			return '';
		}
	}
}