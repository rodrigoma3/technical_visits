<?php
App::uses('AppController', 'Controller');
/**
 * Teams Controller
 *
 * @property Team $Team
 * @property PaginatorComponent $Paginator
 */
class TeamsController extends AppController {

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
		$this->Team->recursive = 0;
		$this->set('teams', $this->Paginator->paginate());
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
		$disciplines = $this->Team->Discipline->find('list');
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
		$this->request->allowMethod('post', 'delete');
		if ($this->Team->delete()) {
			$this->Flash->success(__('The team has been deleted.'));
		} else {
			$this->Flash->error(__('The team could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
