<?php
App::uses('AppModel', 'Model');
/**
 * Discipline Model
 *
 * @property Course $Course
 * @property Team $Team
 */
class Discipline extends AppModel {

	public function beforeValidate($options = array()){
		parent::beforeValidate($options);

		$this->validate['course_id']['allowedChoice']['rule'][1] = array_keys($this->Course->find('list'));
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
		'academic_period' => array(
			'naturalNumber' => array(
				'rule' => array('naturalNumber'),
				'message' => 'Only natural numbers (greater than zero)',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'course_id' => array(
			'allowedChoice' => array(
				'rule' => array('inList', array()),
				'message' => 'Choose one of the options',
				'allowEmpty' => false,
				// 'required' => true,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	// The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */

 public $hasMany = array(
 	'Visit' => array(
 		'className' => 'Visit',
 		'foreignKey' => 'discipline_id',
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

	public $belongsTo = array(
		'Course' => array(
			'className' => 'Course',
			'foreignKey' => 'course_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

/**
 * hasAndBelongsToMany associations
 *
 * @var array
 */
	public $hasAndBelongsToMany = array(
		'Team' => array(
			'className' => 'Team',
			'joinTable' => 'disciplines_teams',
			'foreignKey' => 'discipline_id',
			'associationForeignKey' => 'team_id',
			'unique' => 'keepExisting',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
		)
	);

}
