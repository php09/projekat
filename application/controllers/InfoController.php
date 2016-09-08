<?php

class InfoController extends Zend_Controller_Action{
    
    public function init() {
        
    }
    
    public function aboutusAction() {
        
        $id = (int) $this->getRequest()->getParam("sitemap_page_id");
        
        if($id <= 0) {
            throw new Zend_Controller_Router_Exception('Invalid parent id ' . $id . ' for sitemap pages.', 404);
        }
        
        $sitemapTable = new Application_Model_DbTable_CmsSitemapPages();
        
        $sitemapPage = $sitemapTable->search(
                array(
                    'filters' => array(
                        'type' => 'AboutusPage',
                        'status' => Application_Model_DbTable_CmsSitemapPages::STATUS_ENABLED,
                        'id' => $id
                )));
        
        if(!$sitemapPage) {
            throw new Zend_Controller_Router_Exception('About us page was not found.', 404);
        }
        
        $this->view->sitemapPage = $sitemapPage[0];
        
    }
    
    public function contactusAction() {
        
        $id = (int) $this->getRequest()->getParam("sitemap_page_id");
        
        if($id <= 0) {
            throw new Zend_Controller_Router_Exception('Invalid parent id ' . $id . ' for sitemap pages.', 404);
        }
        
        $sitemapTable = new Application_Model_DbTable_CmsSitemapPages();
        
        $sitemapPage = $sitemapTable->search(
                array(
                    'filters' => array(
                        'type' => 'ContactusPage',
                        'status' => Application_Model_DbTable_CmsSitemapPages::STATUS_ENABLED,
                        'id' => $id
                )));
        
        if(!$sitemapPage) {
            throw new Zend_Controller_Router_Exception('About us page was not found.', 404);
        }
        
        $this->view->sitemapPage = $sitemapPage[0];
        
        $sitemapPageBreadcrumbs = $sitemapTable->getSitemapPageBreadcrumbs($id);
        $this->view->breadcrumb = $sitemapPageBreadcrumbs;
        
    }
    
    public function supportAction() {
        
        $id = (int) $this->getRequest()->getParam("sitemap_page_id");
        
        if($id <= 0) {
            throw new Zend_Controller_Router_Exception('Invalid parent id ' . $id . ' for sitemap pages.', 404);
        }
        
        $sitemapTable = new Application_Model_DbTable_CmsSitemapPages();
        
        $sitemapPage = $sitemapTable->search(
                array(
                    'filters' => array(
                        'type' => 'SupportPage',
                        'status' => Application_Model_DbTable_CmsSitemapPages::STATUS_ENABLED,
                        'id' => $id
                )));
        
        if(!$sitemapPage) {
            throw new Zend_Controller_Router_Exception('Support page was not found.', 404);
        }
        
        $this->view->sitemapPage = $sitemapPage[0];
        
        
        $sitemapPageChildLinks = $sitemapTable->search(
                array(
                    "filters" => array("parent_id" => $id,
                    "status" => Application_Model_DbTable_CmsSitemapPages::STATUS_ENABLED)
                ));
        
        $this->view->sitemapPageChildLinks = $sitemapPageChildLinks;
        
        $sitemapPageBreadcrumbs = $sitemapTable->getSitemapPageBreadcrumbs($id);
        $this->view->breadcrumb = $sitemapPageBreadcrumbs;
        
        
    }
    
    
    
}