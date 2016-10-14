<?php
App::uses('AppController', 'Controller');
/**
 * DisciplinesTeams Controller
 *
 * @property DisciplinesTeam $DisciplinesTeam
 * @property PaginatorComponent $Paginator
 */
class DisciplinesTeamsController extends AppController {

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
		$this->DisciplinesTeam->recursive = 0;
		$this->set('disciplinesTeams', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->DisciplinesTeam->exists($id)) {
			throw new NotFoundException(__('Invalid disciplines team'));
		}
		$options = array('conditions' => array('DisciplinesTeam.' . $this->DisciplinesTeam->primaryKey => $id));
		$this->set('disciplinesTeam', $this->DisciplinesTeam->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->DisciplinesTeam->create();
			if ($this->DisciplinesTeam->save($this->request->data)) {
				$this->Flash->success(__('The disciplines team has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The disciplines team could not be saved. Please, try again.'));
			}
		}
		$teams = $this->DisciplinesTeam->Team->find('list');
		$disciplines = $this->DisciplinesTeam->Discipline->find('list');
		$this->set(compact('teams', 'disciplines'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->DisciplinesTeam->exists($id)) {
			throw new NotFoundException(__('Invalid disciplines team'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->DisciplinesTeam->save($this->request->data)) {
				$this->Flash->success(__('The disciplines team has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The disciplines team could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('DisciplinesTeam.' . $this->DisciplinesTeam->primaryKey => $id));
			$this->request->data = $this->DisciplinesTeam->find('first', $options);
		}
		$teams = $this->DisciplinesTeam->Team->find('list');
		$disciplines = $this->DisciplinesTeam->Discipline->find('list');
		$this->set(compact('teams', 'disciplines'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->DisciplinesTeam->id = $id;
		if (!$this->DisciplinesTeam->exists()) {
			throw new NotFoundException(__('Invalid disciplines team'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->DisciplinesTeam->delete()) {
			$this->Flash->success(__('The disciplines team has been deleted.'));
		} else {
			$this->Flash->error(__('The disciplines team could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
