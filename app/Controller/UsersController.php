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

	public function update_password($token = null) {
		$this->layout = 'login';
		if ($this->request->is(array('post', 'put'))) {
			if (isset($this->request->data[$this->User->alias]['password']) && !empty($this->request->data[$this->User->alias]['password'])) {
				$this->request->data[$this->User->alias]['token'] = '';
				if ($this->User->save($this->request->data)) {
					$this->Flash->success(__('The password has been saved.'));
					$token = null;
				} else {
					$this->Flash->error(__('The password could not be saved. Please, try again.'));
				}
			} else {
				$user = $this->User->find('first', array('conditions' => array($this->User->alias.'.email' => $this->request->data[$this->User->alias]['email'])));
				if (!empty($user)) {
					$token = $this->User->token();
					$this->User->id = $user[$this->User->alias]['id'];
					if ($this->User->saveField('token', $token)) {
						$link = Configure::read('Parameter.System.updatePassword');
						if (substr(Configure::read('Parameter.System.updatePassword'), -1) !== '/') {
							$link .= '/';
						}
						$link .= $token;
						$options['to'] = $this->User->field('email');
						$options['template'] = 'update_password';
						$options['subject'] = __('Update password - Technical Visits');
						$options['user'] = $this->User->read();
						$options['link'] = $link;
						if ($this->sendMail($options)) {
							$this->Flash->success(__('The password update email sent successfully.'));
						} else {
							$this->Flash->warning(__('Could not send email for password update. Please, try again in a few minutes.'));
						}
					} else {
						$this->Flash->error(__('Your password update permission could not be generated. Please, try again in a few minutes.'));
					}
					$token = null;
				} else {
					$this->Flash->error(__('No users found. Please, try again.'));
				}
			}
		}
		if (!is_null($token)) {
			$user = $this->User->find('first', array('conditions' => array($this->User->alias.'.token' => $token)));
			if (empty($user)) {
				$this->Flash->error(__('Invalid token'));
				return $this->redirect(array('action' => 'login'));
			} else {
				$this->request->data = $user;
				unset($this->request->data[$this->User->alias]['password']);
			}
		} else {
			return $this->redirect(array('action' => 'login'));
		}
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
			if (empty($this->request->data[$this->User->alias]['password'])) {
				unset($this->request->data[$this->User->alias]['password']);
				unset($this->request->data[$this->User->alias]['confirm_password']);
				$this->request->data[$this->User->alias]['token'] = $this->User->token();
			}
			$this->User->create();
			if ($this->User->save($this->request->data)) {
				$user = $this->User->read();
				$options['to'] = $user[$this->User->alias]['email'];
				$options['template'] = 'update_password';
				$options['subject'] = __('Update password - Technical Visits');
				$options['user'] = $user;
				$options['link'] = Configure::read('Parameter.System.updatePassword');
				if ($this->sendMail($options)) {
					$this->Flash->success(__('The user has been saved.'));
				} else {
					$this->Flash->warning(__('The user has been saved but could not send email for password update.'));
				}
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The user could not be saved. Please, try again in a few minutes.'));
				unset($this->request->data[$this->User->alias]['password']);
				unset($this->request->data[$this->User->alias]['confirm_password']);
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
				$this->Flash->error(__('The user could not be saved. Please, try again in a few minutes.'));
			}
		} else {
			$options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
			$this->request->data = $this->User->find('first', $options);
			unset($this->request->data[$this->User->alias]['password']);
		}
		$groups = $this->User->Group->find('list');
		$this->set(compact('groups'));
	}

	public function profile() {
		$this->User->id = $this->Auth->user('id');
		if (!$this->User->exists()) {
			$this->Flash->error(__('Invalid user'));
			return $this->redirect(array('/'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->User->save($this->request->data)) {
				$this->Flash->success(__('The user has been saved.'));
			} else {
				$this->Flash->error(__('The user could not be saved. Please, try again in a few minutes.'));
			}
		} else {
			$this->request->data = $this->User->read();
		}
		unset($this->request->data[$this->User->alias]['current_password']);
		unset($this->request->data[$this->User->alias]['password']);
		unset($this->request->data[$this->User->alias]['confirm_password']);
		$groups = $this->User->Group->find('list', array('conditions' => array($this->User->Group->alias.'.id' => $this->User->field('group_id'))));
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
		if ($id === $this->Auth->user('id')) {
			$this->Flash->error(__('You can not delete yourself.'));
		} else {
			$this->User->id = $id;
			if (!$this->User->exists()) {
				$this->Flash->error(__('Invalid user'));
			} else {
				$user = $this->User->read();
				if (empty($user[$this->User->Visit->alias])) {
					$this->request->allowMethod('post', 'delete');
					if ($this->User->delete()) {
						$this->Flash->success(__('The user has been deleted.'));
					} else {
						$this->Flash->error(__('The user could not be deleted. Please, try again in a few minutes.'));
					}
				} else {
					$this->Flash->warning(__('The user could not be deleted because it is tied to a visit.'));
				}
			}
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
			$this->Flash->error(__('The user could not be saved. Please, try again in a few minutes.'));
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
			$this->Flash->success(__('Invalid user'));
			return $this->redirect(array('action' => 'index'));
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
			return $this->redirect(array('action' => 'index'));
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
