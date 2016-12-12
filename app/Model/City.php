<?php
App::uses('AppModel', 'Model');
/**
 * City Model
 *
 * @property State $State
 * @property Visit $Visit
 */
class City extends AppModel {

	private $enum = array(
		'short_distance' => array(
			0 => 'No',
			1 => 'Yes',
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
