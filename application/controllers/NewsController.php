<?php

class NewsController extends Zend_Controller_Action {
    
    public function init() {
        
    }
    
    public function indexAction() {
        
        $sitemapTable = new Application_Model_DbTable_CmsSitemapPages();
        
        $sitemapPage = $sitemapTable->search(
                array(
                    'filters' => array(
                        'type' => 'NewsPage',
                        'status' => Application_Model_DbTable_CmsSitemapPages::STATUS_ENABLED
                )));
        
        if(!$sitemapPage) {
            throw new Zend_Controller_Router_Exception('Pages were not found.', 404);
        }
        
        $this->view->news = $sitemapPage[0];
        
        
    }
    
    public function newsitemAction() {
        
    }
    
}