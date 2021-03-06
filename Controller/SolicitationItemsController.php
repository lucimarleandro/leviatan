<?php

App::uses('AppController', 'Controller');

/**
 * SolicitationItems Controller
 *
 * @property SolicitationItem $SolicitationItem
 */
class SolicitationItemsController extends AppController {

    public $uses = array('SolicitationItem', 'Item', 'CartItem', 'HeadOrder');
    public $helpers = array('Tinymce');

/**
 * 
 */
    public function index() {
        $this->set('title_for_layout', 'Fazer solicitação');
        $ajax = false;
        if ($this->request->is('ajax')) {
            $this->layout = 'ajax';
            $ajax = true;
            if($this->request->data) {
                $options = array();
                if (!empty($this->request->data['item_group_id'])) {
                    $options['conditions'][] = array('ItemGroup.id' => $this->request->data['item_group_id']);
                }
                if (!empty($this->request->data['item_class_id'])) {
                    $options['conditions'][] = array('Item.item_class_id' => $this->request->data['item_class_id']);
                }
                if (isset($this->request->data['item_name']) && !empty($this->request->data['item_name'])) {
                    $options['conditions'][] = array('Item.name' => $this->request->data['item_name']);
                }
                $this->Session->write('options', $options);
            }
        }
        if ($this->request->is('ajax') && $this->Session->read('options')) {
            $options = $this->Session->read('options');
        } else {
            $this->Session->delete('options');
        }

        $this->Item->recursive = -1;
        $options['limit'] = 10;
        $options['order'] = array('Item.keycode' => 'asc');
        $options['conditions'][] = array('Item.status_id'=>ATIVO);
        $options['fields'] = array('Item.*', 'ItemClass.*', 'PngcCode.*', 'Status.*');
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
            ),array(
                'table'=>'pngc_codes',
                'alias'=>'PngcCode',
                'type'=>'INNER',
                'conditions'=>array(
                    'Item.pngc_code_id = PngcCode.id'
                )
            ),
            array(
                'table'=>'statuses',
                'alias'=>'Status',
                'type'=>'INNER',
                'conditions'=>array(
                    'Item.status_Id = Status.id'
                )
            ),
        );
        
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
        $this->set('title_for_layout', 'Itens da solicitação');
        $ajax = false;
        if ($this->request->is('ajax')) {
            $this->layout = 'ajax';
            $ajax = true;
            if ($this->request->data) {
                /* $options = array();
                  if(!empty($this->request->data['item_class_id'])){
                  $options['conditions'][] = array('Item.item_class_id'=>$this->request->data['item_class_id']);
                  }
                  if(isset($this->request->data['item_name']) && !empty($this->request->data['item_name'])) {
                  $options['conditions'][] = array('Item.name'=>$this->request->data['item_name']);
                  }
                  $this->Session->write('options', $options); */
            }
        }
        if ($this->request->is('ajax') && $this->Session->read('options')) {
            $options = $this->Session->read('options');
        } else {
            $this->Session->delete('options');
        }
        
        $user = $this->Auth->user();
        $unitySectorId = $user['Employee']['unity_sector_id'];
        
        $this->SolicitationItem->recursive = -1;
        
        $options['joins'] = array(
            array(
                'table'=>'solicitations',
                'alias'=>'Solicitation',
                'type'=>'INNER',
                'conditions'=>array(
                    'SolicitationItem.solicitation_id = Solicitation.id'
                )
            ),
            array(
                'table'=>'users',
                'alias'=>'User',
                'type'=>'INNER',
                'conditions'=>array(
                    'Solicitation.user_id = User.id'
                )
            ),
            array(
                'table'=>'employees',
                'alias'=>'Employee',
                'type'=>'INNER',
                'conditions'=>array(
                    'Employee.id = User.employee_id'
                )
            ),
            array(
                'table'=>'unity_sectors',
                'alias'=>'UnitySector',
                'type'=>'INNER',
                'conditions'=>array(
                    'Employee.unity_sector_id = UnitySector.id'
                )
            ),
            array(
                'table'=>'unities',
                'alias'=>'Unity',
                'type'=>'INNER',
                'conditions'=>array(
                    'UnitySector.unity_id= Unity.id'
                )
            ),
            array(
                'table'=>'sectors',
                'alias'=>'Sector',
                'type'=>'INNER',
                'conditions'=>array(
                    'UnitySector.sector_id = Sector.id'
                )
            ),
            array(
                'table'=>'items',
                'alias'=>'Item',
                'type'=>'INNER',
                'conditions'=>array(
                    'SolicitationItem.item_id = Item.id'
                )
            ),
            array(
                'table'=>'head_orders',
                'alias'=>'HeadOrder',
                'type'=>'INNER',
                'conditions'=>array(
                    'Item.item_class_id = HeadOrder.item_class_id',
                    'HeadOrder.unity_sector_id'=>$unitySectorId
                )
            )
        );
        $options['conditions'] = array(
            'SolicitationItem.solicitation_id' => $solicitation_id
        );
        $options['order'] = array(
            'Item.name'=>'asc'
        );
        $options['fields'] = array(
            'Unity.name', 'Sector.name',
            'Solicitation.memo_number', 'Solicitation.description', 'Solicitation.attachment',
            'SolicitationItem.id', 'SolicitationItem.quantity', 'SolicitationItem.solicitation_id',
            'SolicitationItem.status_id', 'Item.name', 'Item.id'
        );
        $options['limit'] = 10;

        $this->paginate = $options;
        $solicitationItems = $this->paginate();
        
        $this->set('solicitation_id', $solicitation_id);
        $this->set(compact('solicitationItems', 'ajax'));
    }
    
