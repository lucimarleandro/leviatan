<?php

App::uses('AppController', 'Controller');

/**
 * Items Controller
 *
 * @property Item $Item
 */
class ItemsController extends AppController {

    public $uses = array('Item', 'ItemGroup', 'ItemClass', 'PngcCode', 'HeadOrder');
    public $components = array('Upload');
    public $helpers = array('Tinymce');

/**
 * (non-PHPdoc)
 * @see AppController::beforeFilter()
 */
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow(array('home', 'autocomplete', 'view'));
    }

/**
 * 
 */
    public function index() {
        $this->set('title_for_layout', 'Itens');
        $ajax = false;
        if ($this->request->is('ajax')) {
            $this->layout = 'ajax';
            $ajax = true;
            if ($this->request->data) {
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
        
        $user = $this->Auth->user();
        $unitySectorId = $user['Employee']['unity_sector_id'];
       
        $this->Item->recursive = -1;
        $options['limit'] = 10;
        $options['order'] = array('Item.keycode' => 'asc');
        $options['fields'] = array('Item.*', 'ItemClass.*', 'PngcCode.*');
        $options['joins'] = array(
            array(
                'table'=>'head_orders',
                'alias'=>'HeadOrder',
                'type'=>'INNER',
                'conditions'=>array(
                    'Item.item_class_id = HeadOrder.item_class_id',
                    'HeadOrder.unity_sector_id'=>$unitySectorId
                )
            ),
             array(
                'table'=>'pngc_codes',
                'alias'=>'PngcCode',
                'type'=>'INNER',
                'conditions'=>array(
                    'Item.pngc_code_id = PngcCode.id'
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
                'table'=>'item_groups',
                'alias'=>'ItemGroup',
                'type'=>'INNER',
                'conditions'=>array(
                    'ItemClass.item_group_id = ItemGroup.id'
                )
            )
        );

        $this->paginate = $options;
        $items = $this->paginate();

        $groups = $this->__getItemGroupsBySector(true);
        $complete = 'false';

        $this->set(compact('items', 'groups', 'ajax', 'complete'));
    }

/**
 * 
 * @param integer $id
 */
    public function view($id = null) {
        $this->set('title_for_layout', 'Visualizar Item');
        $this->Item->id = $id;
        $this->Item->recursive = -1;
        if (!$this->Item->exists()) {
            $this->Session->setFlash(__('Item inválido'), 'default', array('class' => 'alert alert-error'));
            $this->redirect(array('controller' => 'items', 'action' => 'index'));
        }
        $options['joins'] = array(
            array(
                'table' => 'item_classes',
                'alias' => 'ItemClass',
                'type' => 'INNER',
                'conditions' => array(
                    'ItemClass.id = Item.item_class_id'
                )
            ),
            array(
                'table' => 'pngc_codes',
                'alias' => 'PngcCode',
                'type' => 'INNER',
                'conditions' => array(
                    'PngcCode.id = Item.pngc_code_id'
                )
            ),
            array(
                'table' => 'expense_groups',
                'alias' => 'ExpenseGroup',
                'type' => 'INNER',
                'conditions' => array(
                    'ExpenseGroup.id = PngcCode.expense_group_id'
                )
            ),
            array(
                'table' => 'inputs',
                'alias' => 'Input',
                'type' => 'INNER',
                'conditions' => array(
                    'Input.id = PngcCode.input_id'
                )
            ),
            array(
                'table' => 'input_categories',
                'alias' => 'InputCategory',
                'type' => 'INNER',
                'conditions' => array(
                    'InputCategory.id = Input.input_category_id'
                )
            ),
            array(
                'table' => 'input_subcategories',
                'alias' => 'InputSubcategory',
                'type' => 'LEFT',
                'conditions' => array(
                    'InputSubcategory.id = Input.input_subcategory_id'
                )
            )
        );
        $options['fields'] = array(
            'Item.*',
            'ItemClass.id', 'ItemClass.keycode', 'ItemClass.name',
            'PngcCode.id', 'PngcCode.keycode',
            'ExpenseGroup.name',
            'InputCategory.name',
            'InputSubcategory.name'
        );
        $options['conditions'] = array(
            'Item.id' => $id
        );

        $item = $this->Item->find('first', $options);

        $this->set(compact('item'));
    }

/**
 * 
 */
    public function home() {
        $this->set('title_for_layout', 'Home');
        $ajax = false;
        if ($this->request->is('ajax')) {
            $this->layout = 'ajax';
            $ajax = true;
            if ($this->request->data) {
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
        
        $options['joins'] = array(
            array(
                'table'=>'pngc_codes',
                'alias'=>'PngcCode',
                'type'=>'INNER',
                'conditions'=>array(
                    'Item.pngc_code_id = PngcCode.id'
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
                'table'=>'item_groups',
                'alias'=>'ItemGroup',
                'type'=>'INNER',
                'conditions'=>array(
                    'ItemClass.item_group_id = ItemGroup.id'
                )
            )
        );
        $options['limit'] = 10;
        $options['order'] = array('Item.keycode' => 'asc');
        $options['conditions'][] = array('Item.status_id'=>ATIVO);
        $options['fields'] = array('Item.*', 'ItemClass.*', 'PngcCode.*');
        
        $this->paginate = $options;
        $items = $this->paginate();
        $groups = $this->__getItemGroups();
        $complete = 'false';
        
        $this->set(compact('items', 'groups', 'ajax', 'complete'));
    }

/**
 * 
 */
    public function add() {
        $this->set('title_for_layout', 'Adicionar item');
        if ($this->request->is('POST')) {
            $image_temp = $this->request->data['Item']['image'];
            if (!empty($image_temp['name'])) {
                $image = $this->__uploadImage($image_temp);
                if (!$image) {
                    $this->Session->setFlash(__('Erro ao fazer upload da imagem'), 'default', array('class' => 'alert alert-error'));
                    return;
                }
            } else {
                $image = null;
            }

            $keycode = $this->__getKeycode($this->request->data['Item']['item_class_id']);

            $this->request->data['Item']['keycode'] = $keycode;
            $this->request->data['Item']['image_path'] = $image;
            $this->request->data['Item']['status_id'] = PENDENTE;

            $this->Item->create();
            if ($this->Item->save($this->request->data)) {
                $this->Session->setFlash(__('Salvo com sucesso'), 'default', array('class' => 'alert alert-success'));
                $this->redirect($this->referer());
            } else {
                $this->Session->setFlash(__('Erro ao salvar o registro'), 'default', array('class' => 'alert alert-error'));
                if ($image != NULL) {
                    $this->__removeImage($image);
                }
            }
        }

        $groups = $this->__getItemGroupsBySector();
        $pngcCodes = $this->__getPngcCodes();

        $this->set(compact('groups', 'pngcCodes'));
    }

/**
 * 
 * @param integer $id
 */
    public function edit($id = null) {
        $this->set('title_for_layout', 'Editar item');
        $this->Item->id = $id;
        if ($this->request->is('POST') || $this->request->is('PUT')) {
            $previous_image = $this->request->data['Item']['previous_image'];
            $image_temp = $this->request->data['Item']['image'];
            if (!empty($image_temp['name'])) {
                $image = $this->__uploadImage($image_temp);
                if (!$image) {
                    $this->Session->setFlash(__('Erro ao fazer upload da imagem'), 'default', array('class' => 'alert alert-error'));
                    return;
                }
            } else {
                $image = $previous_image;
            }

            $this->request->data['Item']['image_path'] = $image;
            
            //Se a classe for alterada gerar um novo código para o item
            if($this->request->data['Item']['item_class_id'] != $this->request->data['Item']['bd_item_class_id']) {
                $keycode = $this->__getKeycode($this->request->data['Item']['item_class_id']);
                $this->request->data['Item']['keycode'] = $keycode;
            }

            if ($this->Item->save($this->request->data)) {
                $this->__removeImage($previous_image);
                $this->Session->setFlash(__('Editado com sucesso'), 'default', array('class' => 'alert alert-success'));
                $this->redirect(array('controller' => 'items', 'action' => 'index'));
            } else {
                $this->__removeImage($image);
                $this->Session->setFlash(__('Erro na edição. Por favor refaça as alterações'));
            }
        }

        $this->request->data = $this->Item->read();
        $groups = $this->__getItemGroupsBySector();
        $pngcCodes = $this->__getPngcCodes();

        $this->set(compact('groups', 'pngcCodes'));
    }

/**
 * 
 * @param unknown_type $id
 */
    public function delete($id = null) {
        $this->autoRender = false;

        $this->Item->recursive = -1;
        $this->Item->id = $id;

        if ($this->request->is('GET')) {
            $this->Session->setFlash(__('Requisição inválida'), 'default', array('class' => 'alert alert-error'));
            $this->redirect(array('controller' => 'items', 'action' => 'index'));
        }
        if (!$this->Item->exists()) {
            $this->Session->setFlash(__('Registro inválido'), 'default', array('class' => 'alert alert-error'));
            $this->redirect(array('controller' => 'items', 'action' => 'index'));
        }
        $item = $this->Item->read();
        if ($this->Item->delete()) {
            if (!empty($item['Item']['image_path'])) {
                $this->__removeImage($item['Item']['image_path']);
            }
            $this->Session->setFlash(__('Removido com sucesso'), 'default', array('class' => 'alert alert-success'));
        } else {
            $this->Session->setFlash(__('Erro ao remover'), 'default', array('class' => 'alert alert-error'));
        }

        $this->redirect(array('controller' => 'items', 'action' => 'index'));
    }

/**
 * 
 */
    public function autocomplete() {
        $this->autoRender = false;
        if ($this->request->is('AJAX')) {
            
            if (!empty($this->request->data['item_group_id'])) {
                $options['conditions'][] = array('ItemGroup.id' => $this->request->data['item_group_id']);
            }
            if (!empty($this->request->data['item_class_id'])) {
                $options['conditions'][] = array('Item.item_class_id' => $this->request->data['item_class_id']);
            }
            $options['conditions'][] = array('Item.name LIKE' => '%' . $this->request->data['item_name'] . '%');
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
            
            $this->Item->recursive = -1;
            $items = $this->Item->find('all', $options);

            $response = array();
            foreach ($items as $i => $value) {
                $response[$i] = array('label' => $value['Item']['name']);
            }
            
            if(empty($items)) {
                $response[] = array('label'=>'Nenhum item com os filtros especificados');
            }

            echo json_encode($response);
            exit;
        }
    }

/**
 * 
 */
    public function changeStatus() {
        $this->autoRender = false;
        if ($this->request->is('ajax')) {
            $this->Item->id = $this->request->data['item_id'];
            $status_id = $this->request->data['status_id'];

            if ($this->Item->saveField('status_id', $status_id, false)) {
                $result = true;
            } else {
                $result = false;
            }

            echo json_encode($result);
        }
    }
    
/**
 * 
 */
    private function __getItemGroupsBySector($registered = false) {
        
        $user = $this->Auth->user();
        $unitySectorId = $user['Employee']['unity_sector_id'];
        
        $this->HeadOrder->recursive = -1;
        $options['joins'] = array(
            array(
                'table'=>'item_classes',
                'alias'=>'ItemClass',
                'type'=>'INNER',
                'conditions'=>array(
                    'HeadOrder.item_class_id = ItemClass.id'
                )
            )
        );
        $options['conditions'] = array(
            'HeadOrder.unity_sector_id'=>$unitySectorId            
        );
        $options['fields'] = array('ItemClass.id', 'ItemClass.keycode');
        
        $itemClassIds = $this->HeadOrder->find('list', $options);
        
        unset($options);
        
        $this->ItemClass->recursive = -1;
        
        $join = array();
        if($registered) {            
            $join = array(
                'table'=>'items',
                'alias'=>'Item',
                'type'=>'INNER',
                'conditions'=>array(
                    'Item.item_class_id = ItemClass.id'
                )
            );           
        }else {
            $join = null;
        }

        
        $options['joins'] = array(
            array(
                'table'=>'item_groups',
                'alias'=>'ItemGroup',
                'type'=>'INNER',
                'conditions'=>array(
                    'ItemClass.item_group_id = ItemGroup.id'
                )
            ),
            $join
        );        
        $options['conditions'] = array(
            'ItemClass.keycode'=>$itemClassIds
        );
        $options['group'] = array('ItemClass.item_group_id');
        $options['fields'] = array('ItemGroup.id', 'ItemGroup.keycode', 'ItemGroup.name');

        $itemGroups = $this->ItemClass->find('all', $options);
        
        $values = array();
        foreach($itemGroups as $key=>$value):
            $values[$value['ItemGroup']['id']] = $value['ItemGroup']['keycode'].'-'.$value['ItemGroup']['name'];
        endforeach;
        $values = array(''=>'Selecione um grupo') + $values;
        
        return $values;
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
    private function __getPngcCodes() {

        $options['joins'] = array(
            array(
                'table' => 'expense_groups',
                'alias' => 'ExpenseGroup',
                'type' => 'INNER',
                'conditions' => array(
                    'ExpenseGroup.id = PngcCode.expense_group_id'
                )
            ),
            array(
                'table' => 'inputs',
                'alias' => 'Input',
                'type' => 'INNER',
                'conditions' => array(
                    'Input.id = PngcCode.input_id'
                )
            ),
            array(
                'table' => 'input_categories',
                'alias' => 'InputCategory',
                'type' => 'INNER',
                'conditions' => array(
                    'InputCategory.id = Input.input_category_id'
                )
            ),
            array(
                'table' => 'input_subcategories',
                'alias' => 'InputSubcategory',
                'type' => 'LEFT',
                'conditions' => array(
                    'InputSubcategory.id = Input.input_subcategory_id'
                )
            )
        );
        $options['fields'] = array('DISTINCT PngcCode.id', 'PngcCode.keycode', 'ExpenseGroup.name', 'InputCategory.name', 'InputSubcategory.name');

        $this->PngcCode->recursive = -1;
        $pngcCodes = $this->PngcCode->find('all', $options);

        foreach ($pngcCodes as $value):
            if ($value['InputSubcategory']['name'] != NULL) {
                $values[$value['PngcCode']['id']] = $value['PngcCode']['keycode'] . ' - ' . $value['ExpenseGroup']['name'] . ' - ' . $value['InputCategory']['name'] . ' - ' . $value['InputSubcategory']['name'];
            } else {
                $values[$value['PngcCode']['id']] = $value['PngcCode']['keycode'] . ' - ' . $value['ExpenseGroup']['name'] . ' - ' . $value['InputCategory']['name'];
            }

        endforeach;
        $pngcCodes = array('' => 'Selecione um item') + $values;
        
        return $pngcCodes;
    }

/**
 *
 * Enter description here ...
 */
    private function __uploadImage($image) {

        $this->Upload->upload($image);
        $imgName = date('dmY_His');

        $this->Upload->file_new_name_body = $imgName;
        $this->Upload->image_resize = true;
        $this->Upload->image_x = 150;
        $this->Upload->image_x = 150;
        //$this->Upload->image_ratio_y = true;
        $this->Upload->jpeg_quality = 100;
        $this->file_max_size = '3000';

        $this->Upload->allowed = array('image/jpeg', 'image/jpg', 'image/gif', 'image/png');
        $this->Upload->process('img/items/');

        if ($this->Upload->processed) {
            $this->Upload->clean();
        } else {
            debug($this->Upload->error);
            //$this->erro = $this->Upload->error;
            return false;
        }

        return $imgName . '.' . $this->Upload->file_src_name_ext;
    }

/**
 *
 * Função que remove uma imagem do servidor
 * @param nome da imagem
 */
    private function __removeImage($image_path) {

        $image_path = IMAGES . 'items' . DS . $image_path;

        return $this->__removeFile($image_path);
    }

/**
 *
 * Função que remove um arquivo do servidor
 * @param caminho para o arquivo no servidor
 */
    private function __removeFile($path_file) {
        // Teste para saber se existe o arquivo e para evitar Warning devido os diretorios localizadores (ponto e ponto ponto)
        if (is_file($path_file) && (substr($path_file, -1) != '.' && substr($path_file, -2) != '..')) {
            return unlink($path_file);
        } else {
            return false;
        }
    }

/**
 * 
 * @param unknown_type $item_class_id
 */
    private function __getKeycode($item_class_id) {
        $options['conditions'] = array(
            'Item.item_class_id' => $this->request->data['Item']['item_class_id']
        );
        $options['fields'] = array(
            'ItemClass.keycode'
        );
        $items = $this->Item->find('all', $options);

        if ($items) {

            $sum = count($items);

            if ($sum < 10) {
                $keycode = $items[0]['ItemClass']['keycode'] . '-0' . ($sum + 1);
            } else {
                $keycode = $items[0]['ItemClass']['keycode'] . '-' . ($sum + 1);
            }
        } else {
            $this->ItemClass->recursive = -1;
            $itemClass = $this->ItemClass->read(null, $item_class_id);

            $keycode = $itemClass['ItemClass']['keycode'] . '-01';
        }

        return $keycode;
    }

}