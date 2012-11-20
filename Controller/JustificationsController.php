<?php
App::uses('AppController', 'Controller');
/**
 * Justifications Controller
 *
 * @property Justification $Justification
 */
class JustificationsController extends AppController {
	
	public $uses = array('Justification', 'SolicitationItem'); 
	public $helpers = array('Tinymce');

/**
 * 
 */
	public function add($solicitation_item_id = null) {
		
		if($this->request->is('AJAX')) {
			if($solicitation_item_id) { //Não veio do form
				$this->set(compact('solicitation_item_id'));
			}else { //veio do form add
				$this->autoRender = false;
				
				$return = $this->__getDenySolicitationItem($this->request->data);
				
				echo json_encode(array('return'=>$return));
				exit;
			}
		}
		
	}
	
/**
 * 
 */
	public function view($solicitation_item_id) {
		if($this->request->is('AJAX')) {
			$options['conditions'] = array(
				'Justification.solicitation_item_id'=>$solicitation_item_id	
			);			
			$justification = $this->Justification->find('first', $options);
			
			$this->set(compact('justification'));
		}
	}
	
/**
 * 
 */
	private function __getDenySolicitationItem($data) {
		
		$name = 'status_id';
		$value = NEGADO;
		
		$this->SolicitationItem->begin();
		$this->Justification->begin();
		
		$this->SolicitationItem->id = $data['Justification']['solicitation_item_id'];
		if($this->SolicitationItem->saveField($name, $value, false)) {
			if($this->Justification->save($data)) {
				$this->Justification->commit();
				$this->SolicitationItem->commit();
				$return = true;
			}else {
				$this->Justification->roolback();
				$this->SolicitationItem->roolback();
				$return = false;
			}			
		}else {
			$this->SolicitationItem->rollback();
			$return = false;
		}
		
		return $return;			
	}
}
