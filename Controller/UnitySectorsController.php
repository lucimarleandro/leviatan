<?php

App::uses('AppController', 'Controller');

/**
 * UnitySectors Controller
 *
 * @property UnitySector $UnitySector
 */
class UnitySectorsController extends AppController {

    public $uses = array('UnitySector', 'Unity', 'Sector');

/**
 * (non-PHPdoc)
 * @see AppController::beforeFilter()
 */
    public function beforeFilter() {
        parent::beforeFilter();
    }

/**
 * 
 */
    public function index() {

        $this->UnitySector->recursive = 0;

        $options['limit'] = 10;
        $options['order'] = array('Unity.name' => 'asc', 'Sector.name' => 'asc');
        $options['fields'] = array('Unity.name', 'Sector.name', 'UnitySector.id');

        $this->paginate = $options;
        $unitySectors = $this->paginate();

        $this->set(compact('unitySectors'));
    }

/**
 * 
 */
    public function add() {

        if ($this->request->is('POST')) {

            // Se o usuário selecionou a subcategoria nula e ela ja está cadastrada no banco,
            // então é retirada do array
            $exist = $this->UnitySector->find('first', array('conditions' => array('UnitySector.unity_id' => $this->request->data['UnitySector']['unity_id'], 'UnitySector.sector_id' => $this->request->data['UnitySector']['sector_id'][0])));
            if ($exist) {
                unset($this->request->data['UnitySector']['sector_id'][0]);
            }

            foreach ($this->request->data['UnitySector']['sector_id'] as $key => $sector):
                $data[$key]['UnitySector']['unity_id'] = $this->request->data['UnitySector']['unity_id'];
                $data[$key]['UnitySector']['sector_id'] = $sector;
            endforeach;

            $this->UnitySector->begin();
            if ($this->UnitySector->saveMany($data)) {
                $this->UnitySector->commit();
                $this->Session->setFlash(__('Cadastrado com sucesso'), 'default', array('class' => 'alert alert-success'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->UnitySector->rollback();
                $this->Session->setFlash(__('Não foi possível cadastrar'), 'default', array('class' => 'alert alert-error'));
            }

            $this->redirect(array('action' => 'index'));
        }

        $options['fields'] = array(
            'Unity.id', 'Unity.name'
        );
        $unities = array('' => 'Selecione um item') + $this->Unity->find('list');

        $this->set(compact('unities'));
    }
    
/**
 * 
 * @param type $id
 */
    public function delete($id = null) {

        $this->UnitySector->id = $id;
        if ($this->request->is('GET')) {
            $this->Session->setFlash(__('Requisição inválida'), 'default', array('class' => 'alert alert-error'));
            $this->redirect(array('action' => 'index'));
        }
        if (!$this->UnitySector->exists()) {
            $this->Session->setFlash(__('Registro inválido'), 'default', array('class' => 'alert alert-error'));
            $this->redirect(array('action' => 'index'));
        }

        if ($this->UnitySector->delete()) {
            $this->Session->setFlash(__('Deletado com sucesso'), 'default', array('class' => 'alert alert-success'));
        } else {
            $this->Session->setFlash(__('Não foi possível deletar'), 'default', array('class' => 'alert alert-error'));
        }

        $this->redirect(array('action' => 'index'));
    }

}
