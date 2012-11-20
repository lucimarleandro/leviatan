<?php

App::uses('AppModel', 'Model');

/**
 * Item Model
 *
 * @property ItemClass $ItemClass
 * @property PngcCode $PngcCode
 * @property Status $Status
 */
class Item extends AppModel {

/**
 * Display field
 *
 * @var string
 */
    public $displayField = 'name';

//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
    public $belongsTo = array(
        'ItemClass' => array(
            'className' => 'ItemClass',
            'foreignKey' => 'item_class_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'PngcCode' => array(
            'className' => 'PngcCode',
            'foreignKey' => 'pngc_code_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'Status' => array(
            'className' => 'Status',
            'foreignKey' => 'status_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );
  
    public $validate = array(
        'item_class_id' => array(
            'rule1' => array(
                'rule' => 'notEmpty',
                'message' => 'Campo obrigatório'
            )
        ),
        'pngc_code_id' => array(
            'rule1' => array(
                'rule' => 'notEmpty',
                'message' => 'Campo obrigatório'
            )
        ),
        'keycode' => array(
            'rule1' => array(
                'rule' => 'notEmpty',
                'message' => 'Campo obrigatório'
            )
        ),
        'name' => array(
            'rule1' => array(
                'rule' => 'notEmpty',
                'message' => 'Campo obrigatório'
            )
        ),
        'description' => array(
            'rule1' => array(
                'rule' => 'notEmpty',
                'message' => 'Campo obrigatório'
            )
        ),
        'specification' => array(
            'rule1' => array(
                'rule' => 'notEmpty',
                'message' => 'Campo obrigatório'
            )
        )
    );

}
