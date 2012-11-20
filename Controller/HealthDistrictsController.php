<?php

App::uses('AppController', 'Controller');

/**
 * HealthDistricts Controller
 *
 * @property HealthDistrict $HealthDistrict
 */
class HealthDistrictsController extends AppController {

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
        $options['order'] = array('HealthDistrict.name' => 'asc');
        $options['fields'] = array('HealthDistrict.id', 'HealthDistrict.name');

        $this->paginate = $options;
        $districts = $this->paginate();

        $this->set(compact('districts'));
    }

/**
 *
 * @param unknown_type $id
 */
    public function view($id = null) {
        $this->HealthDistrict->id = $id;
        $this->HealthDistrict->recursive = -1;

        if (!$this->HealthDistrict->exists()) {
            $this->Session->setFlash(__('Registro inválido'), 'default', array('class' => 'alert alert-error'));
            $this->redirect(array('action' => 'index'));
        }

        $district = $this->HealthDistrict->read();

        $this->set(compact('district'));
    }

/**
 * 
 */
    public function add() {
        if ($this->request->is('POST')) {
            if ($this->HealthDistrict->save($this->request->data)) {
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
        $this->HealthDistrict->id = $id;
        if ($this->request->is('POST') || $this->request->is('PUT')) {
            if ($this->HealthDistrict->save($this->request->data)) {
                $this->Session->setFlash(__('Editado com sucesso'), 'default', array('class' => 'alert alert-success'));
            } else {
                $this->Session->setFlash(__('Não foi possível editar'), 'default', array('class' => 'alert alert-error'));
            }
            $this->redirect(array('action' => 'index'));
        }
        $this->request->data = $this->HealthDistrict->read();
    }

/**
 *
 * @param unknown_type $id
 */
    public function delete($id = null) {
        $this->HealthDistrict->id = $id;
        if ($this->request->is('GET')) {
            $this->Session->setFlash(__('Requisição inválida'), 'default', array('class' => 'alert alert-error'));
            $this->redirect(array('action' => 'index'));
        }
        if (!$this->HealthDistrict->exists()) {
            $this->Session->setFlash(__('Registro inválido'), 'default', array('class' => 'alert alert-error'));
            $this->redirect(array('action' => 'index'));
        }

        if ($this->HealthDistrict->delete()) {
            $this->Session->setFlash(__('Deletado com sucesso'), 'default', array('class' => 'alert alert-success'));
        } else {
            $this->Session->setFlash(__('Não foi possível deletar'), 'default', array('class' => 'alert alert-error'));
        }

        $this->redirect(array('action' => 'index'));
    }

}
