<?php

class Admin_NewsController extends Zend_Controller_Action {

    public function init() {
        
    }

    public function indexAction() {

        $flashMessenger = $this->getHelper('FlashMessenger');

        $systemMessages = array(
            'success' => $flashMessenger->getMessages('success'),
            'errors' => $flashMessenger->getMessages('errors')
        );

        $newsCmsTable = new Application_Model_DbTable_CmsNews();

//        $news = $newsCmsTable->search(array(
//            'filters' => array(
//                'status' => Application_Model_DbTable_CmsNews::STATUS_ENABLED
//            ),
//            'orders' => array(
//                'date_posted' => 'ASC'
//            )
//                )
//        );
        //TODO: move this to model!
//        $select = $newsCmsTable->select()
//                ->setIntegrityCheck(false)
//                ->from("cms_news")
//                ->join("cms_users", "cms_users.id = cms_news.author_id");

        $select = $newsCmsTable->select()
                ->setIntegrityCheck(false)
                ->from("cms_users")
                ->join("cms_news", "cms_users.id = cms_news.author_id")
                ->order(array('date_posted DESC'));

        $news = $newsCmsTable->fetchAll($select)->toArray();

        $this->view->news = $news;
        $this->view->systemMessages = $systemMessages;
    }

    public function addAction() {

        $request = $this->getRequest();

        $user = Zend_Auth::getInstance()->getIdentity();

        $flashMessenger = $this->getHelper('FlashMessenger');

        $systemMessages = array(
            'success' => $flashMessenger->getMessages('success'),
            'errors' => $flashMessenger->getMessages('errors'),
        );

        $cmsNewsTable = new Application_Model_DbTable_CmsNews();

        $form = new Application_Form_Admin_NewsAdd();

        //default form data
        $form->populate(array(
        ));

        if ($request->isPost() && $request->getPost('task') === 'save') {

            try {
                //check form is valid
                if (!$form->isValid($request->getPost())) {
                    throw new Application_Model_Exception_InvalidInput('Invalid data was sent for new sitemapPage');
                }

                //get form data
                $formData = $form->getValues();

                // set parent_id for new page

                $formData['author_id'] = $user['id'];

                //remove key sitemap_page_photo form form data because there is no column 'sitemap_page_photo' in cms_sitemapPages table
                //unset($formData['sitemap_page_photo']);
                //Insertujemo novi zapis u tabelu
                //insert sitemapPage returns ID of the new sitemapPage
                

                // do actual task
                //save to database etc
                //set system message
                $flashMessenger->addMessage('News has been saved', 'success');

                //redirect to same or another page
                $redirector = $this->getHelper('Redirector');
                $redirector->setExit(true)
                        ->gotoRoute(array(
                            'controller' => 'admin_news',
                            'action' => 'index'
                                ), 'default', true);
            } catch (Application_Model_Exception_InvalidInput $ex) {
                $systemMessages['errors'][] = $ex->getMessage();
            }
        }

        $this->view->systemMessages = $systemMessages;
        $this->view->form = $form;
    }

    public function editAction() {
        
    }

    public function deleteAction() {

        $request = $this->getRequest();

        if (!$request->isPost() || $request->getPost('task') != 'delete') {
            // request is not post
            // or task is not delete
            //redirect to index page
            //redirect to same or another page
            $redirector = $this->getHelper('Redirector');
            $redirector->setExit(true)
                    ->gotoRoute(array(
                        'controller' => 'admin_news',
                        'action' => 'index'
                            ), 'default', true);
        }

        $flashMessenger = $this->getHelper('FlashMessenger');

        try {

            // read $_POST['id']
            $id = (int) $request->getPost('id');

            if ($id <= 0) {

                throw new Application_Model_Exception_InvalidInput('Invalid news id: ' . $id);
            }

            $cmsNewsTable = new Application_Model_DbTable_CmsNews();

            $news = $cmsNewsTable->getNewsById($id);

            if (empty($news)) {
                throw new Application_Model_Exception_InvalidInput('No news is found with id: ' . $id);
            }

            $cmsNewsTable->deleteNews($id);

            $flashMessenger->addMessage('News ' . $news['title'] . ' has been deleted', 'success');

            //redirect to same or another page
            $redirector = $this->getHelper('Redirector');
            $redirector->setExit(true)
                    ->gotoRoute(array(
                        'controller' => 'admin_news',
                        'action' => 'index'
                            ), 'default', true);
        } catch (Application_Model_Exception_InvalidInput $ex) {

            $flashMessenger->addMessage($ex->getMessage(), 'errors');

            //redirect to same or another page
            $redirector = $this->getHelper('Redirector');
            $redirector->setExit(true)
                    ->gotoRoute(array(
                        'controller' => 'admin_news',
                        'action' => 'index'
                            ), 'default', true);
        }
        
        $this->view->systemMessages = $systemMessages;
        
    }

}
