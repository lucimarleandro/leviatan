<?php

App::uses('AppController', 'Controller');

/**
 * PngcCodes Controller
 *
 * @property PngcCode $PngcCode
 */
class PngcCodesController extends AppController {

    public $uses = array('PngcCode', 'ExpenseGroup', 'MeasureType', 'Input', 'InputCategory', 'InputSubcategory');

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

        $this->PngcCode->recursive = -1;
        $options['joins'] = array(
            array(
                'table' => 'measure_types',
                'alias' => 'MeasureType',
                'type' => 'Inner',
                'conditions' => array(
                    'MeasureType.id = PngcCode.measure_type_id'
                )
            ),
            array(
                'table' => 'expense_groups',
                'alias' => 'ExpenseGroup',
                'type' => 'Inner',
                'conditions' => array(
                    'ExpenseGroup.id = PngcCode.expense_group_id'
                )
            ),
            array(
                'table' => 'inputs',
                'alias' => 'Input',
                'type' => 'Inner',
                'conditions' => array(
                    'Input.id = PngcCode.input_id'
                )
            ),
            array(
                'table' => 'input_categories',
                'alias' => 'InputCategory',
                'type' => 'Inner',
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
        $options['limit'] = 10;
        $options['order'] = array(
            'PngcCode.keycode' => 'asc',
        );
        $options['fields'] = array(
            'PngcCode.id', 'PngcCode.keycode',
            'MeasureType.id', 'MeasureType.name',
            'ExpenseGroup.id', 'ExpenseGroup.name',
            'InputCategory.id', 'InputCategory.name',
            'InputSubcategory.id', 'InputSubcategory.name'
        );

        $this->paginate = $options;
        $pngcs = $this->paginate();

        $this->set(compact('pngcs'));
    }

/**
 *
 * @param unknown_type $id
 */
    public function view($id = null) {
        $this->PngcCode->id = $id;
        $this->PngcCode->recursive = 2;

        if (!$this->PngcCode->exists()) {
            $this->Session->setFlash(__('Registro inválido'), 'default', array('class' => 'alert alert-error'));
            $this->redirect(array('action' => 'index'));
        }

        $this->PngcCode->recursive = -1;
        $options['joins'] = array(
            array(
                'table' => 'measure_types',
                'alias' => 'MeasureType',
                'type' => 'Inner',
                'conditions' => array(
                    'MeasureType.id = PngcCode.measure_type_id'
                )
            ),
            array(
                'table' => 'expense_groups',
                'alias' => 'ExpenseGroup',
                'type' => 'Inner',
                'conditions' => array(
                    'ExpenseGroup.id = PngcCode.expense_group_id'
                )
            ),
            array(
                'table' => 'inputs',
                'alias' => 'Input',
                'type' => 'Inner',
                'conditions' => array(
                    'Input.id = PngcCode.input_id'
                )
            ),
            array(
                'table' => 'input_categories',
                'alias' => 'InputCategory',
                'type' => 'Inner',
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
        $options['conditions'] = array(
            'PngcCode.id' => $id
        );
        $options['fields'] = array(
            'PngcCode.id', 'PngcCode.keycode',
            'MeasureType.id', 'MeasureType.name',
            'ExpenseGroup.id', 'ExpenseGroup.name',
            'InputCategory.id', 'InputCategory.name',
            'InputSubcategory.id', 'InputSubcategory.name'
        );

        $pngcCode = $this->PngcCode->find('first', $options);

        $this->set(compact('pngcCode'));
    }

/**
 * 
 */
    public function add() {
        if ($this->request->is('POST')) {
            $this->Input->recursive = -1;
            $options['conditions'] = array(
                'Input.input_category_id' => $this->request->data['PngcCode']['input_category_id'],
                'Input.input_subcategory_id' => $this->request->data['PngcCode']['input_subcategory_id']
            );
            $options['fields'] = array('Input.id');
            $input = $this->Input->find('first', $options);
            $this->request->data['PngcCode']['input_id'] = $input['Input']['id'];

            if ($this->PngcCode->save($this->request->data)) {
                $this->Session->setFlash(__('cadastrado com sucesso'), 'default', array('class' => 'alert alert-success'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('Não foi possível Cadastrar'), 'default', array('class' => 'alert alert-error'));
            }
        }

        $inicio = array('' => 'Selecione um item');
        $expenseGroups = $inicio + $this->ExpenseGroup->find('list', array('order' => array('ExpenseGroup.name' => 'asc')));
        $inputCategories = $inicio + $this->InputCategory->find('list', array('order' => array('InputCategory.name' => 'asc')));
        $measureTypes = $inicio + $this->MeasureType->find('list', array('order' => array('MeasureType.name' => 'asc')));

        $this->set(compact('expenseGroups', 'inputCategories', 'measureTypes'));
    }

/**
 *
 * @param unknown_type $id
 */
    public function delete($id = null) {
        $this->PngcCode->id = $id;
        if ($this->request->is('GET')) {
            $this->Session->setFlash(__('Requisição inválida'), 'default', array('class' => 'alert alert-error'));
            $this->redirect(array('action' => 'index'));
        }
        if (!$this->PngcCode->exists()) {
            $this->Session->setFlash(__('Registro inválido'), 'default', array('class' => 'alert alert-error'));
            $this->redirect(array('action' => 'index'));
        }

        if ($this->PngcCode->delete()) {
            $this->Session->setFlash(__('Deletado com sucesso'), 'default', array('class' => 'alert alert-success'));
        } else {
            $this->Session->setFlash(__('Não foi possível deletar'), 'default', array('class' => 'alert alert-error'));
        }

        $this->redirect(array('action' => 'index'));
    }

}
