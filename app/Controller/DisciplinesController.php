<?php
App::uses('AppController', 'Controller');
/**
 * Disciplines Controller
 *
 * @property Discipline $Discipline
 */
class DisciplinesController extends AppController {


/**
 * index method
 *
 * @return void
 */
	public function index() {
		$disciplines = $this->Discipline->find('all');
		$this->set(compact('disciplines'));
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->Discipline->id = $id;
		if (!$this->Discipline->exists()) {
			$this->Flash->error(__('Invalid discipline'));
			return $this->redirect(array('action' => 'index'));
		}
		$this->Discipline->recursive = 2;
		$discipline = $this->Discipline->read();
		$this->set(compact('discipline'));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Discipline->create();
			if ($this->Discipline->save($this->request->data)) {
				$this->Flash->success(__('The discipline has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The discipline could not be saved. Please, try again.'));
			}
		}
		$courses = $this->Discipline->Course->find('list');
		$this->set(compact('courses'));

		$this->Discipline->Course->recursive = 0;
		$this->set('coursesJson', json_encode($this->Discipline->Course->find('all')));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Discipline->exists($id)) {
			throw new NotFoundException(__('Invalid discipline'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Discipline->save($this->request->data)) {
				$this->Flash->success(__('The discipline has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The discipline could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Discipline.' . $this->Discipline->primaryKey => $id));
			$this->request->data = $this->Discipline->find('first', $options);
		}
		$courses = $this->Discipline->Course->find('list');
		$this->set(compact('courses'));

		$this->Discipline->Course->recursive = 0;
		$this->set('coursesJson', json_encode($this->Discipline->Course->find('all')));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Discipline->id = $id;
		if (!$this->Discipline->exists()) {
			$this->Flash->error(__('Invalid discipline'));
			return $this->redirect(array('action' => 'index'));
		}
		$options = array('conditions' => array('discipline_id' => $id));
		if ($this->Discipline->DisciplinesTeam->find('count', $options) == 0) {
			$this->request->allowMethod('post', 'delete');
			if ($this->Discipline->delete()) {
				$this->Flash->success(__('The discipline has been deleted.'));
			} else {
				$this->Flash->error(__('The discipline could not be deleted. Please, try again.'));
			}
		} else {
			$this->Flash->warning(__('The discipline could not be deleted because it is tied to a team.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
