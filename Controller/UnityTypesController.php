<?php
App::uses('AppController', 'Controller');
/**
 * UnityTypes Controller
 *
 * @property UnityType $UnityType
 */
class UnityTypesController extends AppController {
	
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
		$options['order'] = array('UnityType.name'=>'asc');
		$options['fields'] = array('UnityType.id', 'UnityType.name');
	
		$this->paginate = $options;
		$types = $this->paginate();
	
		$this->set(compact('types'));
	}
	
/**
 *
 * @param unknown_type $id
 */
	public function view($id = null) {
		$this->UnityType->id = $id;
		$this->UnityType->recursive = -1;
	
		if(!$this->UnityType->exists()) {
			$this->Session->setFlash(__('Registro inválido'), 'default', array('class'=>'alert alert-error'));
			$this->redirect(array('action'=>'index'));
		}
	
		$type = $this->UnityType->read();
	
		$this->set(compact('type'));
	}
	
/**
 *
 */
	public function add() {
		if($this->request->is('POST')) {
			if($this->UnityType->save($this->request->data)) {
				$this->Session->setFlash(__('Cadastrado com sucesso'), 'default', array('class'=>'alert alert-success'));
			}else {
				$this->Session->setFlash(__('Não foi possível cadastrar'), 'default', array('class'=>'alert alert-error'));
			}
			$this->redirect(array('action'=>'index'));
		}
	}
	
/**
 *
 */
	public function edit($id = null) {
		$this->UnityType->id = $id;
		if($this->request->is('POST') || $this->request->is('PUT')) {
			if($this->UnityType->save($this->request->data)) {
				$this->Session->setFlash(__('Editado com sucesso'), 'default', array('class'=>'alert alert-success'));
			}else {
				$this->Session->setFlash(__('Não foi possível editar'), 'default', array('class'=>'alert alert-error'));
			}
			$this->redirect(array('action'=>'index'));
		}
		$this->request->data = $this->UnityType->read();
	}
	
/**
 *
 * @param unknown_type $id
 */
	public function delete($id = null) {
		$this->UnityType->id = $id;
		if($this->request->is('GET')) {
			$this->Session->setFlash(__('Requisição inválida'), 'default', array('class'=>'alert alert-error'));
			$this->redirect(array('action'=>'index'));
		}
		if(!$this->UnityType->exists()) {
			$this->Session->setFlash(__('Registro inválido'), 'default', array('class'=>'alert alert-error'));
			$this->redirect(array('action'=>'index'));
		}
	
		if($this->UnityType->delete()) {
			$this->Session->setFlash(__('Deletado com sucesso'), 'default', array('class'=>'alert alert-success'));
		}else {
			$this->Session->setFlash(__('Não foi possível deletar'), 'default', array('class'=>'alert alert-error'));
		}
	
		$this->redirect(array('action'=>'index'));
	}
}
