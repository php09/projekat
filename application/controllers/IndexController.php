<?php

class IndexController extends Zend_Controller_Action {

    public function init() {
        /* Initialize action controller here */
    }

    public function indexAction() {//test
        $cmsIndexSlidesDbTable = new Application_Model_DbTable_CmsIndexSlides();

        $indexSlides = $cmsIndexSlidesDbTable->search(array(
            'filters' => array(
                'status' => Application_Model_DbTable_CmsIndexSlides::STATUS_ENABLED
            ),
            'orders' => array(
                'order_number' => 'ASC'
            )
        ));

        $this->view->indexSlides = $indexSlides;

        $sitemapTable = new Application_Model_DbTable_CmsSitemapPages();

        $sitemapPage = $sitemapTable->search(
                array(
                    'filters' => array(
                        'type' => 'ContactusPage',
                        'status' => Application_Model_DbTable_CmsSitemapPages::STATUS_ENABLED
        )));

        if (!$sitemapPage) {
            throw new Zend_Controller_Router_Exception('About us page was not found.', 404);
        }

        $this->view->sitemapPage = $sitemapPage[0];



        $cmsServicesDbTable = new Application_Model_DbTable_CmsServices();
        $services = $cmsServicesDbTable->search(array(
            'filters' => array(
                'status' => Application_Model_DbTable_CmsServices::STATUS_ENABLED
            ),
            'orders' => array(
                'order_number' => 'ASC'
            ),
            'limit' => 4
        ));
        $this->view->services = $services;



        $newsTable = new Application_Model_DbTable_CmsNews();

        $news = $newsTable->search(
                array(
                    'filters' => array(
                        'status' => Application_Model_DbTable_CmsNews::STATUS_ENABLED
                    ),
                    'orders' => array(
                        'date_posted' => 'DESC'
                    ),
                    'limit' => 6
        ));

        $this->view->news = $news;
    }

}
