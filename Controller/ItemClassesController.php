<?php

App::uses('AppController', 'Controller');

/**
 * ItemClasses Controller
 *
 * @property ItemClass $ItemClass
 */
class ItemClassesController extends AppController {

    public $uses = array('ItemClass', 'ItemGroup', 'Item', 'HeadOrder');

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow(array('get_item_classes', 'autocomplete', 'view'));
    }

/**
 * 
 */
    public function index() {

        $ajax = false;

        if ($this->request->is('ajax')) {
            $this->layout = 'ajax';
            $ajax = true;
            if ($this->request->data) {
                $options = array();
                if (!empty($this->request->data['item_group_id'])) {
                    $options['conditions'][] = array('ItemClass.item_group_id' => $this->request->data['item_group_id']);
                }
                if (isset($this->request->data['item_class_name']) && !empty($this->request->data['item_class_name'])) {
                    $options['conditions'][] = array('ItemClass.name' => $this->request->data['item_class_name']);
                }
                $this->Session->write('options', $options);
            }
        }
        if ($this->request->is('ajax') && $this->Session->read('options')) {
            $options = $this->Session->read('options');
        } else {
            $this->Session->delete('options');
        }

        $this->ItemClass->recursive = 0;
        $options['limit'] = 10;
        $options['order'] = array('ItemClass.keycode' => 'asc', 'ItemClass.name' => 'asc');

        $this->paginate = $options;
        $classes = $this->paginate();
        $groups = array('' => 'Selecione um Grupo') + $this->ItemGroup->find('list', array('fields' => array('ItemGroup.id', 'ItemGroup.keycode-name')));

        $this->set(compact('classes', 'groups', 'ajax'));
    }

/**
 * 
 * @param unknown_type $id
 */
    public function view($id = null) {
        $this->ItemClass->id = $id;
        $this->ItemClass->recursive = 0;

        if (!$this->ItemClass->exists()) {
            $this->Session->setFlash(__('Registro inválido'), 'default', array('class' => 'alert alert-error'));
            $this->redirect(array('action' => 'index'));
        }

        $class = $this->ItemClass->read();
        $this->set(compact('class'));
    }

/**
 * 
 */
    public function add() {
        if ($this->request->is('POST')) {
            if ($this->ItemClass->save($this->request->data)) {
                $this->Session->setFlash(__('Cadastrado com sucesso'), 'default', array('class' => 'alert alert-success'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('Não foi possível cadastrar'), 'default', array('class' => 'alert alert-error'));
            }
        }

        $groups = array('' => 'Selecione um item') + $this->ItemGroup->find('list', array('fields' => array('ItemGroup.id', 'ItemGroup.keycode-name')));
        $this->set(compact('groups'));
    }

/**
 * 
 * @param unknown_type $id
 */
    public function edit($id = null) {
        $this->ItemClass->id = $id;
        if ($this->request->is('POST') || $this->request->is('PUT')) {
            if ($this->ItemClass->save($this->request->data)) {
                $this->Session->setFlash(__('Editado com sucesso'), 'default', array('class' => 'alert alert-success'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('Não foi possível editar'), 'default', array('class' => 'alert alert-error'));
            }
        }
        $this->request->data = $this->ItemClass->read();
        $groups = array('' => 'Selecione um item') + $this->ItemGroup->find('list', array('fields' => array('ItemGroup.id', 'ItemGroup.keycode-name')));
        $this->set(compact('groups'));
    }

/**
 *
 * @param unknown_type $id
 */
    public function delete($id = null) {
        $this->ItemClass->id = $id;
        if ($this->request->is('GET')) {
            $this->Session->setFlash(__('Requisição inválida'), 'default', array('class' => 'alert alert-error'));
            $this->redirect(array('action' => 'index'));
        }
        if (!$this->ItemClass->exists()) {
            $this->Session->setFlash(__('Registro inválido'), 'default', array('class' => 'alert alert-error'));
            $this->redirect(array('action' => 'index'));
        }

        if ($this->ItemClass->delete()) {
            $this->Session->setFlash(__('Deletado com sucesso'), 'default', array('class' => 'alert alert-success'));
        } else {
            $this->Session->setFlash(__('Não foi possível deletar'), 'default', array('class' => 'alert alert-error'));
        }

        $this->redirect(array('action' => 'index'));
    }

/**
 *
 */
    public function autocomplete() {
        $this->autoRender = false;
        if ($this->request->is('AJAX')) {

            if (!empty($this->request->data['item_group_id'])) {
                $options['conditions'][] = array('ItemClass.item_group_id' => $this->request->data['item_group_id']);
            }
            $options['conditions'][] = array('ItemClass.name LIKE' => '%' . $this->request->data['item_class_name'] . '%');

            $this->ItemClass->recursive = -1;
            $items = $this->ItemClass->find('all', $options);

            $response = array();
            foreach ($items as $i => $value) {
                $response[$i] = array('label' => $value['ItemClass']['name']);
            }

            echo json_encode($response);
            exit;
        }
    }

/**
 * 
 */
    public function get_item_classes() {
        $this->autoRender = false;
        if ($this->request->is('AJAX')) {
            $item_group_id = $this->request->data['item_group_id'];
            $this->ItemClass->recursive = -1;

  
            $options['joins'] = array(
                array(
                    'table' => 'items',
                    'alias' => 'Item',
                    'type' => 'INNER',
                    'conditions' => array(
                        'Item.item_class_id = ItemClass.id'
                    )
                )
            );
            $options['fields'] = array('id', 'keycode-name');
            $options['conditions'] = array(
                'ItemClass.item_group_id' => $item_group_id
            );
            $options['order'] = array('ItemClass.keycode-name' => 'asc');

            $item_classes = $this->ItemClass->find('all', $options);

            foreach ($item_classes as $value):
                $values[$value['ItemClass']['id']] = $value['ItemClass']['keycode-name'];
            endforeach;
            $values = array('' => 'Selecione uma classe') + $values;

            echo json_encode($values);
            exit;
        }
    }
    
/**
 * Recupera a classe dos itens de acordo com o setor e o grupo da classe
 */
    public function get_item_classes_by_sectors($registered = false) {
        $this->autoRender = false;
        if ($this->request->is('AJAX')) {
            $item_group_id = $this->request->data['item_group_id'];
            $this->ItemClass->recursive = -1;
            
            $user = $this->Auth->user();
            $unitySectorId = $user['Employee']['unity_sector_id'];
            
            if($registered) {
                $join = array(
                    'table' => 'items',
                    'alias' => 'Item',
                    'type' => 'INNER',
                    'conditions' => array(
                        'Item.item_class_id = ItemClass.id'
                    )  
                );
            }else {
                $join = null;
            }
            
            $options['joins'] = array(               
                array(
                    'table' => 'head_orders',
                    'alias' => 'HeadOrder',
                    'type' => 'INNER',
                    'conditions' => array(
                        'ItemClass.id = HeadOrder.item_class_id',
                        'HeadOrder.unity_sector_id'=>$unitySectorId
                    )                        
                ),
                $join
            );

            $options['fields'] = array('ItemClass.id', 'ItemClass.keycode-name');
            $options['conditions'] = array(
                'ItemClass.item_group_id' => $item_group_id
            );
            $options['order'] = array('ItemClass.keycode-name' => 'asc');

            $item_classes = $this->ItemClass->find('all', $options);

            foreach ($item_classes as $value):
                $values[$value['ItemClass']['id']] = $value['ItemClass']['keycode-name'];
            endforeach;
            $values = array('' => 'Selecione uma classe') + $values;

            echo json_encode($values);
            exit;
        }
    }

}
