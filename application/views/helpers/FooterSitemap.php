<?php

class Zend_View_Helper_FooterSitemap extends Zend_View_Helper_Abstract {

    public function footerSitemap() {

        $cmsSitemapDbTable = new Application_Model_DbTable_CmsSitemapPages();

        $menuSitemapPages = $cmsSitemapDbTable->search(
                array(
                    'filters' => array(
                        'parent_id' => 0,
                        'status' => Application_Model_DbTable_CmsSitemapPages::STATUS_ENABLED
                    ),
                    'orders' => array('order_number' => 'ASC')
                )
        );

        //resetovanje placeholder-a
        $this->view->placeholder('topMenuHtml')->exchangeArray(array());

        $this->view->placeholder('topMenuHtml')->captureStart();
        ?>
        <section class="information">
            <div class="container">
                <div class="row">


                    <?php foreach ($menuSitemapPages AS $menuPage) { ?>

                        <?php
                        $menuChildSitemapPages = $cmsSitemapDbTable->search(
                                array(
                                    'filters' => array(
                                        'parent_id' => $menuPage['id'],
                                        'status' => Application_Model_DbTable_CmsSitemapPages::STATUS_ENABLED
                                    ),
                                    'orders' => array('order_number' => 'ASC')
                                )
                        );
                        ?>

                        <div class="col-sm-8 col-md-3">
                            <h3><?php echo $this->view->escape($menuPage['short_title']); ?></h3>

                            <?php if (empty($menuChildSitemapPages)) { ?>
                                <p>
                                    <a href="<?php echo $this->view->sitemapPageUrl($menuPage['id']); ?>">
                                        <?php echo $menuPage['short_title']; ?>
                                    </a>
                                </p>
                            <?php } else { ?>

                                <?php foreach ($menuChildSitemapPages AS $child) { ?> 
                                    <p>
                                        <a href="<?php echo $this->view->sitemapPageUrl($child['id']); ?>">
                                            <?php echo $child['short_title']; ?>
                                        </a>
                                    </p>
                                <?php } ?>
                            <?php } ?>
                        </div>

                    <?php } ?>


                </div>
            </div>

        </section>

        <?php
        $this->view->placeholder('topMenuHtml')->captureEnd();

        return $this->view->placeholder('topMenuHtml')->toString();
    }

}
