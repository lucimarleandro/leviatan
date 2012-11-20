<?php

App::uses('AppController', 'Controller');

/**
 * Users Controller
 *
 * @property User $User
 */
class UsersController extends AppController {

    public $uses = array('User', 'Group', 'Employee');
    public $helpers = array('Utils');

/**
 * (non-PHPdoc)
 * @see AppController::beforeFilter()
 */
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('login', 'logout', 'profile');
    }

/**
 *
 */
    public function index() {
        $this->User->recursive = 0;
        $options['order'] = array(
            'Group.name' => 'asc',
            'Employee.name' => 'asc'
        );
        $options['fields'] = array(
            'Employee.registration', 'Employee.name', 'Employee.surname',
            'User.id', 'Group.name'
        );
        $this->paginate = $options;
        $users = $this->paginate();

        $this->set(compact('users'));
    }

/**
 * 
 * @param unknown_type $id
 */
    public function view($id = null) {
        $this->User->recursive = 0;
        $this->User->id = $id;

        if (!$this->User->exists()) {
            $this->Session->setFlash(__('Registro inválido'), 'default', array('class' => 'alert alert-error'));
            $this->redirect(array('action' => 'index'));
        }

        $userC = $this->User->read();

        $this->set(compact('userC'));
    }

/**
 * 
 */
    public function add() {

        if ($this->request->is('POST')) {
            $this->Employee->recursive = -1;
            $options['conditions'] = array(
                'Employee.id' => $this->request->data['User']['employee_id']
            );
            $options['fields'] = array(
                'Employee.registration'
            );

            $username = $this->Employee->find('first', $options);
            $this->request->data['User']['username'] = $username['Employee']['registration'];
            $this->request->data['User']['password'] = '123456';

            $this->User->create();
            if ($this->User->save($this->request->data)) {
                $this->Session->setFlash(__('Adicionado com sucesso'), 'default', array('class' => 'alert alert-success'));
            } else {
                $this->Session->setFlash(__('Não foi possível adicionar.'), 'default', array('class' => 'alert alert-error'));
            }

            $this->redirect(array('action' => 'index'));
        }

        $inicio = array('' => 'Selecione um item');
        $groups = $inicio + $this->Group->find('list');
        $employees = $inicio + $this->__getEmployees();

        $this->set(compact('groups', 'employees'));
    }

/**
 * 
 * @param unknown_type $id
 */
    public function delete($id = null) {
        $this->User->id = $id;
        if ($this->request->is('GET')) {
            $this->Session->setFlash(__('Requisição inválida'), 'default', array('class' => 'alert alert-error'));
            $this->redirect(array('action' => 'index'));
        }
        if (!$this->User->exists()) {
            $this->Session->setFlash(__('Registro inválido'), 'default', array('class' => 'alert alert-error'));
            $this->redirect(array('action' => 'index'));
        }

        if ($this->User->delete()) {
            $this->Session->setFlash(__('Deletado com sucesso'), 'default', array('class' => 'alert alert-success'));
        } else {
            $this->Session->setFlash(__('Não foi possível deletar.'), 'default', array('class' => 'alert alert-error'));
        }

        $this->redirect(array('action' => 'index'));
    }

/**
 * 
 */
    public function profile($user_id = null) {

        $this->User->id = $user_id;
        if (!$this->request->is('POST')) {
            $this->Session->setFLash(__('Requisição inválida'), 'default', array('class' => 'alert alert-error'));
            $this->redirect(array('controller' => 'items', 'action' => 'home'));
        }

        if ($this->Auth->user('id') != $user_id) {
            $this->Session->setFLash(__('Você não pode editar o perfil de outro usuário'), 'default', array('class' => 'alert alert-error'));
            $this->redirect(array('controller' => 'items', 'action' => 'home'));
        }

        if ($this->request->data) {

            $this->User->id = $this->request->data['User']['user_id'];
            $this->Employee->id = $this->request->data['User']['employee_id'];

            if (!empty($this->request->data['User']['new_password'])) {
                $this->User->begin();
                if (!$this->User->saveField('password', $this->request->data['User']['new_password'])) {
                    $this->Session->setFlash(__('Não foi possível alterar os dados. Favor entrar em contato com o administrador do sistema'), 'default', array('class' => 'alert alert-error'));
                    $this->redirect(array('controller' => 'items', 'action' => 'home'));
                }
            }

            $data['Employee']['birth_date'] = $this->request->data['User']['birth_date'];
            $data['Employee']['phone'] = $this->request->data['User']['phone'];
            $data['Employee']['email'] = $this->request->data['User']['email'];

            $this->Employee->begin();
            if (!$this->Employee->save($data)) {
                $this->User->rollback();
                $this->Employee->rollback();
                $this->Session->setFlash(__('Não foi possível alterar os dados. Favor entrar em contato com o administrador do sistema'), 'default', array('class' => 'alert alert-error'));
                $this->redirect(array('controller' => 'items', 'action' => 'home'));
            }

            $this->User->commit();
            $this->Employee->commit();

            $this->Session->setFlash(__('Alterado com sucesso'), 'default', array('class' => 'alert alert-success'));
            $this->redirect(array('controller' => 'items', 'action' => 'home'));
        }

        $profile = $this->User->read();
        $this->set(compact('profile'));
    }

/**
 *
 * Enter description here ...
 */
    public function login() {
        $this->autoRender = false;
        if ($this->request->is('post')) {
            if ($this->Auth->login()) {
                $this->redirect($this->Auth->redirect());
            } else {
                $this->Session->setFlash(__('Usuário ou senha incorretos.'), 'default', array('class' => 'alert alert-error'));
                $this->redirect($this->referer());
            }
        }
    }

/**
 *
 * Enter description here ...
 */
    public function logout() {
        // Destruindo a sessão
        if ($this->Session->valid()) {
            $this->Session->destroy();
            $this->Session->setFlash(__('Adeus'), 'default', array('class' => 'alert alert-success'));
            $this->redirect('/');
        }
    }

/**
 * Seleciona os funcionários que ainda não estão na tabela de usuários
 */
    private function __getEmployees() {
        $this->Employee->recursive = -1;

        $options['joins'] = array(
            array(
                'table' => 'users',
                'alias' => 'User',
                'type' => 'LEFT',
                'conditions' => array(
                    'Employee.id = User.employee_id'
                )
            )
        );
        $options['conditions'] = array(
            'User.employee_id is null'
        );
        $options['fields'] = array(
            'Employee.id', 'Employee.fullname'
        );

        $employees = $this->Employee->find('list', $options);

        return $employees;
    }

}
