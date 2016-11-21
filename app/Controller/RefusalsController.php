<?php
App::uses('AppController', 'Controller');
/**
 * Refusals Controller
 *
 * @property Refusal $Refusal
 */
class RefusalsController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Refusal->recursive = 0;
		$this->set('refusals', $this->Refusal->find('all'));
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
			$this->request->data[$this->Refusal->alias]['user_id'] = $this->Auth->user('id');
			$this->Refusal->create();
			if ($this->Refusal->save($this->request->data)) {
				$this->Refusal->Visit->id = $this->request->data[$this->Refusal->alias]['visit_id'];
				switch ($this->request->data[$this->Refusal->alias]['type']) {
					case '0':
						$this->Refusal->Visit->saveField('status', '10');
						break;
					case '1':
						$this->Refusal->Visit->saveField('status', '11');
						break;
					case '2':
						$s = $this->Refusal->Visit->field('status') - 2;
						$this->Refusal->Visit->saveField('status', $s);
						break;
					case '3':
						// $this->Refusal->Visit->saveField('status', '10');
						break;
					default:

						break;
				}
				$this->Flash->success(__('The refusal has been saved.'));
				return $this->redirect(array('controller'=>'visits','action' => 'index'));
			} else {
				$this->Flash->error(__('The refusal could not be saved. Please, try again.'));
			}
		}
	}

	public function cancel($id = null){
		$this->Refusal->Visit->id = $id;
		if (!$this->Refusal->Visit->exists()) {
			$this->Flash->error(__('Invalid visit'));
			return $this->redirect(array('controller'=>'visits','action' => 'index'));
		}
		if ($this->Refusal->Visit->field('user_id') !== $this->Auth->user('id')) {
			$this->Flash->error(__('Invalid visit'));
			return $this->redirect(array('controller'=>'visits','action' => 'index'));
		}
		$this->request->data[$this->Refusal->alias]['type'] = '0';
		$this->request->data[$this->Refusal->alias]['visit_id'] = $id;
		$this->render('add');
	}

	public function disapproved_visit($id = null){
		$this->Refusal->Visit->id = $id;
		if (!$this->Refusal->Visit->exists()) {
			$this->Flash->error(__('Invalid visit'));
			return $this->redirect(array('controller'=>'visits','action' => 'index'));
		}
		$this->request->data[$this->Refusal->alias]['type'] = '1';
		$this->request->data[$this->Refusal->alias]['visit_id'] = $id;
		$this->render('add');
	}

	public function disapproved_report($id = null){
		$this->Refusal->Visit->id = $id;
		if (!$this->Refusal->Visit->exists()) {
			$this->Flash->error(__('Invalid visit'));
			return $this->redirect(array('controller'=>'visits','action' => 'index'));
		}
		$this->request->data[$this->Refusal->alias]['type'] = '2';
		$this->request->data[$this->Refusal->alias]['visit_id'] = $id;
		$this->render('add');
	}

	public function disapproved_change($id = null){
		$this->Refusal->Visit->id = $id;
		if (!$this->Refusal->Visit->exists()) {
			$this->Flash->error(__('Invalid visit'));
			return $this->redirect(array('controller'=>'visits','action' => 'index'));
		}
		$this->request->data[$this->Refusal->alias]['type'] = '3';
		$this->request->data[$this->Refusal->alias]['visit_id'] = $id;
		$this->render('add');
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	// public function edit($id = null) {
	// 	if (!$this->Refusal->exists($id)) {
	// 		throw new NotFoundException(__('Invalid refusal'));
	// 	}
	// 	if ($this->request->is(array('post', 'put'))) {
	// 		if ($this->Refusal->save($this->request->data)) {
	// 			$this->Flash->success(__('The refusal has been saved.'));
	// 			return $this->redirect(array('action' => 'index'));
	// 		} else {
	// 			$this->Flash->error(__('The refusal could not be saved. Please, try again.'));
	// 		}
	// 	} else {
	// 		$options = array('conditions' => array('Refusal.' . $this->Refusal->primaryKey => $id));
	// 		$this->request->data = $this->Refusal->find('first', $options);
	// 	}
	// 	$users = $this->Refusal->User->find('list');
	// 	$visits = $this->Refusal->Visit->find('list');
	// 	$this->set(compact('users', 'visits'));
	// }

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	// public function delete($id = null) {
	// 	$this->Refusal->id = $id;
	// 	if (!$this->Refusal->exists()) {
	// 		throw new NotFoundException(__('Invalid refusal'));
	// 	}
	// 	$this->request->allowMethod('post', 'delete');
	// 	if ($this->Refusal->delete()) {
	// 		$this->Flash->success(__('The refusal has been deleted.'));
	// 	} else {
	// 		$this->Flash->error(__('The refusal could not be deleted. Please, try again.'));
	// 	}
	// 	return $this->redirect(array('action' => 'index'));
	// }
}
