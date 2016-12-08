<?php
App::uses('AppModel', 'Model');
/**
 * State Model
 *
 * @property City $City
 */
class State extends AppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'name' => array(
			'simplechars' => array(
				'rule'    => '/^[A-Za-zÀ-ú0-9-\(\)\ \_]*$/i',
				'message' => 'Only letters, accentuation, numbers, underline "_", space " ", parentheses "( )" and hyphen "-"',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'minLength'   => array(
				'rule'	  => array('minLength', 2),
				'message' => 'At least 2 characters',
			),
			'isUnique' => array(
				'rule' => array('isUnique'),
				'message' => 'This name is already in use',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'initials' => array(
			'alphaNumeric'   => array(
				'rule'	  => array('alphaNumeric'),
				'message' => 'Letters and numbers only',
			),
			'lengthBetween'   => array(
				'rule'	  => array('lengthBetween', 2, 2),
				'message' => 'Must have 2 characters',
			),
			'isUnique' => array(
				'rule' => array('isUnique'),
				'message' => 'This initial is already in use',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	// The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'City' => array(
			'className' => 'City',
			'foreignKey' => 'state_id',
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
