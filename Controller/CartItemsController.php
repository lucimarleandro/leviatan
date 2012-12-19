<?php

App::uses('AppController', 'Controller');

/**
 * CartItems Controller
 *
 * @property CartItem $CartItem
 */
class CartItemsController extends AppController {

    public $uses = array('CartItem', 'Solicitation', 'SolicitationItem', 'SolicitationTemporary');

/**
 * 
 */
    public function index() {
        $this->set('title_for_layout', 'Finalizar solicitação');
        $ajax = false;
        if ($this->request->is('AJAX')) {
            $ajax = true;
            $this->layout = 'ajax';
        }

        $options['limit'] = 10;
        $options['conditions'] = array(
            'CartItem.user_id' => $this->Auth->user('id')
        );
        $this->paginate = $options;

        $items = $this->paginate();
        if(empty($items) && $this->request->params['paging']['CartItem']['pageCount'] > 0) {
            $this->redirect(array('controller' => 'cart_items', 'action' => 'index', 'page' => $this->request['params']['paging']['CartItem']['page']));
        }else if(empty($items)) {
            $this->Session->setFlash(__('Não há solicitações pendentes'), 'default', array('class' => 'alert alert-error'));
            if (!$this->request->is('ajax')) {
                $this->redirect(array('controller' => 'solicitation_items', 'action' => 'index'));
            } else {
                echo json_encode(array('redirect' => true));
                $this->autoRender = false;
            }
            return false;
        }
        
        $temp = $this->__getSolicitationTemporary();

        $this->set(compact('ajax', 'items', 'temp'));
    }
    
/**
 * 
 */
    public function edit() {
        $this->autoRender = false;
        if ($this->request->is('ajax')) {
            $this->CartItem->id = $this->request->data['cart_item_id'];

            if ($this->CartItem->saveField('quantity', $this->request->data['quantity'])) {
                $return = true;
            } else {
                $return = false;
            }

            echo json_encode(array('return' => $return));
        }
    }

/**
 * 
 */
    public function add() {
        $this->autoRender = false;
        if ($this->request->is('AJAX')) {
            $user_id = $this->Auth->user('id');

            $data['CartItem']['user_id'] = $this->Auth->user('id');
            $data['CartItem']['item_id'] = $this->request->data['item_id'];
            $data['CartItem']['quantity'] = 1;

            if ($this->CartItem->save($data)) {
                $return = true;
            } else {
                $return = false;
            }

            echo json_encode(array('return' => $return));
        }
    }

/**
 * 
 */
    public function delete() {
        $this->autoRender = false;
        if ($this->request->is('AJAX')) {
            $this->CartItem->id = $this->request->data['cart_item_id'];

            $this->CartItem->begin();
            if ($this->CartItem->delete()) {                
                $options['conditions'] = array(
                    'CartItem.user_id'=>$this->Auth->user('id')    
                );                
                $this->CartItem->begin();
                $count = $this->CartItem->find('count', $options);
                $this->CartItem->commit();
               
                if($count == 0) {
                    unset($options);
                    $options['conditions'] = array(
                        'SolicitationTemporary.user_id'=>$this->Auth->user('id')
                    );
                    $this->SolicitationTemporary->recursive = -1;
                    $temp = $this->SolicitationTemporary->find('first', $options);
                    
                    if(empty($temp)) {
                        $this->CartItem->commit();
                        $return = true;                       
                    }else {                    
                        $this->SolicitationTemporary->id = $temp['SolicitationTemporary']['id'];                    
                        if($this->SolicitationTemporary->delete()) {
                            $this->CartItem->commit();
                            $return = true;
                        }else {
                            $this->CartItem->rollback();
                            $return = false;
                        }
                    }
                }else {
                    $this->CartItem->commit();
                    $return = true;
                }                
            } else {
                $this->CartItem->rollback();
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
        if ($this->request->is('AJAX')) {
            
            $options['conditions'] = array(
                'SolicitationTemporary.user_id'=>$this->Auth->user('id')
            );
            $this->Solicitation->recursive = -1;
            
            $temp = $this->SolicitationTemporary->find('first', $options);
            unset($options);
            
            $data['Solicitation']['keycode'] = $this->__getKeyCode();
            $data['Solicitation']['memo_number'] = $temp['SolicitationTemporary']['memo_number'];
            $data['Solicitation']['description'] = $temp['SolicitationTemporary']['description'];
            $data['Solicitation']['attachment'] = $temp['SolicitationTemporary']['attachment'];
            $data['Solicitation']['user_id'] = $this->Auth->user('id');
            $data['Solicitation']['status_id'] = PENDENTE;

            $this->CartItem->recursive = -1;
            $options['conditions'] = array(
                'CartItem.user_id' => $this->Auth->user('id')
            );
            $options['fields'] = array('CartItem.item_id', 'CartItem.quantity');
            $cartItems = $this->CartItem->find('all', $options);

            foreach ($cartItems as $key => $item):
                $this->SolicitationItem->create();
                $data['SolicitationItem'][$key]['item_id'] = $item['CartItem']['item_id'];
                $data['SolicitationItem'][$key]['quantity'] = $item['CartItem']['quantity'];
                $data['SolicitationItem'][$key]['status_id'] = PENDENTE;
            endforeach;
            
            $this->Solicitation->create();
            $this->Solicitation->begin();
            if ($this->Solicitation->saveAll($data)) {
                $this->CartItem->begin();
                if ($this->CartItem->deleteAll(array('CartItem.user_id'=>$this->Auth->user('id')), false)) {                    
                    $this->SolicitationTemporary->recursive = -1;
                    $options['conditions'] = array('SolicitationTemporary.user_id'=>$this->Auth->user('id'));
                    $options['fields'] = array('SolicitationTemporary.id');
                    
                    $temp = $this->SolicitationTemporary->find('first', $options);
                    
                    $this->SolicitationTemporary->id = $temp['SolicitationTemporary']['id'];
                    $this->SolicitationTemporary->begin();
                    if($this->SolicitationTemporary->delete()) {
                        $this->SolicitationTemporary->commit();
                        $this->Solicitation->commit();
                        $this->CartItem->commit();
                        
                        $return = true;
                    }else {
                        $this->CartItem->rollback();
                        $this->Solicitation->rollback();
                        $this->SolicitationTemporary->rollback();
                        
                        $return = false;
                    }
                } else {
                    $this->CartItem->rollback();
                    $this->Solicitation->rollback();
                    $return = false;
                }
            } else {
                $this->Solicitation->rollback();
                $return = false;
            }

            echo json_encode(array('return' => $return));
        }
    }
    
/**
 * 
 */
    public function finalize() {
        $userId = $this->Auth->user('id');

        $options['joins'] = array(
            array(
                'table'=>'cart_items',
                'alias'=>'CartItem',
                'type'=>'INNER',
                'conditions'=>array(
                    'SolicitationTemporary.user_id = CartItem.user_id'
                )
            ),
            array(
                'table'=>'items',
                'alias'=>'Item',
                'type'=>'Inner',
                'conditions'=>array(
                    'Item.id = CartItem.item_id'
                )
            )
        );
        $options['conditions'] = array(
            'SolicitationTemporary.user_id'=>$userId
        );
        $options['fields'] = array('SolicitationTemporary.*', 'CartItem.*', 'Item.id', 'Item.keycode', 'Item.name');

        $this->SolicitationTemporary->recursive = -1;
        $solicitation = $this->SolicitationTemporary->find('all', $options);

        $this->set(compact('solicitation'));
    }

/**
 * 
 */
    private function __getKeyCode() {

        $fit = '';
        $count = $this->Solicitation->find('count');
        $keycode = $count + 1;

        if ($count < 10) {
            $fit = '00';
        } else if ($count >= 10 && $count < 100) {
            $fit = '0';
        }

        return $fit . $keycode;
    }
    
/**
 * 
 * @return type
 */
    private function __getSolicitationTemporary() {
        $userId = $this->Auth->user('id');
        
        $this->SolicitationTemporary->recursive = -1;
        $options['conditions'] = array(
            'SolicitationTemporary.user_id'=>$userId
        );
        
        $temp = $this->SolicitationTemporary->find('first', $options);

        return $temp;
    }

}
