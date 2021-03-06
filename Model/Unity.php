<?php

App::uses('AppModel', 'Model');

/**
 * Unity Model
 *
 * @property Address $Address
 * @property HealthDistrict $HealthDistrict
 * @property UnityType $UnityType
 * @property UnitySector $UnitySector
 */
class Unity extends AppModel {

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
        'Address' => array(
            'className' => 'Address',
            'foreignKey' => 'address_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'HealthDistrict' => array(
            'className' => 'HealthDistrict',
            'foreignKey' => 'health_district_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'UnityType' => array(
            'className' => 'UnityType',
            'foreignKey' => 'unity_type_id',
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
        'UnitySector' => array(
            'className' => 'UnitySector',
            'foreignKey' => 'unity_id',
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

}
