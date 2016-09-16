<?php

class NewsController extends Zend_Controller_Action {
    
    public function init() {
        
    }
    
    public function indexAction() {
        
//        $sitemapTable = new Application_Model_DbTable_CmsSitemapPages();
        
        $newsTable = new Application_Model_DbTable_CmsNews();
        
        $news = $newsTable->search(
                array(
                   'filters' => array(
                       'status' => Application_Model_DbTable_CmsNews::STATUS_ENABLED
                   ),
                    'orders' => array(
                        'date_posted' => 'DESC'
                    )
                ));
        
        if(empty($news)) {
            throw new Zend_Controller_Router_Exception('No news were found.' , 404);
        }
        
        $this->view->news = $news;
        
        
    }
    
    public function newsitemAction() {
        
        $request = $this->getRequest();
        
        $id = (int) $request->getParam('id');
        
        if($id <= 0) {
            throw new Zend_Controller_Router_Exception('Invalid news id: ' . $id , 404);
        }
        
        $newsTable = new Application_Model_DbTable_CmsNews();
        
        $news = $newsTable->search(
                array(
                   'filters' => array(
                       'id' => $id,
                       'status' => Application_Model_DbTable_CmsNews::STATUS_ENABLED
                   ) 
                ));
        
        if(empty($news)) {
            throw new Zend_Controller_Router_Exception('No news was found with id: ' . $id , 404);
        }
        
        $newsTitle = $request->getParam('title');
                
                if(empty($newsTitle)) {
                    $redirector = $this->getHelper('Redirector');
                    $redirector->setExit(true)
                            ->gotoRoute(array(
                                'id' => $news['id'],
                                'title' => $newsTitle
                                    ), 'news-route', true);
                }
        
        $this->view->news = $news[0];
        
        
    }
    
}