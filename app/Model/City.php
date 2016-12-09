<?php
App::uses('AppModel', 'Model');
/**
 * City Model
 *
 * @property State $State
 * @property Visit $Visit
 */
class City extends AppModel {

	public function beforeValidate($options = array()){
		parent::beforeValidate($options);

		$this->validate['state_id']['allowedChoice']['rule'][1] = array_keys($this->State->find('list'));
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
		),
		'short_distance' => array(
			'boolean' => array(
				'rule' => array('boolean'),
				'message' => 'Boolean options only',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'state_id' => array(
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

	public function superlist() {
		$options = array(
			'fields' => array(
				$this->alias.'.id',
				$this->alias.'.name',
				$this->State->alias.'.name',
				$this->State->alias.'.initials',
			),
			'recursive' => 0,
			'order' => array($this->State->alias.'.name' => 'asc'),
		);
		$res = $this->find('all', $options);
		$citiesPerState = array();
		foreach ($res as $r) {
			$state = $r[$this->State->alias]['name'].' - '.$r[$this->State->alias]['initials'];
			$citiesPerState[$state][$r[$this->alias]['id']] = $r[$this->alias]['name'];
		}
		return $citiesPerState;
    }

	// The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'State' => array(
			'className' => 'State',
			'foreignKey' => 'state_id',
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
		'Visit' => array(
			'className' => 'Visit',
			'foreignKey' => 'city_id',
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
