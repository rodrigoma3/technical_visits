<?php
App::uses('AppModel', 'Model');
App::uses('File', 'Utility');
App::uses('Folder', 'Utility');
/**
 * Visit Model
 *
 * @property User $User
 * @property City $City
 * @property Team $Team
 * @property Refusal $Refusal
 */
class Visit extends AppModel {

	private $enum = array(
		'transport' => array(
			0 => 'Undefined',
			1 => 'Own',
			2 => 'Campus',
			3 => 'Outsourced',
		),
		'status' => array(
			0 => 'Open',
			// 1 => 'Changes done',
			1 => 'Awaiting transport',
			2 => 'Waiting for approval',
			3 => 'Awaiting realization',
			4 => 'Awaiting report, information update and transport update',
			5 => 'Awaiting report',
			6 => 'Waiting for report evaluation and transport update',
			7 => 'Waiting for report evaluation',
			8 => 'Waiting for transport update',
			9 => 'Completed',
			10 => 'Canceled',
			11 => 'Disapproved visit',
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

		$this->validate['transport']['allowedChoice']['rule'][1] = array_keys($this->getEnums('transport'));
		$this->validate['status']['allowedChoice']['rule'][1] = array_keys($this->getEnums('status'));
		$this->validate['user_id']['allowedChoice']['rule'][1] = array_keys($this->User->find('list'));
		$this->validate['city_id']['allowedChoice']['rule'][1] = array_keys($this->City->find('list'));
		$this->validate['team_id']['allowedChoice']['rule'][1] = array_keys($this->Team->find('list'));
		$this->validate['discipline_id']['allowedChoice']['rule'][1] = array_keys($this->Discipline->find('list'));
	}

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'departure' => array(
			'datetime' => array(
				'rule' => array('datetime'),
				'message' => 'Invalid date',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'arrival' => array(
			'datetime' => array(
				'rule' => array('datetime'),
				'message' => 'Invalid date',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'destination' => array(
			'minLength'   => array(
				'rule'	  => array('minLength', 2),
				'message' => 'At least 2 characters',
			),
		),
		'number_of_students' => array(
			'naturalNumber' => array(
				'rule' => array('naturalNumber'),
				'message' => 'Only natural numbers (greater than zero)',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'number_of_students_present' => array(
			'naturalNumber' => array(
				'rule' => array('naturalNumber'),
				'message' => 'Only natural numbers (greater than zero)',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'refund' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'Enter a valid numerical value',
				// 'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'transport' => array(
			'allowedChoice' => array(
				'rule' => array('inList', array()),
				'message' => 'Choose one of the options',
				'allowEmpty' => false,
				// 'required' => true,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'cost_transport' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'Enter a valid numerical value',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'distance' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'Enter a valid numerical value',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'objective' => array(
			'minLength'   => array(
				'rule'	  => array('minLength', 2),
				'message' => 'At least 2 characters',
			),
		),
		'status' => array(
			'allowedChoice' => array(
				'rule' => array('inList', array()),
				'message' => 'Choose one of the options',
				'allowEmpty' => false,
				// 'required' => true,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'user_id' => array(
			'allowedChoice' => array(
				'rule' => array('inList', array()),
				'message' => 'Choose one of the options',
				'allowEmpty' => false,
				// 'required' => true,
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
		'city_id' => array(
			'allowedChoice' => array(
				'rule' => array('inList', array()),
				'message' => 'Choose one of the options',
				'allowEmpty' => false,
				// 'required' => true,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'team_id' => array(
			'allowedChoice' => array(
				'rule' => array('inList', array()),
				'message' => 'Choose one of the options',
				'allowEmpty' => false,
				// 'required' => true,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'discipline_id' => array(
			'allowedChoice' => array(
				'rule' => array('inList', array()),
				'message' => 'Choose one of the options',
				'allowEmpty' => false,
				// 'required' => true,
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
		'report' => array(
			'extension' => array(
				'rule' => array('extension', array('odt', 'docx', 'doc', 'pdf', 'zip', '7z', 'rar')),
		        'message' => 'Please supply a valid file: "odt", "docx", "doc", "pdf", "zip", "7z", "rar"'
			),
			'fileSize' => array(
				'rule' => array('fileSize', '<=', '2MB'),
        		'message' => 'Report must be less than 2MB'
			),
			'uploadError' => array(
				'rule' => 'uploadError',
        		'message' => 'Something went wrong with the upload.'
			),
			'isUploadedFile' => array(
				'rule' => 'isUploadedFile',
				'message' => 'Something went wrong with the upload.'
			),
		),
	);

	public function isUploadedFile($params) {
	    $val = array_shift($params);
	    if ((isset($val['error']) && $val['error'] == 0) ||
	        (!empty( $val['tmp_name']) && $val['tmp_name'] != 'none')
	    ) {
	        return is_uploaded_file($val['tmp_name']);
	    }
	    return false;
	}

	public function beforeSave($options = array()){
        if(isset($this->data[$this->alias]['report']) && !empty($this->data[$this->alias]['report'])) {
            $this->data[$this->alias]['report'] = $this->upload($this->data[$this->alias]['report']);
        }
		return true;
    }

	public function upload($attach = array()) {
		$dir = WWW_ROOT . Configure::read('Parameter.System.dirReportFiles') . DS;
		if (!is_dir($dir)){
			$folder = new Folder();
			$folder->create($dir);
		}

		$attach_info = pathinfo($dir . $attach['name']);
		$name = strtolower(Inflector::slug($attach_info['filename'],'-')).'.'.$attach_info['extension'];
		$count = 2;
		while (file_exists($dir.$name)) {
			$name = strtolower(Inflector::slug($attach_info['filename'],'-')).'-'.$count.'.'.$attach_info['extension'];
			$count++;
			// debug($name);
		}

		$file = new File($attach['tmp_name']);
		$file->copy($dir . $name);
		$file->close();

		if ($this->field('report') != '') {
			$fileOld = new File($dir.$this->field('report'));
			$fileOld->delete();
			$fileOld->close();
		}

		return $name;
    }

	// The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'City' => array(
			'className' => 'City',
			'foreignKey' => 'city_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Team' => array(
			'className' => 'Team',
			'foreignKey' => 'team_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Discipline' => array(
			'className' => 'Discipline',
			'foreignKey' => 'discipline_id',
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
		'Refusal' => array(
			'className' => 'Refusal',
			'foreignKey' => 'visit_id',
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
