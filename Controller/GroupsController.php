<?php

App::uses('AppController', 'Controller');

/**
 * Groups Controller
 *
 * @property Group $Group
 */
class GroupsController extends AppController {

/**
 * 
 * Enter description here ...
 */
    public function add() {
        if ($this->request->is('POST')) {
            if ($this->Group->save($this->request->data)) {
                $this->Session->setFlash(__('Cadastrado com sucesso'), 'default', array('class' => 'alert alert-success'));
            } else {
                $this->Session->setFlash(__('Não foi possível cadastrar'), 'default', array('class' => 'alert alert-error'));
            }
            $this->redirect(array('action' => 'add'));
        }
    }

}
