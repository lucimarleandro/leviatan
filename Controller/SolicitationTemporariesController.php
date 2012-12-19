<?php
App::uses('AppController', 'Controller');
/**
 * SolicitationTemporaries Controller
 *
 * @property SolicitationTemporary $SolicitationTemporary
 */
class SolicitationTemporariesController extends AppController {
    
    
    
/**
 * 
 */
    public function add() {
        $this->autoRender = false;
        if($this->request->is('AJAX')) {
            
            $userId = $this->Auth->user('id');
            
            $options['conditions'] = array(
                'SolicitationTemporary.user_id'=>$userId
            );
            $options['fields'] = array(
                'SolicitationTemporary.id'
            );
            $temp = $this->SolicitationTemporary->find('first', $options);
            
            $field = $this->request->data['field'];
            $value = $this->request->data['value'];
            
            if(!empty($temp)) {
                //Recupera o registro e atualiza o campo
                $this->SolicitationTemporary->id = $temp['SolicitationTemporary']['id'];                
                if($this->SolicitationTemporary->saveField($field, $value)) {
                    $return = true;
                }else {
                    $return = false;
                }
            }else {
                //Cria um novo registro
                $data['SolicitationTemporary']['user_id'] = $userId;
                $data['SolicitationTemporary'][$field] = $value;
                
                $this->SolicitationTemporary->create();
                if($this->SolicitationTemporary->save($data)) {
                    $return = true;
                }else {
                    $return = false;
                }
            }
            
            echo json_encode($return);
        }
    }

}
