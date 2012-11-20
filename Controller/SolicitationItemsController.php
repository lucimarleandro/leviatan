<?php
App::uses('AppController', 'Controller');
/**
 * SolicitationItems Controller
 *
 * @property SolicitationItem $SolicitationItem
 */
class SolicitationItemsController extends AppController {

	public $uses = array('SolicitationItem', 'Item', 'CartItem');
	public $helpers = array('Tinymce');
	
/**
 * 
 */
	public function index() {
		
		$ajax = false;
		if($this->request->is('ajax')) {
			$this->layout = 'ajax';
			$ajax = true;
			if($this->request->data) {
				$options = array();
				if(!empty($this->request->data['item_class_id'])){
					$options['conditions'][] = array('Item.item_class_id'=>$this->request->data['item_class_id']);
				}
				if(isset($this->request->data['item_name']) && !empty($this->request->data['item_name'])) {
					$options['conditions'][] = array('Item.name'=>$this->request->data['item_name']);
				}
				$this->Session->write('options', $options);
			}
		}
		if($this->request->is('ajax') && $this->Session->read('options')) {
			$options = $this->Session->read('options');
		}else {
			$this->Session->delete('options');
		}	
		
		
		$options['limit'] = 10;
		$options['order'] = array('Item.keycode'=>'asc');		
		$this->paginate = $options;
		
		$items = $this->paginate('Item');
		$groups = $this->__getItemGroups();
		$cart_items = $this->__getCartItems();
		$pending = $this->__getSolicitationItemsPending();
		$complete = 'false';

		$this->set(compact('ajax', 'groups', 'items', 'cart_items', 'pending', 'complete'));		
	}
	
/**
 * 
 */
	public function analyze($solicitation_id = null) {
		
		$ajax = false;
		if($this->request->is('ajax')) {
			$this->layout = 'ajax';
			$ajax = true;
			if($this->request->data) {
				/*$options = array();
				if(!empty($this->request->data['item_class_id'])){
					$options['conditions'][] = array('Item.item_class_id'=>$this->request->data['item_class_id']);
				}
				if(isset($this->request->data['item_name']) && !empty($this->request->data['item_name'])) {
					$options['conditions'][] = array('Item.name'=>$this->request->data['item_name']);
				}
				$this->Session->write('options', $options);*/
			}
		}
		if($this->request->is('ajax') && $this->Session->read('options')) {
			$options = $this->Session->read('options');
		}else {
			$this->Session->delete('options');
		}
		
		$options['conditions'] = array(
			'SolicitationItem.solicitation_id'=>$solicitation_id	
		);
		$options['order'] = array(
			'Item.name'	
		);
		$options['fields'] = array(
			'SolicitationItem.id', 'SolicitationItem.quantity', 
			'SolicitationItem.status_id', 'Item.name', 'Item.id'	
		);
		$options['limit'] = 10;
		
		$this->paginate = $options;
		$solicitationItems = $this->paginate();
		
		$this->set(compact('solicitationItems', 'ajax'));
	}
	
/**
 * 
 */
	public function check() {
		$this->autoRender = false;
		if($this->request->is('AJAX')) {
			
			$options['conditions'] = array(
				'SolicitationItem.solicitation_id'=>$this->request->data['solicitation_ids'],
				'SolicitationItem.status_id'=>PENDENTE	
			);
			$count = $this->SolicitationItem->find('count', $options);

			if($count == 0) {
				$return = true;
			}else {
				$return = false;
			}
			
			echo json_encode(array('return'=>$return));
		}
	}
	
/**
 * 
 */
	public function accept() {
		$this->autoRender = false;
		if($this->request->is('ajax')) {
			$name = 'status_id';
			$value = APROVADO;
			
			$this->SolicitationItem->id = $this->request->data['solicitation_item_id'];
			if($this->SolicitationItem->saveField($name, $value, false)) {
				$return = true;	
			}else {
				$return = false;
			}
			
			echo json_encode(array('return'=>$return));	
		}	
	}
	
/**
 *
 */
	private function __getItemGroups() {	
		$options['joins'] = array(
				array(
						'table'=>'item_classes',
						'alias'=>'ItemClass',
						'type'=>'INNER',
						'conditions'=>array(
								'Item.item_class_id = ItemClass.id'
						)
				),
				array(
						'table'=>'item_groups',
						'alias'=>'ItemGroup',
						'type'=>'INNER',
						'conditions'=>array(
								'ItemClass.item_group_id = ItemGroup.id'
						)
				)
		);
		$options['fields'] = array('DISTINCT ItemGroup.id', 'ItemGroup.keycode','ItemGroup.name');
	
		$this->Item->recursive = -1;
		$groups = $this->Item->find('all', $options);
		
		$values = array();
		foreach($groups as $group):
			$values[$group['ItemGroup']['id']] = $group['ItemGroup']['keycode'].' - '.$group['ItemGroup']['name'];
		endforeach;
		$groups = $values;
	
		return array(''=>'Selecione um grupo') + $groups;
	}
	
/**
 * 
 */
	private function __getCartItems() {		
		$options['conditions'] = array(
			'CartItem.user_id'=>$this->Auth->user('id')		
		);
		$options['fields'] = array(
			'CartItem.item_id'	
		);
		$cart_items = $this->CartItem->find('list', $options);

		return $cart_items;
	}
	
/**
 * 
 */	
 	private function __getSolicitationItemsPending() {
		
 		$this->SolicitationItem->recursive = -1;
 		$options['joins'] = array(
 			array(
 				'table'=>'solicitations',
 				'alias'=>'Solicitation',
 				'type'=>'INNER',
 				'conditions'=>array(
 					'Solicitation.user_id'=>$this->Auth->user('id'),
 					'Solicitation.id = SolicitationItem.solicitation_id'		
 				)						
 			) 				
 		); 		
 		$options['conditions'] = array(
 			'SolicitationItem.status_id'=>PENDENTE	
 		);
 		$options['fields'] = array(
 			'SolicitationItem.item_id'	
 		);
 		
 		$pending = $this->SolicitationItem->find('list', $options);

 		return $pending; 		
	}
}
