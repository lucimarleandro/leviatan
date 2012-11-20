<?php

App::uses('AppController', 'Controller');

/**
 * Inputs Controller
 *
 * @property Input $Input
 */
class InputsController extends AppController {

    public $uses = array('Input', 'InputCategory');

/**
 * 
 */
    public function index() {

        $this->Input->recursive = 0;
        $options['limit'] = 10;
        $options['order'] = array('InputCategory.name' => 'asc', 'InputSubcategory.name' => 'asc');

        $this->paginate = $options;
        $inputs = $this->paginate();

        $this->set(compact('inputs'));
    }

/**
 * 
 */
    public function add() {
        if ($this->request->is('POST')) {

            // Se o usuário selecionou a subcategoria nula e ela ja está cadastrada no banco,
            // então é retirada do array
            $exist = $this->Input->find('first', array('conditions' => array('Input.input_category_id' => $this->request->data['Input']['input_category_id'], 'Input.input_subcategory_id' => $this->request->data['Input']['input_subcategory_id'][0])));
            if ($exist) {
                unset($this->request->data['Input']['input_subcategory_id'][0]);
            }

            foreach ($this->request->data['Input']['input_subcategory_id'] as $key => $subcategory):
                $data[$key]['Input']['input_category_id'] = $this->request->data['Input']['input_category_id'];
                $data[$key]['Input']['input_subcategory_id'] = $subcategory;
            endforeach;

            $this->Input->begin();
            if ($this->Input->saveMany($data)) {
                $this->Input->commit();
                $this->Session->setFlash(__('Cadastrado com sucesso'), 'default', array('class' => 'alert alert-success'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Input->rollback();
                $this->Session->setFlash(__('Não foi possível cadastrar'), 'default', array('class' => 'alert alert-error'));
            }
        }

        $categories = array('' => 'Selecione uma categoria') + $this->InputCategory->find('list', array('order' => array('InputCategory.name' => 'asc')));
        $this->set(compact('categories'));
    }

/**
 *
 * @param unknown_type $id
 */
    public function delete($id = null) {
        $this->Input->id = $id;
        if ($this->request->is('GET')) {
            $this->Session->setFlash(__('Requisição inválida'), 'default', array('class' => 'alert alert-error'));
            $this->redirect(array('action' => 'index'));
        }
        if (!$this->Input->exists()) {
            $this->Session->setFlash(__('Registro inválido'), 'default', array('class' => 'alert alert-error'));
            $this->redirect(array('action' => 'index'));
        }

        if ($this->Input->delete()) {
            $this->Session->setFlash(__('Deletado com sucesso'), 'default', array('class' => 'alert alert-success'));
        } else {
            $this->Session->setFlash(__('Não foi possível deletar'), 'default', array('class' => 'alert alert-error'));
        }

        $this->redirect(array('action' => 'index'));
    }

}
