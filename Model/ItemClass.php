<?php

App::uses('AppModel', 'Model');

/**
 * ItemClass Model
 *
 * @property ItemGroup $ItemGroup
 * @property Item $Item
 */
class ItemClass extends AppModel {

/**
 * Display field
 *
 * @var string
 */
    public $displayField = 'name';
    public $virtualFields = array('keycode-name' => 'CONCAT(ItemClass.keycode, " - ", ItemClass.name)');


//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
    public $belongsTo = array(
        'ItemGroup' => array(
            'className' => 'ItemGroup',
            'foreignKey' => 'item_group_id',
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
        'Item' => array(
            'className' => 'Item',
            'foreignKey' => 'item_class_id',
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
 * @var unknown_type
 */
    public $validate = array(
        'keycode' => array(
            'rule' => 'isUnique',
            'message' => 'Este código já está cadastrado'
        )
    );

}
