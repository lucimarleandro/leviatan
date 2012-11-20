<?php

App::uses('AppController', 'Controller');

/**
 * InputSubcategories Controller
 *
 * @property InputSubcategory $InputSubcategory
 */
class InputSubcategoriesController extends AppController {

    public $uses = array('InputSubcategory', 'Input');

/**
 * (non-PHPdoc)
 * @see AppController::beforeFilter()
 */
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow(array('view'));
    }

/**
 *
 */
    public function index() {
        $this->InputSubcategory->recursive = -1;
        $options['limit'] = 10;
        $options['order'] = array('InputSubcategory.name' => 'asc');

        $this->paginate = $options;
        $subcategories = $this->paginate();

        $this->set(compact('subcategories'));
    }

/**
 *
 * @param unknown_type $id
 */
    public function view($id = null) {
        $this->InputSubcategory->id = $id;
        $this->InputSubcategory->recursive = -1;

        if (!$this->InputSubcategory->exists()) {
            $this->Session->setFlash(__('Registro inválido'), 'default', array('class' => 'alert alert-error'));
            $this->redirect(array('action' => 'index'));
        }

        $subcategory = $this->InputSubcategory->read();

        $this->set(compact('subcategory'));
    }

/**
 *
 */
    public function add() {
        if ($this->request->is('POST')) {
            if ($this->InputSubcategory->save($this->request->data)) {
                $this->Session->setFlash(__('Adicionado com sucesso'), 'default', array('class' => 'alert alert-success'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('Não foi possível adicionar'), 'default', array('class' => 'alert alert-error'));
            }
        }
    }

/**
 *
 * @param unknown_type $id
 */
    public function edit($id = null) {
        $this->InputSubcategory->id = $id;
        if ($this->request->is('POST') || $this->request->is('PUT')) {
            if ($this->InputSubcategory->save($this->request->data)) {
                $this->Session->setFlash(__('Editado com sucesso'), 'default', array('class' => 'alert alert-success'));
            } else {
                $this->Session->setFlash(__('Não foi possível editar'), 'default', array('class' => 'alert alert-error'));
            }
            $this->redirect(array('action' => 'index'));
        }
        $this->request->data = $this->InputSubcategory->read();
    }

/**
 *
 * @param unknown_type $id
 */
    public function delete($id = null) {
        $this->InputSubcategory->id = $id;
        if ($this->request->is('GET')) {
            $this->Session->setFlash(__('Requisição inválida'), 'default', array('class' => 'alert alert-error'));
            $this->redirect(array('action' => 'index'));
        }
        if (!$this->InputSubcategory->exists()) {
            $this->Session->setFlash(__('Registro inválido'), 'default', array('class' => 'alert alert-error'));
            $this->redirect(array('action' => 'index'));
        }

        if ($this->InputSubcategory->delete()) {
            $this->Session->setFlash(__('Deletado com sucesso'), 'default', array('class' => 'alert alert-success'));
        } else {
            $this->Session->setFlash(__('Não foi possível deletar'), 'default', array('class' => 'alert alert-error'));
        }

        $this->redirect(array('action' => 'index'));
    }

/**
 * 
 * @param unknown_type $left
 */
    public function get_subcategories($left = false) {
        $this->autoRender = false;
        if ($this->request->is('AJAX')) {
            $category_id = $this->request->data['category_id'];

            $type = $left ? 'LEFT' : 'INNER';

            $this->Input->recursive = -1;
            $options['joins'] = array(
                array(
                    'table' => 'inputs',
                    'alias' => 'Input',
                    'type' => $type,
                    'conditions' => array(
                        'Input.input_subcategory_id = InputSubcategory.id',
                        'Input.input_category_id = ' . $category_id
                    )
                )
            );
            //Se eu quero os registros que não estão relacionados
            if ($left) {
                $options['conditions'] = array(
                    'Input.id is NULL'
                );
            }
            $options['fields'] = array(
                'InputSubcategory.id', 'InputSubcategory.name'
            );

            $subcategories = $this->InputSubcategory->find('list', $options);
            if (!empty($subcategories)) {
                $inicio = array('' => '- -');
            } else {
                $inicio = array('' => 'Não existe subcategorias ou todas já foram cadastrados');
            }

            $subcategories = $inicio + $subcategories;

            echo json_encode($subcategories);
        }
    }

}
