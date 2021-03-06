<?php

App::uses('AppController', 'Controller');

/**
 * InputCategories Controller
 *
 * @property InputCategory $InputCategory
 */
class InputCategoriesController extends AppController {

/**
 * (non-PHPdoc)
 * @see AppController::beforeFilter()
 */
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow(array('view'));
    }

/**
 * 
 */
    public function index() {
        $this->InputCategory->recursive = -1;
        $options['limit'] = 10;
        $options['order'] = array('InputCategory.name' => 'asc');

        $this->paginate = $options;
        $categories = $this->paginate();

        $this->set(compact('categories'));
    }

/**
 *
 * @param unknown_type $id
 */
    public function view($id = null) {
        $this->InputCategory->id = $id;
        $this->InputCategory->recursive = -1;

        if (!$this->InputCategory->exists()) {
            $this->Session->setFlash(__('Registro inválido'), 'default', array('class' => 'alert alert-error'));
            $this->redirect(array('action' => 'index'));
        }

        $category = $this->InputCategory->read();

        $this->set(compact('category'));
    }

/**
 *
 */
    public function add() {
        if ($this->request->is('POST')) {
            if ($this->InputCategory->save($this->request->data)) {
                $this->Session->setFlash(__('Adicionado com sucesso'), 'default', array('class' => 'alert alert-success'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('Não foi possível adicionar'), 'default', array('class' => 'alert alert-error'));
            }
        }
    }

/**
 *
 * @param unknown_type $id
 */
    public function edit($id = null) {
        $this->InputCategory->id = $id;
        if ($this->request->is('POST') || $this->request->is('PUT')) {
            if ($this->InputCategory->save($this->request->data)) {
                $this->Session->setFlash(__('Editado com sucesso'), 'default', array('class' => 'alert alert-success'));
            } else {
                $this->Session->setFlash(__('Não foi possível editar'), 'default', array('class' => 'alert alert-error'));
            }
            $this->redirect(array('action' => 'index'));
        }
        $this->request->data = $this->InputCategory->read();
    }

/**
 *
 * @param unknown_type $id
 */
    public function delete($id = null) {
        $this->InputCategory->id = $id;
        if ($this->request->is('GET')) {
            $this->Session->setFlash(__('Requisição inválida'), 'default', array('class' => 'alert alert-error'));
            $this->redirect(array('action' => 'index'));
        }
        if (!$this->InputCategory->exists()) {
            $this->Session->setFlash(__('Registro inválido'), 'default', array('class' => 'alert alert-error'));
            $this->redirect(array('action' => 'index'));
        }

        if ($this->InputCategory->delete()) {
            $this->Session->setFlash(__('Deletado com sucesso'), 'default', array('class' => 'alert alert-success'));
        } else {
            $this->Session->setFlash(__('Não foi possível deletar'), 'default', array('class' => 'alert alert-error'));
        }

        $this->redirect(array('action' => 'index'));
    }

}
