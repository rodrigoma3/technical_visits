<?php
App::uses('AppModel', 'Model');
App::uses('AuthComponent', 'Controller/Component');
App::uses('Acl', 'Controller/Component');
App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');
/**
 * User Model
 *
 * @property Group $Group
 * @property Refusal $Refusal
 * @property Visit $Visit
 */
class User extends AppModel {
	public $actsAs = array('Acl' => array('type' => 'requester'));

    public function parentNode() {
        if (!$this->id && empty($this->data)) {
            return null;
        }
        if (isset($this->data['User']['group_id'])) {
            $groupId = $this->data['User']['group_id'];
        } else {
            $groupId = $this->field('group_id');
        }
        if (!$groupId) {
            return null;
        }
        return array('Group' => array('id' => $groupId));
    }

/**
 * beforeSave method
 *
 * @return boolean
 */
	public function beforeSave($options = array()) {
		if (isset($this->data[$this->alias]['password'])) {
			$hash = new BlowfishPasswordHasher();
			$this->data[$this->alias]['password'] = $hash->hash($this->data[$this->alias]['password']);
		}
		return true;
	}

	private $enum = array(
		'perms' => array(
			0 => 'Deny',
			1 => 'Allow',
			2 => 'Inherit the group',
		),
		'enabled' => array(
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
		// if (Router::getParams()['action'] !== 'login') {
		// 	foreach($results as $key => $value) {
		// 		if(isset($results[$key][$this->alias]['password'])) {
		// 			unset($results[$key][$this->alias]['password']);
		// 		}
		// 	}
		// }
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

		$this->validate['group_id']['allowedChoice']['rule'][1] = array_keys($this->Group->find('list'));
	}

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'name' => array(
			'simplechars' => array(
				'rule'    => '/^[A-Za-zÀ-ú0-9\ ]*$/i',
				'message' => 'Only letters, accentuation, numbers and space " "',
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
		'email' => array(
			'email' => array(
				'rule' => array('email'),
				'message' => 'Enter a valid email',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'isUnique' => array(
				'rule' => array('isUnique'),
				'message' => 'This email is already in use',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'current_password' => array(
			'required' => array(
				'rule'    => 'confirmCurrentPassword',
				'message' => 'Wrong password',
			),
		),
		'password' => array(
			'required' => array(
				'rule'    => array('equalToField','confirm_password'),
				'message' => 'Password and password confirmation are not the same',
				// 'allowEmpty' => true,
				// 'required' => false,
				//'last' => false, // Stop validation after this rule
				// 'on' => 'update', // Limit validation to 'create' or 'update' operations
			),
			'minLength'   => array(
				'rule'	  => array('minLength', 4),
				'message' => 'At least 4 characters',
				// 'allowEmpty' => true,
			),
		),
		'confirm_password' => array(
			'minLength'   => array(
				'rule'	  => array('minLength', 4),
				'message' => 'At least 4 characters',
				// 'allowEmpty' => true,
			),
		),
		'group_id' => array(
			'allowedChoice' => array(
				'rule' => array('inList', array()),
				'message' => 'Choose one of the options',
				'allowEmpty' => false,
				// 'required' => true,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'enabled' => array(
			'boolean' => array(
				'rule' => array('boolean'),
				'message' => 'Boolean options only',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	public function equalToField($check, $otherfield) {
		$fname = '';
		foreach ($check as $key => $value){
			$fname = $key;
			break;
		}
		if ($this->data[$this->alias][$otherfield] === $this->data[$this->alias][$fname]) {
			return true;
		} else {
			$this->invalidate($otherfield, null);
			return false;
		}

	}

	public function confirmCurrentPassword($check) {
		$fname = '';
		foreach ($check as $key => $value){
			$fname = $key;
			break;
		}
		$user = $this->findById($this->id);
		$newHash = Security::hash($this->data[$this->alias][$fname], 'blowfish', $user[$this->alias]['password']);
		if($newHash === $user[$this->alias]['password']){
			return true;
		} else {
			return false;
		}
	}

	// The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Group' => array(
			'className' => 'Group',
			'foreignKey' => 'group_id',
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
			'foreignKey' => 'user_id',
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
		'Visit' => array(
			'className' => 'Visit',
			'foreignKey' => 'user_id',
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
 * deletePermissions method
 *
 * @return boolean
 */
	public function deletePermissions($aroId){
		return $this->query("DELETE FROM aros_acos WHERE aro_id = $aroId");
	}

	public function token() {
		return Security::hash(uniqid(rand(), true));
	}

	public function usersAllowed($controller = null, $action = null, $acl = null, $options = array()) {
		if (is_null($controller) || is_null($action) || is_null($acl)) {
			return array();
		}

		$optionsAcoControllerId = array(
			'conditions' => array(
				'Aco.alias' => $controller,
			),
			'fields' => array(
				'Aco.id'
			),
			'recursive' => -1
		);
		$acoControllerId = $acl->Aco->find('first', $optionsAcoControllerId);
		// debug($acoControllerId);
		$acoControllerId = $acoControllerId['Aco']['id'];
		// debug($acoControllerId);

		$optionsAcoActionId = array(
			'conditions' => array(
				'Aco.alias' => $action,
				'Aco.parent_id' => $acoControllerId,
			),
			'fields' => array(
				'Aco.id'
			),
			'recursive' => -1
		);
		$acoActionId = $acl->Aco->find('first', $optionsAcoActionId);
		// debug($acoActionId);
		$acoActionId = $acoActionId['Aco']['id'];
		// debug($acoActionId);

		$optionsAroIdsDanied = array(
			'conditions' => array(
				'Permission.aco_id' => $acoActionId,
				'AND' => array(
					'Permission._create' => '-1',
					'Permission._read' => '-1',
					'Permission._update' => '-1',
					'Permission._delete' => '-1',
				),
			),
			'fields' => array(
				'Permission.aro_id'
			),
		);
		$arosIdsDanied = $acl->Aco->Permission->find('all', $optionsAroIdsDanied);
		// debug($arosIdsDanied);
		$arosIdsDanied = Set::classicExtract($arosIdsDanied, '{n}.'.$acl->Aco->Permission->alias.'.aro_id');
		// debug($arosIdsDanied);

		$optionsUsersDanied = array(
			'conditions' => array(
				'Aro.id' => $arosIdsDanied,
				'Aro.model' => 'USER',
			),
			'fields' => array(
				'Aro.foreign_key'
			),
			'recursive' => -1
		);
		$usersDanied = $acl->Aro->find('all', $optionsUsersDanied);
		// debug($usersDanied);
		$usersDanied = Set::classicExtract($usersDanied, '{n}.'.$acl->Aro->alias.'.foreign_key');
		// debug($usersDanied);

		$optionsAroIdsAllowed = array(
			'conditions' => array(
				'Permission.aco_id' => $acoActionId,
				'AND' => array(
					'Permission._create' => '1',
					'Permission._read' => '1',
					'Permission._update' => '1',
					'Permission._delete' => '1',
				),
			),
			'fields' => array(
				'Permission.aro_id'
			),
		);
		$arosIdsAllowed = $acl->Aco->Permission->find('all', $optionsAroIdsAllowed);
		// debug($arosIdsAllowed);
		$arosIdsAllowed = Set::classicExtract($arosIdsAllowed, '{n}.'.$acl->Aco->Permission->alias.'.aro_id');
		// debug($arosIdsAllowed);

		$optionsUsersGroupsAllowed = array(
			'conditions' => array(
				'Aro.id' => $arosIdsAllowed,
			),
			'fields' => array(
				'Aro.model',
				'Aro.foreign_key',
			),
			'recursive' => -1
		);
		$usersGroupsAllowed = $acl->Aro->find('all', $optionsUsersGroupsAllowed);
		// debug($usersGroupsAllowed);
		$groupsId = Set::extract('/'.$acl->Aro->alias.'[model=Group]/foreign_key', $usersGroupsAllowed);
		$usersId = Set::extract('/'.$acl->Aro->alias.'[model=User]/foreign_key', $usersGroupsAllowed);
		// debug($groupsId);
		// debug($usersId);

		$optionsUsersAllowed = array(
			'conditions' => array(
				'OR' => array(
					$this->alias.'.id' => $usersId,
					$this->alias.'.group_id' => $groupsId,
				),
				'NOT' => array(
					$this->alias.'.id' => $usersDanied,
				),
			),
			'recursive' => -1
		);
		$optionsUsersAllowed = array_merge($options, $optionsUsersAllowed);
		$users = $this->find('all', $optionsUsersAllowed);
		// debug($users);
		return $users;
	}

}
