<?php
App::uses('AppController', 'Controller');
/**
 * Refusals Controller
 *
 * @property Refusal $Refusal
 * @property PaginatorComponent $Paginator
 */
class RefusalsController extends AppController {

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
		$this->Refusal->recursive = 0;
		$this->set('refusals', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Refusal->exists($id)) {
			throw new NotFoundException(__('Invalid refusal'));
		}
		$options = array('conditions' => array('Refusal.' . $this->Refusal->primaryKey => $id));
		$this->set('refusal', $this->Refusal->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Refusal->create();
			if ($this->Refusal->save($this->request->data)) {
				if($this->request->data['Refusal']['type'] == 2){ // SE É CANCELAR
					$this->Refusal->Visit->id = $this->request->data['Refusal']['visit_id'];
					$this->Refusal->Visit->saveField('status','10'); // ALTERA O STATUS DA VISITA PRA CANCELADA..
				}
				$this->Flash->success(__('The refusal has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The refusal could not be saved. Please, try again.'));
			}
		}
		$users = $this->Refusal->User->find('list');
		$visits = $this->Refusal->Visit->find('list');
		$this->set(compact('users', 'visits'));
	}

	public function cancel($id = null){
		if($id!=null){
			$this->request->data['Refusal']['type'] = '2'; // 2 = Cancel
			$this->request->data['Refusal']['user_id'] = $this->Auth->user('id');
			$this->request->data['Refusal']['visit_id'] = $id;
			$this->render('add');
		}else{
			return $this->redirect(array('controller'=>'visits','action' => 'index'));
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
		if (!$this->Refusal->exists($id)) {
			throw new NotFoundException(__('Invalid refusal'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Refusal->save($this->request->data)) {
				$this->Flash->success(__('The refusal has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The refusal could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Refusal.' . $this->Refusal->primaryKey => $id));
			$this->request->data = $this->Refusal->find('first', $options);
		}
		$users = $this->Refusal->User->find('list');
		$visits = $this->Refusal->Visit->find('list');
		$this->set(compact('users', 'visits'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Refusal->id = $id;
		if (!$this->Refusal->exists()) {
			throw new NotFoundException(__('Invalid refusal'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Refusal->delete()) {
			$this->Flash->success(__('The refusal has been deleted.'));
		} else {
			$this->Flash->error(__('The refusal could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
