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
                    throw new Application_Model_Exception_InvalidInput('Invalid data was sent for new news');
                }

                //get form data
                $formData = $form->getValues();

                // set parent_id for new page

                $formData['author_id'] = $user['id'];

                unset($formData['news_main_photo']);

                //remove key sitemap_page_photo form form data because there is no column 'sitemap_page_photo' in cms_newss table
                //unset($formData['sitemap_page_photo']);
                //Insertujemo novi zapis u tabelu
                //insert news returns ID of the new news

                $newsId = $cmsNewsTable->insertNews($formData);

                if ($form->getElement('news_main_photo')->isUploaded()) {
                    //photo is uploaded

                    $fileInfos = $form->getElement('news_main_photo')->getFileInfo('news_main_photo');
                    $fileInfo = $fileInfos['news_main_photo'];


                    try {
                        //open uploaded photo in temporary directory
                        $newsPhoto = Intervention\Image\ImageManagerStatic::make($fileInfo['tmp_name']);

                        //						$newsPhoto->fit(600, 400);
                        $newsPhoto->fit(600, 400);

                        $newsPhoto->save(PUBLIC_PATH . '/uploads/news-main-photos/' . $newsId . '.jpg');
                    } catch (Exception $ex) {

                        $flashMessenger->addMessage('News photo has been saved but error occured during image processing', 'errors');

                        //redirect to same or another page
                        $redirector = $this->getHelper('Redirector');
                        $redirector->setExit(true)
                                ->gotoRoute(array(
                                    'controller' => 'admin_news',
                                    'action' => 'edit',
                                    'id' => $newsId
                                        ), 'default', true);
                    }
                    //$fileInfo = $_FILES['index_slide_photo'];
                }




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

        $request = $this->getRequest();

        $id = (int) $request->getParam("id");

        if ($id <= 0) {
            //prekida se izvrsavanje i prikazuje se page not found
            throw new Zend_Controller_Router_Exception('Invalid news id: ' . $id, 404);
        }

        $cmsNewsTable = new Application_Model_DbTable_CmsNews();

        $newsPage = $cmsNewsTable->getNewsById($id);

        if (empty($newsPage)) {
            throw new Zend_Controller_Router_Exception('No news is found with id: ' . $id, 404);
        }

        $this->view->news = $newsPage;

        $flashMessenger = $this->getHelper('FlashMessenger');

        $systemMessages = array(
            'success' => $flashMessenger->getMessages('success'),
            'errors' => $flashMessenger->getMessages('errors'),
        );

        $form = new Application_Form_Admin_NewsEdit();

        //default form data
        $form->populate($newsPage);

        if ($request->isPost() && $request->getPost('task') === 'update') {

            try {

                //check form is valid
                if (!$form->isValid($request->getPost())) {
                    throw new Application_Model_Exception_InvalidInput('Invalid data was sent for news');
                }
                //ukoliko je validna forma
                //get form data
                $formData = $form->getValues(); //filtrirani i validirani podaci

                unset($formData['news_main_photo']);


                if ($form->getElement('news_main_photo')->isUploaded()) {
                    //photo is uploaded

                    $fileInfos = $form->getElement('news_main_photo')->getFileInfo('news_main_photo');
                    $fileInfo = $fileInfos['news_main_photo'];


                    try {
                        //open uploaded photo in temporary directory
                        $newsPhoto = Intervention\Image\ImageManagerStatic::make($fileInfo['tmp_name']);

                        //						$newsPhoto->fit(600, 400);
                        $newsPhoto->fit(600, 400);

                        $newsPhoto->save(PUBLIC_PATH . '/uploads/news-main-photos/' . $newsId . '.jpg');
                    } catch (Exception $ex) {
                        
                        throw new Application_Model_Exception_InvalidInput('Error occured during image processing');

                    }
                    //$fileInfo = $_FILES['index_slide_photo'];
                }



                //radimo update postojeceg zapisa u tabeli
                $cmsNewsTable->updateNews($newsPage['id'], $formData);


                // do actual task
                //save to database etc
                //set system message
                $flashMessenger->addMessage('News has been updated', 'success');

                //redirect to same or another page po nasoj ideji bacamo na stranicu gde su svi newsi
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
