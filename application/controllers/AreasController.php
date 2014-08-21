<?php

class AreasController extends Zend_Controller_Action {

    public function indexAction() {
        $area = new Area();
        $this->view->areas = $area->fetchAll('enable = 1');
    }

    public function newAction() {
        if ($this->_request->isPost()) {
            $area = new Area();

            $data = $this->_request->getPost();
            try {
                $area->create($data);
                $this->_helper->flashMessenger(array('success' => 'Area gravada com sucesso!'));
                $this->redirect('/areas');
            } catch (Exception $e) {
                $this->_helper->flashMessenger(array('error' => 'Desculpe, ocorreu um erro: ' . $e->getMessage()));
            }
        }
    }

    public function editAction() {
        $area = new Area();
        $retrieved = $area->getById(intval($this->_getParam('id')));
        $this->view->area = $retrieved;

        if ($this->_request->isPost()) {
            $data = $this->_request->getPost();
            try {
                $area->update($data, "id = $retrieved->id");
                $this->_helper->flashMessenger(array('success' => 'Area gravada com sucesso!'));
                $this->redirect('/areas');
            } catch (Exception $e) {
                $this->_helper->flashMessenger(array('error' => 'Desculpe, ocorreu um erro: ' . $e->getMessage()));
            }
        }
    }

    public function deleteAction() {
        $this->_helper->layout()->disableLayout();
        $this->getHelper('viewRenderer')->setNoRender();

        $area = new Area();
        $retrieve = $area->getById(intval($this->_getParam('id')));
        try {
            $retrieve->delete();
            $this->_helper->flashMessenger(array('success' => 'Area Removida com sucesso!'));
            $this->redirect('/areas');
        } catch (Zend_Db_Exception $ex) {
            $this->_helper->flashMessenger(array('error' => 'Desculpe, ocorreu um erro: ' . $e->getMessage()));
        }
    }

}
