<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{

	protected function _initRouter() {
		//ensure that database is configured
		$this->bootstrap('db');
		
		$sitemapPageTypes = array(
			
			'StaticPage' => array(
				'title' => 'Static Page',
				'subtypes' => array(
					// 0 means unlimited number
					'StaticPage' => 0
				)
			),
			
			'PhotoGalleriesPage' => array(
				'title' => 'Photo Galleries Page',
				'subtypes' => array(
					
				)
			),
                        "NewsPage" => array(
                            'title' => 'News Page',
                            "subtypes" => array('StaticPage' => 0, 'NewsPage' => 0)
                        ),
                        "CategoryPage" => array(
                            "title" => "Category Page",
                            "subtypes" => array('StaticPage' => 0, 'CategoryPage' => 0)
                        ),
                        'SupportPage' => array(
                            'title' => 'Support page',
                            'subtypes' => array('StaticPage' => 0, 'SupportPage' => 0)
                        ),
                        'CataloguePage' => array(
                            'title' => 'Catalogue page',
                            'subtypes' => array('StaticPage' => 0, 'CategoryPage' => 0)
                        ),
                        'AboutusPage' => array(
                            'title' => 'About us page',
                            'subtypes' => array('StaticPage' => 0)
                        ),
                        'ContactUsPage' => array(
                            'title' => 'Contact us',
                            'subtypes' => array()
                        ),
                        'ServicesPage' => array(
                            'title' => 'Services',
                            'subtypes' => array()
                        ),
                        'ProductPage' => array(
                            'title' => 'Product',
                            'subtypes' => array()
                        )
                    
                        
		);
		
		$rootSitemapPageTypes = array(
			'StaticPage' => 0,
			'PhotoGalleriesPage' => 1,
                        'CategoryPage' => 1,
                        'NewsPage' => 0,
                        'SupportPage' => 1,
                        'CataloguePage' => 1,
                        'AboutusPage' => 1,
                        'ContactUsPage' => 1,
                        'ServicesPage' => 1,
                        'ProductPage' => 1
		);
		
		Zend_Registry::set('sitemapPageTypes', $sitemapPageTypes);
		Zend_Registry::set('rootSitemapPageTypes', $rootSitemapPageTypes);
		
		$router = Zend_Controller_Front::getInstance()->getRouter();
		
		$router instanceof Zend_Controller_Router_Rewrite;
		
		$sitmapPagesMap = Application_Model_DbTable_CmsSitemapPages::getSitemapPagesMap();
		
		foreach ($sitmapPagesMap as $sitemapPageId => $sitemapPageMap) {
                    
                    if ($sitemapPageMap['type'] == 'NewsPage') {
				
				$router->addRoute('news-route', new Zend_Controller_Router_Route(
					$sitemapPageMap['url'] . "/:id/:title",
					array(	
                                            'controller' => 'news',
                                            'action' => 'newsitem',
                                            'sitemap_page_id' => $sitemapPageId,
                                            'title' => ''
					)
				));
			}
                    
                        if ($sitemapPageMap['type'] == 'CategoryPage') {
				
				$router->addRoute('static-page-route-' . $sitemapPageId, new Zend_Controller_Router_Route_Static(
					$sitemapPageMap['url'],
					array(	
					'controller' => 'staticpage',
						'action' => 'index',
						'sitemap_page_id' => $sitemapPageId
					)
				));
			}
                    
                    
			if ($sitemapPageMap['type'] == 'StaticPage') {
				
				$router->addRoute('static-page-route-' . $sitemapPageId, new Zend_Controller_Router_Route_Static(
					$sitemapPageMap['url'],
					array(
						'controller' => 'staticpage',
						'action' => 'index',
						'sitemap_page_id' => $sitemapPageId
					)
				));
			}
                        
                        if ($sitemapPageMap['type'] == 'SupportPage') {
				
				$router->addRoute('static-page-route-' . $sitemapPageId, new Zend_Controller_Router_Route_Static(
					$sitemapPageMap['url'],
					array(
						'controller' => 'info',
						'action' => 'support',
						'sitemap_page_id' => $sitemapPageId
					)
				));
			}
                        
                        if ($sitemapPageMap['type'] == 'ContactUsPage') {
				
				$router->addRoute('static-page-route-' . $sitemapPageId, new Zend_Controller_Router_Route_Static(
					$sitemapPageMap['url'],
					array(
						'controller' => 'info',
						'action' => 'contactus',
						'sitemap_page_id' => $sitemapPageId
					)
				));
			}
                        
                        if ($sitemapPageMap['type'] == 'AboutusPage') {
				
				$router->addRoute('static-page-route-' . $sitemapPageId, new Zend_Controller_Router_Route_Static(
					$sitemapPageMap['url'],
					array(
						'controller' => 'info',
						'action' => 'aboutus',
						'sitemap_page_id' => $sitemapPageId
					)
				));
			}
                        
			
			if ($sitemapPageMap['type'] == 'PhotoGalleriesPage') {
				
				$router->addRoute('static-page-route-' . $sitemapPageId, new Zend_Controller_Router_Route_Static(
					$sitemapPageMap['url'],
					array(
						'controller' => 'photogalleries',
						'action' => 'index',
						'sitemap_page_id' => $sitemapPageId
					)
				));
				
				$router->addRoute('photo-gallery-route', new Zend_Controller_Router_Route(
					$sitemapPageMap['url'] . '/:id/:photo_gallery_slug',
					array(
						'controller' => 'photogalleries',
						'action' => 'gallery',
						'sitemap_page_id' => $sitemapPageId
					)
				));
			}
		}
	}
}

