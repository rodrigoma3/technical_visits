<?php
App::uses('AppController', 'Controller');
/**
 * Users Controller
 *
 * @property User $User
 */
class UsersController extends AppController {

/**
 * beforeFilter method
 *
 * @return void
 */
	public function beforeFilter() {
	    parent::beforeFilter();

	}

/**
 * login method
 *
 * @return void
 */
	public function login() {
		if ($this->Auth->loggedIn()) {
	        $this->Flash->success(__('You are logged in!'));
	        return $this->redirect('/');
	    } else {
			if ($this->request->is('post')) {
				if ($this->Auth->login()) {
					if (!$this->Auth->user('enabled')) {
						$this->Flash->info(__('The user is disabled.'));
						$this->redirect($this->Auth->logout());
					} else {
						if ($this->request->data['User']['remember_me']) {
							$cookie = array();
							$cookie['username'] = $this->request->data['User']['username'];
							$cookie['password'] = $this->request->data['User']['password'];
							$this->Cookie->write('remember_me_cookie', $cookie, true, '2 weeks');
						} else {
							$this->Cookie->delete('remember_me_cookie');
						}
						return $this->redirect($this->Auth->redirectUrl());
					}
				}
				$this->Flash->error(__('Your username or password was incorrect.'));
			} elseif ($this->Cookie->read('remember_me_cookie')) {
				$this->request->data['User'] = $this->Cookie->read('remember_me_cookie');
				if (!$this->Auth->login()) {
					$this->Cookie->delete('remember_me_cookie');
				}
			}
			$this->layout = 'login';
		}
	}

/**
 * logout method
 *
 * @return void
 */
	public function logout() {
		$this->Cookie->delete('remember_me_cookie');
		$this->Flash->success(__('Good-Bye'));
		$this->redirect($this->Auth->logout());
	}

	public function reset_password($token = null) {
		// if (!is_null($token)) {
		// 	# code...
		// } else {
			$user = $this->User->find('first', array('conditions' => array($this->User->alias.'.email' => $this->request->data[$this->User->alias]['email'])));
			if (!empty($user)) {
				// gerar senha
				$options['to'] = $user[$this->User->alias]['email'];
				$options['template'] = 'password_generate';
				$options['subject'] = __('Your password was generate! - Technical Visits');
				$options['user'] = $user;
				if ($this->sendMail($options)) {
						$emailSendFlag = true;
				} else {
						$emailSendFlag = false;
				}
			}
		// }
	}

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->set('users', $this->User->find('all'));
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->User->exists($id)) {
			throw new NotFoundException(__('Invalid user'));
		}
		$options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
		$this->set('user', $this->User->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->User->create();
			if ($this->User->save($this->request->data)) {
				$this->Flash->success(__('The user has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The user could not be saved. Please, try again.'));
			}
		}
		$groups = $this->User->Group->find('list');
		$this->set(compact('groups'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->User->exists($id)) {
			throw new NotFoundException(__('Invalid user'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if (empty($this->request->data[$this->User->alias]['password'])) {
				unset($this->request->data[$this->User->alias]['password']);
			}
			if ($this->User->save($this->request->data)) {
				$this->Flash->success(__('The user has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The user could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
			$this->request->data = $this->User->find('first', $options);
		}
		$groups = $this->User->Group->find('list');
		$this->set(compact('groups'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		$user = $this->User->read();
		if (empty($user[$this->User->Visit->alias])) {
			$this->request->allowMethod('post', 'delete');
			if ($this->User->delete()) {
				$this->Flash->success(__('The user has been deleted.'));
			} else {
				$this->Flash->error(__('The user could not be deleted. Please, try again.'));
			}
		} else {
			$this->Flash->warning(__('The user could not be deleted because it is tied to a visit.'));
		}
		return $this->redirect(array('action' => 'index'));
	}

/**
 * allow_access method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function allow_access($id = null) {
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		$this->request->allowMethod('post', 'allow_access');
		if ($this->User->field('enabled')) {
			$enabled = '0';
		} else {
			$enabled = '1';
		}
		if ($this->User->saveField('enabled', $enabled)) {
			$this->Flash->success(__('The user has been saved.'));
		} else {
			$this->Flash->error(__('The user could not be saved. Please, try again.'));
		}
		return $this->redirect($this->referer());
	}

/**
 * permission method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function permission($id = null) {
		if (!$this->User->exists($id)) {
			throw new NotFoundException(__('Invalid user'));
		}
		$this->User->id = $id;
		$aroUser = $this->Acl->Aro->find('first', array('conditions' => array('foreign_key' => $this->User->id, 'model' => 'User')));

		if ($this->request->is(array('post', 'put'))) {
			// debug($this->Acl->Aro->Permission->find('all'));
			$this->User->deletePermissions($aroUser['Aro']['id']);
			foreach ($this->request->data['perms'] as $alias => $perm) {
				if ($perm == '0') {
					$this->Acl->deny($this->User,$alias);
				} elseif ($perm == '1') {
					$this->Acl->allow($this->User,$alias);
				}
			}
			$this->Flash->success(__('The user permissions has been saved.'));
		}

		$aroUser = $this->Acl->Aro->find('first', array('conditions' => array('foreign_key' => $this->User->id, 'model' => 'User')));
		foreach ($aroUser['Aco'] as $aco) {
			$tree = $this->Acl->Aco->getPath($aco['id'],'alias');
			$aliases = array();
			foreach ($tree as $t) {
				$aliases[] = $t['Aco']['alias'];
			}
			$alias = implode('/', $aliases);
			$this->request->data['perms'][$alias] = $this->Acl->check($this->User, $alias);
		}

		$user = $this->User->read();
		$actions = array();

		$acosList = $this->Acl->Aco->find('list');
		foreach ($acosList as $acoId) {
			$tree = $this->Acl->Aco->getPath($acoId,'alias');
			$aliases = array();
			foreach ($tree as $t) {
				$aliases[] = $t['Aco']['alias'];
			}
			$actions[] = implode('/', $aliases);
		}

		$this->set('perms', $this->User->getEnums('perms'));
		$this->set('user', $user);
		$this->set('actions', $actions);
	}
}
