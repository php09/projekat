<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
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

                if(!$sitemapPage) {
                    throw new Zend_Controller_Router_Exception('About us page was not found.', 404);
                }
                
                $this->view->sitemapPage = $sitemapPage[0];

    }
}

