<?php

App::uses('AppModel', 'Model');

/**
 * Employee Model
 *
 * @property UnitySector $UnitySector
 * @property User $User
 */
class Employee extends AppModel {

/**
 * Display field
 *
 * @var string
 */
    public $displayField = 'name';
    public $virtualFields = array(
        'fullname' => 'CONCAT(Employee.name, " ", Employee.surname)'
    );


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
        )
    );

/**
 * hasMany associations
 *
 * @var array
 */
    public $hasMany = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'employee_id',
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
 * (non-PHPdoc)
 * @see lib/Cake/Model/Model::beforeSave()
*/
    public function beforeSave($options = array()) {
        if (isset($this->data['Employee']['birth_date'])) {
            $this->data['Employee']['birth_date'] = preg_replace('/^([0-9]{2}).([0-9]{2}).([0-9]{4})$/', '\3-\2-\1', $this->data['Employee']['birth_date']);
        }
        $this->data['Employee']['phone'] = preg_replace('/[^0-9]/', "", $this->data['Employee']['phone']);
        return true;
    }

}
