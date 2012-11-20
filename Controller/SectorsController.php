<?php
App::uses('AppController', 'Controller');

/**
 * Sectors Controller
 *
 * @property Sector $Sector
 */
class SectorsController extends AppController {
	
	public $uses = array('Sector', 'UnitySector');
	
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
		$options['order'] = array('Sector.name'=>'asc');
		$options['fields'] = array('Sector.id', 'Sector.name');
		
		$this->paginate = $options;
		$sectors = $this->paginate();

		$this->set(compact('sectors'));		
	}
	
/**
 * 
 * @param unknown_type $id
 */
	public function view($id = null) {
		$this->Sector->id = $id;
		$this->Sector->recursive = -1;
		
		if(!$this->Sector->exists()) {
			$this->Session->setFlash(__('Registro inválido'), 'default', array('class'=>'alert alert-error'));
			$this->redirect(array('action'=>'index'));
		}
		
		$sector = $this->Sector->read();
		
		$this->set(compact('sector'));
	}
	
/**
 * 
 */
	public function add() {		
		if($this->request->is('POST')) {
			if($this->Sector->save($this->request->data)) {
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
		$this->Sector->id = $id;
		if($this->request->is('POST') || $this->request->is('PUT')) {			
			if($this->Sector->save($this->request->data)) {
				$this->Session->setFlash(__('Editado com sucesso'), 'default', array('class'=>'alert alert-success'));
			}else {
				$this->Session->setFlash(__('Não foi possível editar'), 'default', array('class'=>'alert alert-error'));
			}
			$this->redirect(array('action'=>'index'));
		}
		$this->request->data = $this->Sector->read();
	}
	
/**
 * 
 * @param unknown_type $id
 */
	public function delete($id = null) {
		$this->Sector->id = $id;	
		if($this->request->is('GET')) {
			$this->Session->setFlash(__('Requisição inválida'), 'default', array('class'=>'alert alert-error'));
			$this->redirect(array('action'=>'index'));
		}		
		if(!$this->Sector->exists()) {
			$this->Session->setFlash(__('Registro inválido'), 'default', array('class'=>'alert alert-error'));
			$this->redirect(array('action'=>'index'));
		}
		
		if($this->Sector->delete()) {
			$this->Session->setFlash(__('Deletado com sucesso'), 'default', array('class'=>'alert alert-success'));
		}else {
			$this->Session->setFlash(__('Não foi possível deletar'), 'default', array('class'=>'alert alert-error'));
		}
		
		$this->redirect(array('action'=>'index'));
	}
	
/**
 * 
 */
	public function get_sectors($left = false) {
		$this->autoRender = false;
		if($this->request->is('AJAX')) {
			$unity_id = $this->request->data['unity_id'];
			
			$type = $left ? 'LEFT' : 'INNER';
			
			$this->UnitySector->recursive = -1;
			$options['joins'] = array(
				array(
					'table'=>'unity_sectors',
					'alias'=>'UnitySector',
					'type'=>$type,
					'conditions'=>array(
						'UnitySector.sector_id = Sector.id',
						'UnitySector.unity_id = '.$unity_id		
					)		
				)	
			);
			//Se eu quero os registros que não estão relacionados
			if($left) {
				$options['conditions'] = array(
					'UnitySector.id is NULL'
				);
			}
			$options['fields'] = array(
				'Sector.id', 'Sector.name'	
			);
			
			$sectors = $this->Sector->find('list', $options);
			if(!empty($sectors)) {
				$inicio = array(''=>'Selecione um setor');
			} else {
				$inicio = array(''=>'Não existe setores ou todos já foram cadastrados');
			}
			
			$sectors = $inicio + $sectors;
			
			echo json_encode($sectors);
		}
	}	

}
