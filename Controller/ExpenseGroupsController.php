<?php
App::uses('AppController', 'Controller');
/**
 * ExpenseGroups Controller
 *
 * @property ExpenseGroup $ExpenseGroup
 */
class ExpenseGroupsController extends AppController {
	
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
	
		$this->ExpenseGroup->recursive = -1;
		$options['limit'] = 10;
		$options['order'] = array('ExpenseGroup.name'=>'asc');
	
		$this->paginate = $options;
		$groups = $this->paginate();
	
		$this->set(compact('groups'));
	}
	
/**
 *
 * @param unknown_type $id
 */
	public function view($id = null) {
		$this->ExpenseGroup->id = $id;
		$this->ExpenseGroup->recursive = -1;
	
		if(!$this->ExpenseGroup->exists()) {
			$this->Session->setFlash(__('Registro inválido'), 'default', array('class'=>'alert alert-error'));
			$this->redirect(array('action'=>'index'));
		}
	
		$group = $this->ExpenseGroup->read();
	
		$this->set(compact('group'));
	}
	
/**
 *
 */
	public function add() {
		if($this->request->is('POST')) {
			if($this->ExpenseGroup->save($this->request->data)) {
				$this->Session->setFlash(__('Adicionado com sucesso'), 'default', array('class'=>'alert alert-success'));
				$this->redirect(array('action'=>'index'));
			}else {
				$this->Session->setFlash(__('Não foi possível adicionar'), 'default', array('class'=>'alert alert-error'));
			}
		}
	}
	
/**
 *
 * @param unknown_type $id
 */
	public function edit($id = null) {
		$this->ExpenseGroup->id = $id;
		if($this->request->is('POST') || $this->request->is('PUT')) {
			if($this->ExpenseGroup->save($this->request->data)) {
				$this->Session->setFlash(__('Editado com sucesso'), 'default', array('class'=>'alert alert-success'));
			}else {
				$this->Session->setFlash(__('Não foi possível editar'), 'default', array('class'=>'alert alert-error'));
			}
			$this->redirect(array('action'=>'index'));
		}
		$this->request->data = $this->ExpenseGroup->read();
	}
	
/**
 *
 * @param unknown_type $id
 */
	public function delete($id = null) {
		$this->ExpenseGroup->id = $id;
		if($this->request->is('GET')) {
			$this->Session->setFlash(__('Requisição inválida'), 'default', array('class'=>'alert alert-error'));
			$this->redirect(array('action'=>'index'));
		}
		if(!$this->ExpenseGroup->exists()) {
			$this->Session->setFlash(__('Registro inválido'), 'default', array('class'=>'alert alert-error'));
			$this->redirect(array('action'=>'index'));
		}
	
		if($this->ExpenseGroup->delete()) {
			$this->Session->setFlash(__('Deletado com sucesso'), 'default', array('class'=>'alert alert-success'));
		}else {
			$this->Session->setFlash(__('Não foi possível deletar'), 'default', array('class'=>'alert alert-error'));
		}
	
		$this->redirect(array('action'=>'index'));
	}

}
