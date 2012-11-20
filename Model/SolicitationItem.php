<?php
App::uses('AppModel', 'Model');
/**
 * SolicitationItem Model
 *
 * @property Solicitation $Solicitation
 * @property Item $Item
 * @property Status $Status
 * @property Justification $Justification
 * @property OrderItem $OrderItem
 */
class SolicitationItem extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Solicitation' => array(
			'className' => 'Solicitation',
			'foreignKey' => 'solicitation_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Item' => array(
			'className' => 'Item',
			'foreignKey' => 'item_id',
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

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Justification' => array(
			'className' => 'Justification',
			'foreignKey' => 'solicitation_item_id',
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
		'OrderItem' => array(
			'className' => 'OrderItem',
			'foreignKey' => 'solicitation_item_id',
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
