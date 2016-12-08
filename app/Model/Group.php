<?php
App::uses('AppModel', 'Model');
/**
 * Group Model
 *
 * @property User $User
 */
class Group extends AppModel {
	public $actsAs = array('Acl' => array('type' => 'requester'));

    public function parentNode() {
        return null;
    }

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
		'description' => array(
			// 'simplechars' => array(
			// 	'rule'    => '/^[A-Za-zÀ-ú0-9-\(\)\ \_]*$/i',
			// 	'message' => 'Only simple characters, numbers, underline "_", space " ", parentheses "( )" and hyphen "-"',
			// 	'allowEmpty' => true,
			// 	'required' => false,
			// 	//'last' => false, // Stop validation after this rule
			// 	//'on' => 'create', // Limit validation to 'create' or 'update' operations
			// ),
		),
	);

	// The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'group_id',
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
