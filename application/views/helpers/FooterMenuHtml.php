<?php

class Zend_View_Helper_FooterMenuHtml extends Zend_View_Helper_Abstract
{
    
	public function footerMenuHtml() {
	
            $cmsSitemapDbTable = new Application_Model_DbTable_CmsSitemapPages();
            
            $topMenuSitemapPages = $cmsSitemapDbTable->search( 
                    array(
                        'filters' => array('parent_id' => 0, 'status' => Application_Model_DbTable_CmsSitemapPages::STATUS_ENABLED), 
                        'orders' => array('order_number' => 'ASC') 
                        ) 
                    );
            
            //resetovanje placeholder-a
            $this->view->placeholder('footerMenuHtml')->exchangeArray(array());

            $this->view->placeholder('footerMenuHtml')->captureStart(); ?>

                <ul class="nav navbar-nav" id="main-menu">
                    
                    <li>
                        <a href="/"><?php echo $this->view->escape('Home') ;?></a>
                    </li>
                    
                    <?php foreach( $topMenuSitemapPages as $sitemapPage) { ?>
                    
                    <li>
                        <a href="<?php echo $this->view->sitemapPageUrl($sitemapPage['id']);?>"><?php echo $this->view->escape($sitemapPage['short_title']) ;?></a>
                    </li>
                    
                    <?php } ?>

                    
<!--                    <li>
                        <a href="<?php //echo $this->view->url(array('controller' =>'session', 'action' => 'login'), 'default', true);?>"><i class='fa fa-user'></i> Login</a>
                    </li>-->
                    
                </ul>

            <?php
            $this->view->placeholder('footerMenuHtml')->captureEnd();

            return $this->view->placeholder('footerMenuHtml')->toString();
	}
}