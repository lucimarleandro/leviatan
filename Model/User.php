<?php

App::uses('AppModel', 'Model');

/**
 * User Model
 *
 * @property Employee $Employee
 * @property Group $Group
 * @property CartItem $CartItem
 * @property Solicitation $Solicitation
 */
class User extends AppModel {
    
//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
    public $belongsTo = array(
        'Employee' => array(
            'className' => 'Employee',
            'foreignKey' => 'employee_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'Group' => array(
            'className' => 'Group',
            'foreignKey' => 'group_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );

/**
 * hasMany associations
 *
 * @var array
 */
    public $hasMany = array(
        'CartItem' => array(
            'className' => 'CartItem',
            'foreignKey' => 'user_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'Solicitation' => array(
            'className' => 'Solicitation',
            'foreignKey' => 'user_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        )
    );
   
/**
 *
 * @var type 
 */
    public $actsAs = array('Acl' => array('type' => 'requester'));

/**
 * 
 * Enter description here ...
 * @param unknown_type $user
 */
    public function bindNode($user) {
        return array('model' => 'Group', 'foreign_key' => $user['User']['group_id']);
    }

/**
 * (non-PHPdoc)
 * @see lib/Cake/Model/Model::beforeSave()
 */
    public function beforeSave($options = array()) {
        $this->data['User']['password'] = AuthComponent::password($this->data['User']['password']);
        return true;
    }

/**
 *
 * Enter description here ...
 */
    public function parentNode() {
        if (!$this->id && empty($this->data)) {
            return null;
        }
        if (isset($this->data['User']['group_id'])) {
            $groupId = $this->data['User']['group_id'];
        } else {
            $groupId = $this->field('group_id');
        }
        if (!$groupId) {
            return null;
        } else {
            return array('Group' => array('id' => $groupId));
        }
    }

/**
 * Função chamada antes de deletar o registro
 * @see lib/Cake/Model/Model::beforeDelete()
 */
    public function beforeDelete($cascade = true) {
        $register = $this->read(null, $this->id);
        if (!empty($register['Solicitation']) || !empty($register['CartItem'])) {
            return false;
        }
    }

}
