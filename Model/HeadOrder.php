<?php

App::uses('AppModel', 'Model');

/**
 * HeadOrder Model
 *
 * @property UnitySector $UnitySector
 * @property ItemClass $ItemClass
 */

class HeadOrder extends AppModel {
//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
    public $belongsTo = array(
        'UnitySector' => array(
            'className' => 'UnitySector',
            'foreignKey' => 'unity_sector_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'ItemClass' => array(
            'className' => 'ItemClass',
            'foreignKey' => 'item_class_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );

}
