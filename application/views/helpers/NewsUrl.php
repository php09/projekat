<?php

class Zend_View_Helper_NewsUrl extends Zend_View_Helper_Abstract
{
	public function newsUrl($news) {
            
            $news['title'] = preg_replace('/\s+/', '-', $news['title']);
                   
            return $this->view->url(array(
                'id' => $news['id'],
                'title' => $news['title']
            ), 'news-route', true);
	}
}