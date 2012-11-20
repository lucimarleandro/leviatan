<?php
App::uses('AppController', 'Controller');
/**
 * ItemGroups Controller
 *
 * @property ItemGroup $ItemGroup
 */
class ItemGroupsController extends AppController {
	
	public $uses = array('ItemGroup', 'GroupType');
	
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
		
		$this->ItemGroup->recursive = 0;
		
		$options['limit'] = 10;
		$options['order'] = array('ItemGroup.name'=>'asc');
		$options['fields'] = array(
			'ItemGroup.id', 'ItemGroup.keycode', 'ItemGroup.name',
			'GroupType.id', 'GroupType.name'	
		);
		
		$this->paginate = $options;
		$groups = $this->paginate();

		$this->set(compact('groups'));
	}
	
/**
 * 
 */
	public function view($id = null) {
		$this->ItemGroup->id = $id;
		$this->ItemGroup->recursive = 0;
		
		if(!$this->ItemGroup->exists()) {
			$this->Session->setFlash(__('Registro inválido'), 'default', array('class'=>'alert alert-error'));
			$this->redirect(array('action'=>'index'));
		}
		
		$group = $this->ItemGroup->read();
		$this->set(compact('group'));
	}
	
/**
 * 
 */
	public function add() {		
		if($this->request->is('POST')) {			
			if($this->ItemGroup->save($this->request->data)) {
				$this->Session->setFlash(__('Cadastrado com sucesso'), 'default', array('class'=>'alert alert-success'));
				$this->redirect(array('action'=>'index'));
			}else {
				$this->Session->setFlash(__('Não foi possível cadastrar'), 'default', array('class'=>'alert alert-error'));
			} 			
		}
		
		$types = array(''=>'Selecione um item') + $this->GroupType->find('list');
		$this->set(compact('types'));
	}
	
/**
 *
 */
	public function edit($id = null) {
		$this->ItemGroup->id = $id;
		if($this->request->is('POST') || $this->request->is('PUT')) {
			if($this->ItemGroup->save($this->request->data)) {
				$this->Session->setFlash(__('Editado com sucesso'), 'default', array('class'=>'alert alert-success'));
				$this->redirect(array('action'=>'index'));
			}else {
				$this->Session->setFlash(__('Não foi possível editar'), 'default', array('class'=>'alert alert-error'));
			}			
		}
		$this->request->data = $this->ItemGroup->read();
		$types = array(''=>'Selecione um item') + $this->GroupType->find('list');
		$this->set(compact('types'));
	}
	
	
/**
 *
 * @param unknown_type $id
 */
	public function delete($id = null) {
		$this->ItemGroup->id = $id;
		if($this->request->is('GET')) {
			$this->Session->setFlash(__('Requisição inválida'), 'default', array('class'=>'alert alert-error'));
			$this->redirect(array('action'=>'index'));
		}
		if(!$this->ItemGroup->exists()) {
			$this->Session->setFlash(__('Registro inválido'), 'default', array('class'=>'alert alert-error'));
			$this->redirect(array('action'=>'index'));
		}
	
		if($this->ItemGroup->delete()) {
			$this->Session->setFlash(__('Deletado com sucesso'), 'default', array('class'=>'alert alert-success'));
		}else {
			$this->Session->setFlash(__('Não foi possível deletar'), 'default', array('class'=>'alert alert-error'));
		}
	
		$this->redirect(array('action'=>'index'));
	}

}