/**
 * Lista os itens que estão sendo pedidos na rede
 * juntamente com suas quantidades
 */
    public function network() {
        
        $this->SolicitationItem->recursive = 0;
        
        $options['conditions'] = array(
            'SolicitationItem.status_id'=>PENDENTE
        );
        $options['fields'] = array(
            'Item.id', 'Item.keycode', 'Item.name', 'sum(SolicitationItem.quantity) as sum'
        );
        $options['order'] = array(
            'Item.keycode'=>'ASC'
        );
        $options['group'] = array(
            'SolicitationItem.item_id'
        );
        //$options['limit'] = 10;
        
        $cart_items = $this->__getCartItems();
        
        $data = $this->SolicitationItem->find('all', $options);
        $pending = $this->__getSolicitationItemsPending();
        
        $this->set(compact('data', 'cart_items', 'pending'));
    }

/**
 * 
 */
    public function check() {
        $this->autoRender = false;
        if ($this->request->is('AJAX')) {
            
            $user = $this->Auth->user();
            $unitySectorId = $user['Employee']['unity_sector_id'];

            $this->SolicitationItem->recursive = -1;
            $options['joins'] = array(
                array(
                    'table'=>'items',
                    'alias'=>'Item',
                    'type'=>'INNER',
                    'conditions'=>array(
                        'SolicitationItem.item_id = Item.id'
                    )
                 ),
                 array(
                    'table'=>'head_orders',
                    'alias'=>'HeadOrder',
                    'type'=>'INNER',
                    'conditions'=>array(
                        'Item.item_class_id = HeadOrder.item_class_id',
                        'HeadOrder.unity_sector_id'=>$unitySectorId
                    )
                )
            );

            $options['conditions'] = array(
                'SolicitationItem.solicitation_id' => $this->request->data['solicitation_ids'],
                'SolicitationItem.status_id' => PENDENTE
            );
            $count = $this->SolicitationItem->find('count', $options);

            if ($count == 0) {
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
    public function accept() {
        $this->autoRender = false;
        if ($this->request->is('ajax')) {
            $name = 'status_id';
            $value = APROVADO;

            $this->SolicitationItem->id = $this->request->data['solicitation_item_id'];
            if ($this->SolicitationItem->saveField($name, $value, false)) {
                $return = true;
            } else {
                $return = false;
            }

            echo json_encode(array('return'=>$return));
        }
    }
    
/**
 * 
 */
    public function approveSelected() {
        $this->autoRender = false;
        if($this->request->is('ajax')) {
            
            $fields = array('SolicitationItem.status_id'=>APROVADO);
            $conditions = array('SolicitationItem.id'=>$this->request->data['solicitationItemIds']);
            
            if($this->SolicitationItem->updateAll($fields, $conditions)) {
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
                'table' => 'item_classes',
                'alias' => 'ItemClass',
                'type' => 'INNER',
                'conditions' => array(
                    'Item.item_class_id = ItemClass.id'
                )
            ),
            array(
                'table' => 'item_groups',
                'alias' => 'ItemGroup',
                'type' => 'INNER',
                'conditions' => array(
                    'ItemClass.item_group_id = ItemGroup.id'
                )
            )
        );
        $options['fields'] = array('DISTINCT ItemGroup.id', 'ItemGroup.keycode', 'ItemGroup.name');

        $this->Item->recursive = -1;
        $groups = $this->Item->find('all', $options);

        $values = array();
        foreach ($groups as $group):
            $values[$group['ItemGroup']['id']] = $group['ItemGroup']['keycode'] . ' - ' . $group['ItemGroup']['name'];
        endforeach;
        $groups = $values;

        return array('' => 'Selecione um grupo') + $groups;
    }

/**
 * 
 */
    private function __getCartItems() {
        $options['conditions'] = array(
            'CartItem.user_id' => $this->Auth->user('id')
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
                'table' => 'solicitations',
                'alias' => 'Solicitation',
                'type' => 'INNER',
                'conditions' => array(
                    'Solicitation.user_id' => $this->Auth->user('id'),
                    'Solicitation.id = SolicitationItem.solicitation_id'
                )
            )
        );
        $options['conditions'] = array(
            'SolicitationItem.status_id' => PENDENTE
        );
        $options['fields'] = array(
            'SolicitationItem.item_id'
        );

        $pending = $this->SolicitationItem->find('list', $options);

        return $pending;
    }

}
