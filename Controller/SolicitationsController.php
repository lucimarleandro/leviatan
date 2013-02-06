<?php

App::uses('AppController', 'Controller');
App::uses('View', 'View');

/**
 * Solicitations Controller
 *
 * @property Solicitation $Solicitation
 */
class SolicitationsController extends AppController {

    public $uses = array('Solicitation', 'SolicitationItem');
    public $helpers = array('Utils');
    public $components = array('WkHtmlToPdf');

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('getViewDump');
    }

/**
 * 
 */
    public function index() {
        $this->set('title_for_layout', 'Minhas solicitações');
        $this->Solicitation->recursive = 0;
        $options['conditions'] = array(
            'Solicitation.user_id' => $this->Auth->user('id')
        );
        $options['fields'] = array('Solicitation.id', 'Solicitation.keycode', 'Solicitation.memo_number', 'Solicitation.created', 'Status.name');
        $options['order'] = array('Solicitation.created' => 'asc');

        $this->paginate = $options;
        $solicitations = $this->paginate();

        $this->set(compact('solicitations'));
    }

/**
 * 
 * @param type $id
 */
    public function view($id = null) {
        $this->Solicitation->recursive = -1;
        $this->SolicitationItem->recursive = -1;                
        
        $options['joins'] = array(
            array(
                'table'=>'items',
                'alias'=>'Item',
                'type'=>'inner',
                'conditions'=>array(
                    'Item.id = SolicitationItem.item_id'
                )
            ),
            array(
                'table'=>'item_classes',
                'alias'=>'ItemClass',
                'type'=>'INNER',
                'conditions'=>array(
                    'Item.item_class_id = ItemClass.id'
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
                'table'=>'unity_sectors',
                'alias'=>'UnitySector',
                'type'=>'INNER',
                'conditions'=>array(
                    'UnitySector.id = HeadOrder.unity_sector_id',
                )
            ),
            array(
                'table'=>'unities',
                'alias'=>'Unity',
                'type'=>'INNER',
                'conditions'=>array(
                    'Unity.id = UnitySector.unity_id',
                )
            ),
            array(
                'table'=>'sectors',
                'alias'=>'Sector',
                'type'=>'INNER',
                'conditions'=>array(
                    'Sector.id = UnitySector.sector_id',
                 )
            ),
            array(
                'table'=>'order_items',
                'alias'=>'OrderItem',
                'type'=>'LEFT',
                'conditions'=>array(
                    'SolicitationItem.id = OrderItem.solicitation_item_id'
                )
            ),
            array(
                'table'=>'orders',
                'alias'=>'Order',
                'type'=>'INNER',
                'conditions'=>array(
                    'OrderItem.order_id = Order.id'
                )
            )
        );
        $options['conditions'] = array(
            'SolicitationItem.solicitation_id'=>$id
        );
        $options['fields'] = array(
            'Item.keycode', 'Item.name', 'Item.item_class_id', 'ItemClass.keycode', 'ItemClass.name', 
            'SolicitationItem.id', 'SolicitationItem.quantity', 'SolicitationItem.status_id',
            'Unity.name', 'Sector.name',
            'Order.process_number'
        );
        $this->paginate = $options;
        $data = $this->paginate('SolicitationItem');
        
        $solicitation = $this->Solicitation->findById($id);

        $items = array();
        foreach($data as $value):
            $items[$value['ItemClass']['keycode'].'-'.$value['ItemClass']['name']][] = $value;
        endforeach;

        $this->set(compact('items', 'solicitation'));
    }
    
/**
 * Solicitações que estão pendentes para o homologador
 */
    public function analyze() {
        
        $this->set('title_for_layout', 'Analisar solicitações');
        $user = $this->Auth->user();
        $unitySectorId = $user['Employee']['unity_sector_id'];
        
        $this->SolicitationItem->recursive = -1;
        $options['joins'] = array(        
            array(
                'table'=>'order_items',
                'alias'=>'OrderItem',
                'type'=>'LEFT',
                'conditions'=>array(
                    'SolicitationItem.id = OrderItem.solicitation_item_id'
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
        $options['fields'] = array('SolicitationItem.solicitation_id');
        $options['group'] = array('SolicitationItem.solicitation_id');
        $options['conditions'] = array(
            'OrderItem.id IS NULL',
            'SolicitationItem.status_id !='=>NEGADO
        );        

        $solicitation_ids = $this->SolicitationItem->find('list', $options);
        
        unset($options);
        
        $options['joins'] = array(
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
            )            
        );
        $options['fields'] = array(
            'Solicitation.id', 'Solicitation.keycode', 'Solicitation.memo_number',
            'Solicitation.created', 'Employee.name', 'Unity.name', 'Sector.name'
        );
        $options['conditions'] = array(
            'Solicitation.status_id'=>PENDENTE,
            'Solicitation.id'=>$solicitation_ids
        );
        $this->paginate = $options;
        
        $this->Solicitation->recursive = -1;
        $solicitations = $this->paginate();
        $pending = $this->__getSumPendingSolicitationItems();

        $this->set(compact('solicitations', 'pending'));
    }

/**
 * 
 */
    public function printout($id = null) {
        $this->layout = 'default';
        $this->SolicitationItem->recursive = -1;
        
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
        $options['conditions'] = array(
            'Solicitation.id' => $id
        );
        $options['fields'] = array(
            'SolicitationItem.quantity',
            'Solicitation.description', 'Solicitation.memo_number', 'Solicitation.attachment', 'Solicitation.created',
            'Item.keycode', 'Item.name',
            'Employee.name', 'Employee.surname', 'Unity.name', 'Sector.name',
            'UnitySectorResponsible.id', 'UnityResponsible.name', 'SectorResponsible.name'
        );
        $options['order'] = array(
            'Item.keycode'=>'asc',
        );
        $data = $this->SolicitationItem->find('all', $options);
       
        foreach($data as $value):
            $consolidated[$value['UnitySectorResponsible']['id']][] = $value;
        endforeach;
        $this->set(compact('consolidated'));
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
 */
    private function __getSumPendingSolicitationItems() {
        
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
            'SolicitationItem.status_id' => PENDENTE
        );
        $options['fields'] = array(
            'SolicitationItem.solicitation_id'
        );
        $options['group'] = array(
            'SolicitationItem.solicitation_id'
        );

        $pending = $this->SolicitationItem->find('list', $options);

        return $pending;
    }

}
