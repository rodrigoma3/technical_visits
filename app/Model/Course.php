<?php
App::uses('AppModel', 'Model');
/**
 * Course Model
 *
 * @property Discipline $Discipline
 */
class Course extends AppModel {

	private $enum = array(
		'type_of_academic_period' => array(
			0 => 'Yearly',
			1 => 'Semiannual',
		),
	);

	public function getEnums($options = null) {
		$r = array();
		if (is_null($options)) {
			foreach ($this->enum as $field => $value) {
				$r[$field] = $this->__translate($value);
			}
		} elseif (is_array($options)) {
			foreach ($options as $option) {
				if (array_key_exists($option, $this->enum)) {
					$r[$option] = $this->__translate($this->enum[$option]);
				}
			}
		} elseif (array_key_exists($options, $this->enum)) {
			$r = $this->__translate($this->enum[$options]);
		}
		return $r;
	}

	public function afterFind($results, $primary = false) {
	    foreach ($results as $key => $val) {
			if (!is_null($val)) {
				if ($key === 'prev' || $key === 'next') {
					if (isset($val[$this->name])) {
						foreach (array_keys($this->enum) as $field) {
							if (isset($val[$this->name][$field])) {
								$results[$key][Inflector::camelize($field)]['id'] = $val[$this->name][$field];
								$results[$key][Inflector::camelize($field)]['name'] = __($this->enum[$field][$val[$this->name][$field]]);
							}
						}
					}
				} elseif ($key === $this->name) {
					foreach (array_keys($this->enum) as $field) {
						if (isset($val[$field])) {
							$results[Inflector::camelize($field)]['id'] = $val[$field];
							$results[Inflector::camelize($field)]['name'] = __($this->enum[$field][$val[$field]]);
						}
					}
				} elseif (array_key_exists($this->name, $val)) {
					foreach (array_keys($this->enum) as $field) {
						if (isset($val[$this->name][$field])) {
							$results[$key][Inflector::camelize($field)]['id'] = $val[$this->name][$field];
							$results[$key][Inflector::camelize($field)]['name'] = __($this->enum[$field][$val[$this->name][$field]]);
						}
					}
				}
				if (array_key_exists('children', $val)) {
					foreach ($val['children'] as $c => $child) {
						if (array_key_exists($this->name, $child)) {
							foreach (array_keys($this->enum) as $field) {
								if (isset($child[$this->name][$field])) {
									$results[$key]['children'][$c][Inflector::camelize($field)]['id'] = $child[$this->name][$field];
									$results[$key]['children'][$c][Inflector::camelize($field)]['name'] = __($this->enum[$field][$child[$this->name][$field]]);
								}
							}
						}
					}
				}
			}
	    }
	    return $results;
	}

	private function __translate($values = array()){
		$return = array();
		foreach($values as $key => $value){
			$return[$key] = __($value);
		}
		return $return;
	}

	public function beforeValidate($options = array()){
		parent::beforeValidate($options);

		$this->validate['type_of_academic_period']['allowedChoice']['rule'][1] = array_keys($this->getEnums('type_of_academic_period'));
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
		'type_of_academic_period' => array(
			'allowedChoice' => array(
				'rule' => array('inList', array()),
				'message' => 'Choose one of the options',
				'allowEmpty' => false,
				// 'required' => true,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'amount_of_academic_periods' => array(
			'naturalNumber' => array(
				'rule' => array('naturalNumber'),
				'message' => 'Only natural numbers (greater than zero)',
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
		'Discipline' => array(
			'className' => 'Discipline',
			'foreignKey' => 'course_id',
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
