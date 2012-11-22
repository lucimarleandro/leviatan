<?php
App::uses('AppController', 'Controller');

/**
 * HeadOrders Controller
 *
 * @property HeadOrder $HeadOrder
 */

class HeadOrdersController extends AppController {
    
/**
 *
 * @var type 
 */
    public $uses = array('HeadOrder', 'UnitySector', 'ItemClass');
    
/**
 * 
 */
    public function index() {
        
        $this->HeadOrder->recursive = -1;        
        $options['joins'] = array(
            array(
                'table'=>'unity_sectors',
                'alias'=>'UnitySector',
                'type'=>'INNER',
                'conditions'=>array(
                    'HeadOrder.unity_sector_id = UnitySector.id'
                )
            ),
            array(
                'table'=>'unities',
                'alias'=>'Unity',
                'type'=>'INNER',
                'conditions'=>array(
                    'UnitySector.unity_id = Unity.id'
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
                'table'=>'item_classes',
                'alias'=>'ItemClass',
                'type'=>'INNER',
                'conditions'=>array(
                    'HeadOrder.item_class_id = ItemClass.id'
                )
            )
        );

        $options['limit'] = 10;
        $options['order'] = array('Unity.name' => 'asc', 'Sector.name' => 'asc', 'ItemClass.keycode'=>'asc');
        $options['fields'] = array('Unity.name', 'Sector.name', 'HeadOrder.id', 'ItemClass.keycode', 'ItemClass.name');

        $this->paginate = $options;
        $headOrders = $this->paginate();

        $this->set(compact('headOrders'));
    }

/**
 * 
 */
    public function add() {
        
        if($this->request->is('POST')) {
            
             foreach ($this->request->data['HeadOrder']['item_class_id'] as $key=>$class):
                $data[$key]['HeadOrder']['unity_sector_id'] = $this->request->data['HeadOrder']['unity_sector_id'];
                $data[$key]['HeadOrder']['item_class_id'] = $class;
            endforeach;

            $this->HeadOrder->create();
            $this->HeadOrder->begin();
            if($this->HeadOrder->saveMany($data)) {
                $this->HeadOrder->commit();
                $this->Session->setFlash(__('Cadastrado com sucesso'), 'default', array('class'=>'alert alert-success'));
            }else {
                $this->HeadOrder->rollback();
                $this->Session->setFlash(__('Não foi pssível cadastrar'), 'default', array('class'=>'alert alert-error'));
                $this->redirect(array('action'=>'index'));
            }
        }
        
        $unitySectors = $this->__getUnitySector();        
        $this->set(compact('unitySectors'));
    }
    
/**
* 
* @param type $id
*/
    public function delete($id = null) {

        $this->HeadOrder->id = $id;
        if ($this->request->is('GET')) {
            $this->Session->setFlash(__('Requisição inválida'), 'default', array('class' => 'alert alert-error'));
            $this->redirect(array('action' => 'index'));
        }
        if (!$this->HeadOrder->exists()) {
            $this->Session->setFlash(__('Registro inválido'), 'default', array('class' => 'alert alert-error'));
            $this->redirect(array('action' => 'index'));
        }

        if ($this->HeadOrder->delete()) {
            $this->Session->setFlash(__('Deletado com sucesso'), 'default', array('class' => 'alert alert-success'));
        } else {
            $this->Session->setFlash(__('Não foi possível deletar'), 'default', array('class' => 'alert alert-error'));
        }

        $this->redirect(array('action' => 'index'));
    }
    
/**
 * 
 */
    public function get_item_classes() {
        $this->autoRender = false;
        if($this->request->is('AJAX')) {
            $unity_sector_id = $this->request->data['unity_sector_id'];
            
            $this->HeadOrder->recursive = -1;
            $options['joins'] = array(                        
                array(
                    'table'=>'item_classes',
                    'alias'=>'ItemClass',
                    'type'=>'RIGHT',
                    'conditions'=>array(
                        'HeadOrder.unity_sector_id'=>$unity_sector_id,
                        'HeadOrder.item_class_id = ItemClass.id'
                    )                
                )  
            );
            $options['conditions'] = array(
                'HeadOrder.id IS NULL'
            );
            $options['fields'] = array('ItemClass.id', 'ItemClass.keycode', 'ItemClass.name');
            
            $itemClasses = $this->HeadOrder->find('all', $options);
            
            foreach($itemClasses as $value):
                $values[$value['ItemClass']['id']] = $value['ItemClass']['keycode'].' - '.$value['ItemClass']['name'];
            endforeach;
            $values = array(''=>'Selecione uma classe') + $values;
            
            echo json_encode($values);
        }
    }
    
/**
 * 
 * @return array
 */
    private function __getUnitySector() {
        
        $this->UnitySector->recursive = -1;
        $options['joins'] = array(
            array(
                'table'=>'unities',
                'alias'=>'Unity',
                'type'=>'INNER',
                'conditions'=>array(
                    'UnitySector.unity_id = Unity.id'
                )                
            ),
             array(
                'table'=>'sectors',
                'alias'=>'Sector',
                'type'=>'INNER',
                'conditions'=>array(
                    'UnitySector.sector_id = Sector.id'
                )                
            ) 
        );
        $options['fields'] = array('UnitySector.id','Unity.name', 'Sector.name');
        $options['order'] = array('Unity.name'=>'asc');
        
        $unitySector = $this->UnitySector->find('all', $options);
        
        $values = array();
        foreach($unitySector as $value):
            $values[$value['UnitySector']['id']] = $value['Unity']['name'].' - '.$value['Sector']['name'];             
        endforeach;
        
        return array(''=>'Selecione uma unidade-setor') + $values;
    }

}
