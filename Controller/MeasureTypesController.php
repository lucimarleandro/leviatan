<?php

App::uses('AppController', 'Controller');

/**
 * MeasureTypes Controller
 *
 * @property MeasureType $MeasureType
 */
class MeasureTypesController extends AppController {

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

        $this->MeasureType->recursive = -1;
        $options['limit'] = 10;
        $options['order'] = array('MeasureType.name' => 'asc');

        $this->paginate = $options;
        $types = $this->paginate();

        $this->set(compact('types'));
    }

/**
 * 
 * @param unknown_type $id
 */
    public function view($id = null) {
        $this->MeasureType->id = $id;
        $this->MeasureType->recursive = -1;

        if (!$this->MeasureType->exists()) {
            $this->Session->setFlash(__('Registro inválido'), 'default', array('class' => 'alert alert-error'));
            $this->redirect(array('action' => 'index'));
        }

        $type = $this->MeasureType->read();

        $this->set(compact('type'));
    }

/**
 * 
 */
    public function add() {
        if ($this->request->is('POST')) {
            if ($this->MeasureType->save($this->request->data)) {
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
        $this->MeasureType->id = $id;
        if ($this->request->is('POST') || $this->request->is('PUT')) {
            if ($this->MeasureType->save($this->request->data)) {
                $this->Session->setFlash(__('Editado com sucesso'), 'default', array('class' => 'alert alert-success'));
            } else {
                $this->Session->setFlash(__('Não foi possível editar'), 'default', array('class' => 'alert alert-error'));
            }
            $this->redirect(array('action' => 'index'));
        }
        $this->request->data = $this->MeasureType->read();
    }

/**
 * 
 * @param unknown_type $id
 */
    public function delete($id = null) {
        $this->MeasureType->id = $id;
        if ($this->request->is('GET')) {
            $this->Session->setFlash(__('Requisição inválida'), 'default', array('class' => 'alert alert-error'));
            $this->redirect(array('action' => 'index'));
        }
        if (!$this->MeasureType->exists()) {
            $this->Session->setFlash(__('Registro inválido'), 'default', array('class' => 'alert alert-error'));
            $this->redirect(array('action' => 'index'));
        }

        if ($this->MeasureType->delete()) {
            $this->Session->setFlash(__('Deletado com sucesso'), 'default', array('class' => 'alert alert-success'));
        } else {
            $this->Session->setFlash(__('Não foi possível deletar'), 'default', array('class' => 'alert alert-error'));
        }

        $this->redirect(array('action' => 'index'));
    }

}
