<?php
App::uses('AppController', 'Controller');
/**
 * Teams Controller
 *
 * @property Team $Team
 */
class TeamsController extends AppController {


/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Team->recursive = 0;
		$this->set('teams', $this->Team->find('all'));
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Team->exists($id)) {
			throw new NotFoundException(__('Invalid team'));
		}
		$this->Team->recursive = 2;
		$options = array('conditions' => array('Team.' . $this->Team->primaryKey => $id));
		$this->set('team', $this->Team->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Team->create();
			if ($this->Team->save($this->request->data)) {
				$this->Flash->success(__('The team has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The team could not be saved. Please, try again.'));
			}
		}
		$options = array(
			'fields' => array(
				$this->Team->Discipline->alias.'.id',
				$this->Team->Discipline->alias.'.name',
				$this->Team->Discipline->Course->alias.'.name'
			),
			'joins' => array(
				array(
					'table' => $this->Team->Discipline->Course->table,
					'alias' => $this->Team->Discipline->Course->alias,
					'type' => 'INNER',
					'conditions' => array(
						$this->Team->Discipline->alias.'.course_id = '.$this->Team->Discipline->Course->alias.'.id'
					)
				),
			)
		);
		$disciplines = $this->Team->Discipline->find('list', $options);
		$this->set(compact('disciplines'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Team->exists($id)) {
			throw new NotFoundException(__('Invalid team'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Team->save($this->request->data)) {
				$this->Flash->success(__('The team has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The team could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Team.' . $this->Team->primaryKey => $id));
			$this->request->data = $this->Team->find('first', $options);
		}
		$disciplines = $this->Team->Discipline->find('list');
		$this->set(compact('disciplines'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Team->id = $id;
		if (!$this->Team->exists()) {
			throw new NotFoundException(__('Invalid team'));
		}
		$team = $this->Team->read();
		if (empty($team[$this->Team->Visit->alias])) {
			$this->request->allowMethod('post', 'delete');
			if ($this->Team->delete()) {
				$this->Flash->success(__('The team has been deleted.'));
			} else {
				$this->Flash->error(__('The team could not be deleted. Please, try again.'));
			}
		} else {
			$this->Flash->warning(__('The team could not be deleted because it is tied to a visit.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
