<?php
App::uses('AppController', 'Controller');
/**
 * CartItems Controller
 *
 * @property CartItem $CartItem
 */
class CartItemsController extends AppController {
	
	public $uses = array('CartItem', 'Solicitation', 'SolicitationItem');
	
/**
 * 
 */	
	public function index() {
		$ajax = false;		
		if($this->request->is('AJAX')) {
			$ajax = true;
			$this->layout = 'ajax';
		}
		
		$options['limit'] = 10;
		$options['conditions'] = array(
			'CartItem.user_id'=>$this->Auth->user('id')		
		);
		$this->paginate = $options;
		
		$items = $this->paginate();		
		if(empty($items) && $this->request->params['paging']['CartItem']['pageCount'] > 0) {
			$this->redirect(array('controller'=>'cart_items', 'action'=>'index', 'page'=>$this->request['params']['paging']['CartItem']['page']));
		}else if(empty($items)) {
			$this->Session->setFlash(__('Não há solicitações pendentes'), 'default', array('class'=>'alert alert-error'));
			if(!$this->request->is('ajax')) {
				$this->redirect(array('controller'=>'solicitation_items', 'action'=>'index'));
			}else {
				echo json_encode(array('redirect'=>true));
				$this->autoRender = false;
			}
			return false;
		}		
		$this->set(compact('ajax', 'items'));	
	}
	
/**
 * 
 */
	public function edit() {
		$this->autoRender = false;
		if($this->request->is('ajax')) {
			$this->CartItem->id = $this->request->data['cart_item_id'];
			
			if($this->CartItem->saveField('quantity', $this->request->data['quantity'])) {
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
	public function add() {
		$this->autoRender = false;
		if($this->request->is('AJAX')) {
			$user_id = $this->Auth->user('id');
			$item_id = 

			$data['CartItem']['user_id'] = $this->Auth->user('id');
			$data['CartItem']['item_id'] = $this->request->data['item_id'];
			$data['CartItem']['quantity'] = 1;
			
			if($this->CartItem->save($data)) {
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
	public function delete() {
		$this->autoRender = false;
		if($this->request->is('AJAX')) {
			$this->CartItem->id = $this->request->data['cart_item_id'];
			
			if($this->CartItem->delete()) {
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
	public function checkout() {
		$this->autoRender = false;
		if($this->request->is('AJAX')) {			
			$this->Solicitation->create();
			$data['Solicitation']['keycode'] = $this->__getKeyCode();
			$data['Solicitation']['memo_number'] = $this->request->data['memo_number'];
			$data['Solicitation']['description'] = $this->request->data['description'];
			$data['Solicitation']['user_id'] = $this->Auth->user('id');
			$data['Solicitation']['status_id'] = PENDENTE;
			
			$this->CartItem->recursive = -1;
			$options['conditions'] = array(
				'CartItem.user_id' => $this->Auth->user('id')	
			);
			$options['fields'] = array('CartItem.item_id', 'CartItem.quantity');
			$cartItems = $this->CartItem->find('all', $options);
			
			foreach($cartItems as $key=>$item):
				$this->SolicitationItem->create();
				$data['SolicitationItem'][$key]['item_id'] = $item['CartItem']['item_id'];
				$data['SolicitationItem'][$key]['quantity'] = $item['CartItem']['quantity'];
				$data['SolicitationItem'][$key]['status_id'] = PENDENTE;
			endforeach;
			
			$this->Solicitation->begin();			
			if($this->Solicitation->saveAll($data)) {				
				$this->CartItem->begin();
				if($this->CartItem->deleteAll(array('CartItem.user_id'=>$this->Auth->user('id')), false)) {
					$this->Solicitation->commit();
					$this->CartItem->commit();		
					$return = true;			
				}else {
					$this->CartItem->rollback();
					$this->Solicitation->rollback();
					$return = false;
				}
			}else {
				$this->Solicitation->rollback();
				$return = false;
			}
			
			echo json_encode(array('return'=>$return));			
		}	
	}
	
/**
 * 
 */
	private function __getKeyCode() {
		
		$fit = '';
		$count = $this->Solicitation->find('count');
		$keycode = $count + 1;

		if($count < 10) {
			$fit = '00';
		}else if($count >= 10 && $count < 100) {
			$fit = '0';
		}
		
		return $fit.$keycode;
	}

}
