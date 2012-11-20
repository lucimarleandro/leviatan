<?php

App::uses('AppController', 'Controller');

/**
 * GroupTypes Controller
 *
 * @property GroupType $GroupType
 */
class GroupTypesController extends AppController {

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

        $options['limit'] = 10;
        $options['order'] = array('GroupType.name' => 'asc');
        $options['fields'] = array('GroupType.id', 'GroupType.name');

        $this->paginate = $options;
        $groups = $this->paginate();

        $this->set(compact('groups'));
    }

/**
 *
 * @param unknown_type $id
 */
    public function view($id = null) {
        $this->GroupType->id = $id;
        $this->GroupType->recursive = -1;

        if (!$this->GroupType->exists()) {
            $this->Session->setFlash(__('Registro inválido'), 'default', array('class' => 'alert alert-error'));
            $this->redirect(array('action' => 'index'));
        }

        $type = $this->GroupType->read();

        $this->set(compact('type'));
    }

/**
 *
 */
    public function add() {
        if ($this->request->is('POST')) {
            if ($this->GroupType->save($this->request->data)) {
                $this->Session->setFlash(__('Cadastrado com sucesso'), 'default', array('class' => 'alert alert-success'));
            } else {
                $this->Session->setFlash(__('Não foi possível cadastrar'), 'default', array('class' => 'alert alert-error'));
            }
            $this->redirect(array('action' => 'index'));
        }
    }

/**
 *
 */
    public function edit($id = null) {
        $this->GroupType->id = $id;
        if ($this->request->is('POST') || $this->request->is('PUT')) {
            if ($this->GroupType->save($this->request->data)) {
                $this->Session->setFlash(__('Editado com sucesso'), 'default', array('class' => 'alert alert-success'));
            } else {
                $this->Session->setFlash(__('Não foi possível editar'), 'default', array('class' => 'alert alert-error'));
            }
            $this->redirect(array('action' => 'index'));
        }
        $this->request->data = $this->GroupType->read();
    }

/**
 *
 * @param unknown_type $id
 */
    public function delete($id = null) {
        $this->GroupType->id = $id;
        if ($this->request->is('GET')) {
            $this->Session->setFlash(__('Requisição inválida'), 'default', array('class' => 'alert alert-error'));
            $this->redirect(array('action' => 'index'));
        }
        if (!$this->GroupType->exists()) {
            $this->Session->setFlash(__('Registro inválido'), 'default', array('class' => 'alert alert-error'));
            $this->redirect(array('action' => 'index'));
        }

        if ($this->GroupType->delete()) {
            $this->Session->setFlash(__('Deletado com sucesso'), 'default', array('class' => 'alert alert-success'));
        } else {
            $this->Session->setFlash(__('Não foi possível deletar'), 'default', array('class' => 'alert alert-error'));
        }

        $this->redirect(array('action' => 'index'));
    }

}
