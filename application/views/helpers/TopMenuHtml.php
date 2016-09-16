<?php
class Zend_View_Helper_TopMenuHtml extends Zend_View_Helper_Abstract
{
    
	public function topMenuHtml() {
	
            $cmsSitemapDbTable = new Application_Model_DbTable_CmsSitemapPages();
            
            $topMenuSitemapPages = $cmsSitemapDbTable->search( 
                    array(
                        'filters' => array('parent_id' => 0, 'status' => Application_Model_DbTable_CmsSitemapPages::STATUS_ENABLED), 
                        'orders' => array('order_number' => 'ASC') 
                        ) 
                    );
            
            //resetovanje placeholder-a
            $this->view->placeholder('topMenuHtml')->exchangeArray(array());

            $this->view->placeholder('topMenuHtml')->captureStart(); ?>

                <ul class="nav navbar-nav" id="main-menu">
                    
<!--                    <li>
                        <a href="/"><?php echo $this->view->escape('Home') ;?></a>
                    </li>-->
                    
                    <?php foreach( $topMenuSitemapPages as $sitemapPage) { ?>
                    
                    <?php
                    $children = $cmsSitemapDbTable->search( 
                    array(
                        'filters' => array('parent_id' => $sitemapPage['id'], 'status' => Application_Model_DbTable_CmsSitemapPages::STATUS_ENABLED), 
                        'orders' => array('order_number' => 'ASC') 
                        ) 
                    );
                    ?>
                    
                    <?php if( !empty($children) ) { ?>
                        <li>
                            <a 
                                href="<?php echo $this->view->sitemapPageUrl($sitemapPage['id']);?>" 
                            >
                                <?php echo $this->view->escape($sitemapPage['short_title']) ;?>
                            </a>
                        </li>           
                    <li class="dropdown">
                        <a 
                            href="" 
                            class="dropdown-toggle" data-toggle="dropdown"
                            >
                                 <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu">
                            <?php foreach($children AS $child) { ?>
                                <li><a href="<?php echo $this->view->sitemapPageUrl($child['id']);?>"><?php echo $this->view->escape($child['short_title']);?></a></li>
                            <?php } ?>
                        </ul>
                    </li>
                    
                    <?php } else { ?>
                    
                    <li>
                        <a href="<?php echo $this->view->sitemapPageUrl($sitemapPage['id']);?>"><?php echo $this->view->escape($sitemapPage['short_title']) ;?></a>
                    </li>
                    <?php } ?>
                    <?php } ?>
                    
<!--                    <li>
                        <a href="<?php echo $this->view->url(array('controller' =>'session', 'action' => 'login'), 'default', true);?>"><i class='fa fa-user'></i> Login</a>
                    </li>-->
                    
                </ul>

            <?php
            $this->view->placeholder('topMenuHtml')->captureEnd();

            return $this->view->placeholder('topMenuHtml')->toString();
	}
}