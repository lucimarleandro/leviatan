<?php

App::uses('AppController', 'Controller');

/**
 * Employees Controller
 *
 * @property Employee $Employee
 */
class EmployeesController extends AppController {

    public $uses = array('Employee', 'UnitySector', 'Unity', 'Sector', 'User');
    public $helpers = array('Time');

/**
 * index method
 *
 * @return void
 */
    public function index() {
        $this->Employee->recursive = 0;

        $options['order'] = array('Employee.name' => 'asc');
        $options['limit'] = 10;

        $this->paginate = $options;

        $this->set('employees', $this->paginate());
    }

/**
 * 
 * @param unknown_type $id
 */
    public function view($id = null) {
        $this->Employee->id = $id;

        if (!$this->Employee->exists()) {
            $this->Session->setFlash(__('Registro inválido'), 'default', array('class' => 'alert alert-error'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Employee->recursive = -1;

        $options['joins'] = array(
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
        $options['conditions'] = array(
            'Employee.id' => $id
        );
        $options['fields'] = array(
            'Employee.*', 'Unity.name', 'Sector.name'
        );

        $employee = $this->Employee->find('first', $options);
        $this->set(compact('employee'));
    }

/**
 * add method
 *
 * @return void
 */
    public function add() {
        if ($this->request->is('post')) {

            $this->UnitySector->recursive = -1;

            $options['conditions'] = array(
                'UnitySector.unity_id' => $this->request->data['Employee']['unity_id'],
                'UnitySector.sector_id' => $this->request->data['Employee']['sector_id']
            );
            $options['fields'] = array('UnitySector.id');

            $unitySector = $this->UnitySector->find('first', $options);
            $this->request->data['Employee']['unity_sector_id'] = $unitySector['UnitySector']['id'];

            $this->Employee->create();
            if ($this->Employee->save($this->request->data)) {
                $this->Session->setFlash(__('Adicionado com sucesso'), 'default', array('class' => 'alert alert-success'));
            } else {
                $this->Session->setFlash(__('Não foi possível adicionar'), 'default', array('class' => 'alert alert-error'));
            }
            $this->redirect(array('action' => 'index'));
        }

        $inicial = array('' => __('Selecione um item'));
        $unities = $this->__getUnities();
        $unities = $inicial + $unities;

        $this->set(compact('unities'));
    }

/**
 * 
 * @param unknown_type $id
 */
    public function edit($id = null) {
        $this->Employee->id = $id;
        if ($this->request->is('POST') || $this->request->is('PUT')) {
            $this->UnitySector->recursive = -1;

            $options['conditions'] = array(
                'UnitySector.unity_id' => $this->request->data['Employee']['unity_id'],
                'UnitySector.sector_id' => $this->request->data['Employee']['sector_id']
            );
            $options['fields'] = array('UnitySector.id');

            $unitySector = $this->UnitySector->find('first', $options);
            $this->request->data['Employee']['unity_sector_id'] = $unitySector['UnitySector']['id'];

            $this->Employee->begin();
            $this->User->begin();

            try {
                if ($this->Employee->save($this->request->data)) {
                    $op['conditions'] = array(
                        'User.employee_id' => $this->Employee->id
                    );
                    $this->User->recursive = -1;
                    $user = $this->User->find('first', $op);
                    if ($user) {
                        $this->User->id = $user['User']['id'];
                        if (!$this->User->saveField('username', $this->request->data['Employee']['registration'])) {
                            throw new Exception('Erro foi possível alterar o registro');
                        } else {
                            $this->User->commit();
                        }
                    }
                } else {
                    throw new Exception('Não foi possível alterar o registro');
                }
            } catch (Exception $e) {
                $this->User->rollback();
                $this->Employee->rollback();
                $this->Session->setFlash($e->getMessage(), 'default', array('class' => 'alert alert-error'));
                $this->redirect(array('action' => 'index'));
            }

            $this->Employee->commit();
            $this->Session->setFlash(__('Alterado com sucesso'), 'default', array('class' => 'alert alert-success'));
            $this->redirect(array('action' => 'index'));
        }
        $this->request->data = $this->Employee->read();

        $inicial = array('' => __('Selecione um item'));
        $unities = $inicial + $this->__getUnities();
        $sectors = $inicial + $this->__getSectors($this->request->data['UnitySector']['unity_id']);

        $this->set(compact('unities', 'sectors'));
    }

/**
 * 
 */
    public function delete($id = null) {
        $this->Employee->id = $id;
        if ($this->request->is('GET')) {
            $this->Session->setFlash(__('Requisição inválida'), 'default', array('class' => 'alert alert-error'));
            $this->redirect(array('action' => 'index'));
        }
        if (!$this->Employee->exists()) {
            $this->Session->setFlash(__('Registro inválido'), 'default', array('class' => 'alert alert-error'));
            $this->redirect(array('action' => 'index'));
        }

        if ($this->Employee->delete()) {
            $this->Session->setFlash(__('Deletado com sucesso'), 'default', array('class' => 'alert alert-success'));
        } else {
            $this->Session->setFlash(__('Não foi possível deletar'), 'default', array('class' => 'alert alert-error'));
        }

        $this->redirect(array('action' => 'index'));
    }

/**
 * 
 */
    private function __getUnities() {

        $this->Unity->recursive = -1;
        $options['joins'] = array(
            array(
                'table' => 'unity_sectors',
                'alias' => 'UnitySector',
                'type' => 'INNER',
                'conditions' => array(
                    'UnitySector.unity_id = Unity.id'
                )
            )
        );

        $unities = $this->Unity->find('list', $options);

        return $unities;
    }

/**
 * 
 * @param unknown_type $unity_id
 */
    private function __getSectors($unity_id = null) {
        $this->Sector->recursive = -1;
        $options['joins'] = array(
            array(
                'table' => 'unity_sectors',
                'alias' => 'UnitySector',
                'type' => 'INNER',
                'conditions' => array(
                    'UnitySector.sector_id = Sector.id'
                )
            )
        );
        $options['conditions'] = array(
            'UnitySector.unity_id' => $unity_id
        );

        $sectors = $this->Sector->find('list', $options);

        return $sectors;
    }

}
