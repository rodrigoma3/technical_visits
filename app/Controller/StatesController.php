<?php
App::uses('AppController', 'Controller');
/**
 * States Controller
 *
 * @property State $State
 */
class StatesController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->set('states', $this->State->find('all'));
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->State->id = $id;
		if (!$this->State->exists()) {
			$this->Flash->success(__('Invalid state'));
			return $this->redirect(array('action' => 'index'));
		}
		$this->State->recursive = 2;
		$state = $this->State->read();
		$this->set(compact('state'));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->State->create();
			if ($this->State->save($this->request->data)) {
				$this->Flash->success(__('The state has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The state could not be saved. Please, try again.'));
			}
		}
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->State->exists($id)) {
			throw new NotFoundException(__('Invalid state'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->State->save($this->request->data)) {
				$this->Flash->success(__('The state has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The state could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('State.' . $this->State->primaryKey => $id));
			$this->request->data = $this->State->find('first', $options);
		}
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->State->id = $id;
		if (!$this->State->exists()) {
			$this->Flash->error(__('Invalid state'));
			return $this->redirect(array('action' => 'index'));
		}
		$options = array('conditions' => array($this->State->alias.'.'.$this->State->primaryKey => $id));
		if ($this->State->City->find('count', $options) === 0) {
			$this->request->allowMethod('post', 'delete');
			if ($this->State->delete()) {
				$this->Flash->success(__('The state has been deleted.'));
			} else {
				$this->Flash->error(__('The state could not be deleted. Please, try again.'));
			}
		} else {
			$this->Flash->warning(__('The state could not be deleted because it is tied to a city.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
