<?php
App::uses('AppController', 'Controller');
/**
 * Visits Controller
 *
 * @property Visit $Visit
 * @property PaginatorComponent $Paginator
 */
class VisitsController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Visit->recursive = 0;
		$this->set('visits', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Visit->exists($id)) {
			throw new NotFoundException(__('Invalid visit'));
		}
		$options = array('conditions' => array('Visit.' . $this->Visit->primaryKey => $id));
		$this->set('visit', $this->Visit->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Visit->create();
			if ($this->Visit->save($this->request->data)) {
				$this->Flash->success(__('The visit has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The visit could not be saved. Please, try again.'));
			}
		}
		$users = $this->Visit->User->find('list');
		$cities = $this->Visit->City->find('list');
		$teams = $this->Visit->Team->find('list');
		$this->set(compact('users', 'cities', 'teams'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Visit->exists($id)) {
			throw new NotFoundException(__('Invalid visit'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Visit->save($this->request->data)) {
				$this->Flash->success(__('The visit has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The visit could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Visit.' . $this->Visit->primaryKey => $id));
			$this->request->data = $this->Visit->find('first', $options);
		}
		$users = $this->Visit->User->find('list');
		$cities = $this->Visit->City->find('list');
		$teams = $this->Visit->Team->find('list');
		$this->set(compact('users', 'cities', 'teams'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Visit->id = $id;
		if (!$this->Visit->exists()) {
			throw new NotFoundException(__('Invalid visit'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Visit->delete()) {
			$this->Flash->success(__('The visit has been deleted.'));
		} else {
			$this->Flash->error(__('The visit could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
