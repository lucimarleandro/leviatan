<?php

App::uses('AppController', 'Controller');

/**
 * Orders Controller
 *
 * @property Order $Order
 */
class OrdersController extends AppController {

    public $uses = array('Order', 'OrderItem', 'Solicitation', 'SolicitationItem');
    public $helpers = array('Utils');
    public $components = array('WkHtmlToPdf');

/**
 * (non-PHPdoc)
 * @see Controller::beforeFilter()
 */
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('getViewDump');
    }

/**
 * 
 */
    public function index() {
        $this->set('title_for_layout', 'Pedidos');
        $user = $this->Auth->user();
        $unitySectorId = $user['Employee']['unity_sector_id'];
        
        $this->OrderItem->recursive = -1;
        $options['joins'] = array(
            array(
                'table'=>'solicitation_items',
                'alias'=>'SolicitationItem',
                'type'=>'INNER',
                'conditions'=>array(
                    'OrderItem.solicitation_item_id = SolicitationItem.id'
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
        $options['fields'] = array('OrderItem.order_id');
        $options['group'] = array('OrderItem.order_id');
        
        $order_ids = $this->OrderItem->find('list', $options);
        
        unset($options);
        
        $options['limit'] = 10;
        $options['order'] = array('Order.created' => 'asc');
        $options['group'] = array('DATE_FORMAT(Order.created, "%Y-%m-%d")');
        $options['fields'] = array('Order.created');
        $options['conditions'] = array(
          'Order.id'=>$order_ids  
        );

        $this->paginate = $options;
        $this->Order->recursive = -1;
        $orders = $this->paginate();

        $this->set(compact('orders'));
    }

/**
 * 
 */
    public function view($date = null) {
        
        $user = $this->Auth->user();
        $unitySectorId = $user['Employee']['unity_sector_id'];
        
        $this->OrderItem->recursive = -1;
        $options['joins'] = array(
            array(
                'table'=>'solicitation_items',
                'alias'=>'SolicitationItem',
                'type'=>'INNER',
                'conditions'=>array(
                    'OrderItem.solicitation_item_id = SolicitationItem.id'
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
        $options['fields'] = array('OrderItem.order_id');
        $options['group'] = array('OrderItem.order_id');
        
        $order_ids = $this->OrderItem->find('list', $options);
        
        unset($options);
        
        $date = date('Y-m-d', strtotime($date));
        $options['limit'] = 10;
        $options['order'] = array('Order.keycode' => 'asc');
        $options['fields'] = array('Order.*', 'DATE_FORMAT(Order.created, "%Y-%m-%d")');
        $options['conditions'] = array(
            'Order.id'=>$order_ids,
            'Order.created LIKE'=>$date."%",
        );

        $this->paginate = $options;
        $this->Order->recursive = -1;
        $orders = $this->paginate();

        $this->set(compact('orders'));
    }

/**
 * 
 */
    public function add() {
        $this->autoRender = false;
        if ($this->request->is('AJAX')) {
            $solicitation_ids = $this->request->data['solicitation_ids'];
            
            //Recupera as solicitações que possuem itens com a mesma classe			
            $solicitationItems = $this->__getSolicitationItems($solicitation_ids);
            
            $this->Order->begin();
            $flag = true;
            foreach ($solicitationItems as $value):
                $data = array();
                $this->Order->create();
                $data['Order']['keycode'] = $this->__getKeycode();
                $data['Order']['opinion'] = $this->request->data['opinion'];
                
                foreach ($value as $v):
                    $this->OrderItem->create();
                    $data['OrderItem'][]['solicitation_item_id'] = $v;
                endforeach;

                if (!$this->Order->saveAll($data)) {
                    $flag = false;
                    break;
                }
            endforeach;
            
            //Algo deu errado, então não salva nenhum pedido
            if (!$flag) {
                $this->Order->rollback();
                $this->SolicitationItem->rollback();
                return json_encode(array('return'=>false));
            }
            
            //Verifica se de todas as solicitações foram gerados os pedidos
            //----------
            $options['conditions'] = array(
                'SolicitationItem.solicitation_id'=>$solicitation_ids,
                'SolicitationItem.status_id'=>PENDENTE
            );
            $options['fields'] = array(
                'SolicitationItem.id'
            );
            
            $solicitationItemIds = $this->SolicitationItem->find('count', $options);

            $completed = false;
            if($solicitationItemIds == 0) {
                $completed = true;
            }
                                  
            //Se foram geradas os pedidos de todas as solicitações
            //Muda o status da solicitação para concluído 
            //-----------
            if($completed) {
                //Atualiza as solicitações para o status concluído
                $conditions = array(
                    'Solicitation.id'=>$solicitation_ids
                );
                $fields = array(
                    'Solicitation.status_id'=>CONCLUIDO
                );
                
                $this->Solicitation->begin();
                $updateSolicitations = $this->Solicitation->updateAll($fields, $conditions);
                
                if(!$updateSolicitations) {
                    $this->Order->rollback();
                    return json_encode(array('return'=>false));
                }
                
                $this->Solicitation->commit();
            }            
            
            $this->Order->commit();

            return json_encode(array('return'=>true));
        }
    }
    
/**
 * 
 */
    public function report($order_id = null) {
        $this->layout = 'default';
        $this->OrderItem->recursive = -1;
        $this->SolicitationItem->recursive = -1;
        //As solicitações sem repetições
        $solicitations = $this->OrderItem->find('all', $this->____getOptionsOrderItem($order_id));
        //Todos os itens que estão no pedido atual
        $solicitation_items = $this->OrderItem->find('list', array('conditions' => array('OrderItem.order_id' => $order_id), 'fields' => array('OrderItem.solicitation_item_id')));
        foreach ($solicitations as $key => $solicitation):
            //Recupera os itens do pedido a solicitação passada como parãmetro
            $items = $this->SolicitationItem->find('all', $this->__getOptionsSolicitationItems($solicitation['Solicitation']['id'], $solicitation_items));
            $data[$key] = $solicitation;
            $data[$key]['solicitation_items'] = $items;
        endforeach;

        //Consolidado
        $items = array();
        $columns = array();
        $descriptions = array();
        foreach ($data as $value):
            if (!in_array($value['Unity']['name'], $columns)) {
                $columns[] = $value['Unity']['name'];
            }
            $unity = $value['Unity']['name'];
            foreach ($value['solicitation_items'] as $item):
                $descriptions[$item['Item']['keycode']] = array('name' => $item['Item']['name'], 'description' => $item['Item']['description'], 'specification' => $item['Item']['specification']);
                if(isset($consolidation[$item['Item']['keycode']][$unity])) {
                    $consolidation[$item['Item']['keycode']][$unity] += $item['SolicitationItem']['quantity'];
                } else {
                    $consolidation[$item['Item']['keycode']][$unity] = $item['SolicitationItem']['quantity'];
                }
            endforeach;
        endforeach;

        ksort($consolidation);
        $this->set(compact('data', 'columns', 'consolidation', 'descriptions'));
        $this->WkHtmlToPdf->createPdf();
    }

/**
 *
 * @param unknown_type $filename
 */
    public function getViewDump($filename) {
        $this->WkHtmlToPdf->getViewDump($filename);
    }

/**
 * 
 * @param unknown_type $solicitation_id
 * @param unknown_type $solicitation_items
 */
    private function __getOptionsSolicitationItems($solicitation_id, $solicitation_items) {
        $options['joins'] = array(
            array(
                'table' => 'items',
                'alias' => 'Item',
                'type' => 'INNER',
                'conditions' => array(
                    'SolicitationItem.item_id = Item.id'
                )
            )
        );
        $options['fields'] = array(
            'Item.keycode', 'Item.name',
            'Item.description', 'Item.specification', 'SolicitationItem.quantity'
        );
        $options['conditions'] = array(
            'SolicitationItem.solicitation_id' => $solicitation_id,
            'SolicitationItem.id' => $solicitation_items
        );
        $options['order'] = array(
            'Item.keycode'=>'ASC'
        );

        return $options;
    }

/**
 * 
 * @param unknown_type $order_id
 */
    private function ____getOptionsOrderItem($order_id) {
        $options['joins'] = array(
            array(
                'table' => 'orders',
                'alias' => 'Order',
                'type' => 'INNER',
                'conditions' => array(
                    'OrderItem.order_id = Order.id'
                )
            ),            
            array(
                'table' => 'solicitation_items',
                'alias' => 'SolicitationItem',
                'type' => 'INNER',
                'conditions' => array(
                    'OrderItem.solicitation_item_id = SolicitationItem.id'
                )
            ),
            array(
                'table' => 'items',
                'alias' => 'Item',
                'type' => 'INNER',
                'conditions' => array(
                    'SolicitationItem.item_id = Item.id'
                )
            ), 
            array(
                'table'=>'head_orders',
                'alias'=>'HeadOrder',
                'type'=>'INNER',
                'conditions'=>array(
                    'Item.item_class_id = HeadOrder.item_class_id',
                )
            ), 
            array(
                'table' => 'solicitations',
                'alias' => 'Solicitation',
                'type' => 'INNER',
                'conditions' => array(
                    'SolicitationItem.solicitation_id = Solicitation.id'
                )
            ),
            array(
                'table' => 'users',
                'alias' => 'User',
                'type' => 'INNER',
                'conditions' => array(
                    'Solicitation.user_id = User.id'
                )
            ),
            array(
                'table' => 'employees',
                'alias' => 'Employee',
                'type' => 'INNER',
                'conditions' => array(
                    'User.employee_id = Employee.id'
                )
            ),
            array(
                'table' => 'unity_sectors',
                'alias' => 'UnitySector',
                'type' => 'INNER',
                'conditions' => array(
                    'Employee.unity_sector_id = UnitySector.id'
                )
            ),
            array(
                'table' => 'unities',
                'alias' => 'Unity',
                'type' => 'INNER',
                'conditions' => array(
                    'UnitySector.unity_id = Unity.id'
                )
            ),
            array(
                'table' => 'sectors',
                'alias' => 'Sector',
                'type' => 'INNER',
                'conditions' => array(
                    'UnitySector.sector_id = Sector.id'
                )
            ),
             array(
                'table' => 'unity_sectors',
                'alias' => 'UnitySectorResponsible',
                'type' => 'INNER',
                'conditions' => array(
                    'UnitySectorResponsible.id = HeadOrder.unity_sector_id'
                )
            ),
            array(
                'table' => 'unities',
                'alias' => 'UnityResponsible',
                'type' => 'INNER',
                'conditions' => array(
                    'UnityResponsible.id = UnitySectorResponsible.unity_id'
                )
            ),
            array(
                'table' => 'sectors',
                'alias' => 'SectorResponsible',
                'type' => 'INNER',
                'conditions' => array(
                    'SectorResponsible.id = UnitySectorResponsible.sector_id'
                )
            )
        );
        $options['conditions'] = array('OrderItem.order_id' => $order_id);
        $options['fields'] = array(
            'Order.opinion', 'Solicitation.id', 'Solicitation.keycode', 'Solicitation.memo_number', 'Solicitation.description', 'Solicitation.attachment','Solicitation.created',
            'Employee.name', 'Employee.surname', 'Unity.name', 'Sector.name', 'UnityResponsible.name', 'SectorResponsible.name'
        );
        $options['group'] = array('SolicitationItem.solicitation_id');

        return $options;
    }

/**
 * Recupera as solicitações agrupando-as por classe 
 */
    private function __getSolicitationItems($solicitation_ids) {
        $this->SolicitationItem->recursive = -1;
        
        $user = $this->Auth->user();
        $unitySectorId = $user['Employee']['unity_sector_id'];
        
        $options['joins'] = array(
            array(
                'table' => 'items',
                'alias' => 'Item',
                'type' => 'INNER',
                'conditions' => array(
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
            'SolicitationItem.solicitation_id' => $solicitation_ids,
            'SolicitationItem.status_id' => APROVADO
        );
        $options['fields'] = array('Item.item_class_id');
        $options['group'] = array('Item.item_class_id');

        //Recupera as classes dos itens
        $item_class_ids = $this->SolicitationItem->find('list', $options);

        //Remove índices não necessários para a próxima consulta
        unset($options['conditions'], $options['fields'], $options['group']);

        $solicitationItems = array();
        foreach ($item_class_ids as $value) {
            $options['conditions'] = array(
                'SolicitationItem.solicitation_id'=>$solicitation_ids,
                'SolicitationItem.status_id'=>APROVADO,
                'Item.item_class_id'=>$value
            );
            $options['fields'] = array('SolicitationItem.id');
            $solicitationItems[] = $this->SolicitationItem->find('list', $options);
        }

        return $solicitationItems;
    }

/**
 * 
 */
    private function __getKeycode() {

        $count = $this->Order->find('count');

        if ($count < 10) {
            $keycode = '00';
        } else if ($count < 100) {
            $keycode = '0';
        }

        $keycode .= $count + 1;

        return $keycode . '/' . date('y');
    }

}
