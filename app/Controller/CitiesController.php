<?php
App::uses('AppController', 'Controller');
/**
 * Cities Controller
 *
 * @property City $City
 */
class CitiesController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$cities = $this->City->find('all');
		$this->set(compact('cities'));
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->City->id = $id;
		if (!$this->City->exists()) {
			$this->Flash->error(__('Invalid city'));
			return $this->redirect(array('action' => 'index'));
		}
		$city = $this->City->read();
		$this->set(compact('city'));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->City->create();
			if ($this->City->save($this->request->data)) {
				$this->Flash->success(__('The city has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The city could not be saved. Please, try again.'));
			}
		}
		$states = $this->City->State->find('list');
		$this->set(compact('states'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->City->exists($id)) {
			throw new NotFoundException(__('Invalid city'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->City->save($this->request->data)) {
				$this->Flash->success(__('The city has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The city could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('City.' . $this->City->primaryKey => $id));
			$this->request->data = $this->City->find('first', $options);
		}
		$states = $this->City->State->find('list');
		$this->set(compact('states'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->City->id = $id;
		if (!$this->City->exists()) {
			$this->Flash->error(__('Invalid city'));
		} else {
			$this->request->allowMethod('post', 'delete');
			$count = $this->City->Visit->find('count', array('conditions' => array('City.id' => $id)));
			if ($count < 1) {
				if ($this->City->delete()) {
					$this->Flash->success(__('The city has been deleted.'));
				} else {
					$this->Flash->error(__('The city could not be deleted. Please, try again.'));
				}
			} else {
				$this->Flash->error(__('The city could not be deleted because there are tied visits.'));
			}
		}
		return $this->redirect(array('action' => 'index'));
	}

/**
 * cities_short_distance method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function cities_short_distance() {
		if ($this->request->is(array('post', 'put'))) {
			$conditions = array($this->City->alias.'.id' => $this->request->data[$this->City->alias]['cities']);
			if ($this->City->updateAll(array($this->City->alias.'.short_distance' => 0))) {
				if ($this->City->updateAll(array($this->City->alias.'.short_distance' => 1), $conditions)) {
					$this->Flash->success(__('The cities short distance has been saved.'));
					return $this->redirect(array('action' => 'cities_short_distance'));
				} else {
					$this->Flash->error(__('The cities short distance could not be saved. Please, try again.'));
				}
			} else {
				$this->Flash->error(__('The cities short distance could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array($this->City->alias.'.short_distance' => 1));
			$list = $this->City->find('list', $options);
			$this->request->data[$this->City->alias]['cities'] = array_keys($list);
		}
		$cities = $this->City->superlist();
		$this->set(compact('cities'));
	}

}
