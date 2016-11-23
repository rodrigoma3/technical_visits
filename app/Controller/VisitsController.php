<?php
App::uses('AppController', 'Controller');
/**
 * Visits Controller
 *
 * @property Visit $Visit
 */
class VisitsController extends AppController {

	public function beforeFilter(){
		parent::beforeFilter();
		if (isset($this->request->data[$this->Visit->alias]['departure'])) {
			$this->request->data[$this->Visit->alias]['departure'] =
			date('Y-m-d H:i:s', strtotime($this->request->data[$this->Visit->alias]['departure']));
		}
		if (isset($this->request->data[$this->Visit->alias]['arrival'])) {
			$this->request->data[$this->Visit->alias]['arrival'] =
			date('Y-m-d H:i:s', strtotime($this->request->data[$this->Visit->alias]['arrival']));
		}
	}

	public function beforeRender(){
		parent::beforeRender();
		if (isset($this->request->data[$this->Visit->alias]['departure'])) {
			$this->request->data[$this->Visit->alias]['departure'] =
			date('Y-m-d\TH:i:s', strtotime($this->request->data[$this->Visit->alias]['departure']));
		}
		if (isset($this->request->data[$this->Visit->alias]['arrival'])) {
			$this->request->data[$this->Visit->alias]['arrival'] =
			date('Y-m-d\TH:i:s', strtotime($this->request->data[$this->Visit->alias]['arrival']));
		}
	}

/**
 * index method
 *
 * @return void
 */
	public function index() {
		// debug(Configure::read());
		$this->set('courses', $this->Visit->Discipline->Course->find('list'));
		$this->Visit->recursive = 2;
		$this->set('visits', $this->Visit->find('all'));
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
		$this->Visit->recursive = 2;
		$this->set('courses', $this->Visit->Discipline->Course->find('list'));
		$this->set('refusal_types', $this->Visit->Refusal->getEnums('type'));
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
		$transports = $this->Visit->getEnums('transport');
		$statuses = $this->Visit->getEnums('status');
		$users = $this->Visit->User->find('list');
		$cities = $this->Visit->City->find('list');
		$teams = $this->Visit->Team->find('list');
		$disciplines = $this->Visit->Discipline->find('list');
		$courses = $this->Visit->Discipline->Course->find('list');
		$this->set(compact('users', 'cities', 'teams', 'transports', 'statuses', 'disciplines', 'courses'));
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
		$transports = $this->Visit->getEnums('transport');
		$statuses = $this->Visit->getEnums('status');
		$users = $this->Visit->User->find('list');
		$cities = $this->Visit->City->find('list');
		$teams = $this->Visit->Team->find('list');
		$disciplines = $this->Visit->Discipline->find('list');
		$courses = $this->Visit->Discipline->Course->find('list');
		$this->set(compact('users', 'cities', 'teams', 'transports', 'statuses', 'disciplines', 'courses'));
	}

	public function copy($id = null){
		if (!$this->Visit->exists($id)) {
			throw new NotFoundException(__('Invalid visit'));
		}
		$this->Visit->recursive = -1;
		$options = array('conditions' => array('Visit.' . $this->Visit->primaryKey => $id));
		$this->request->data = $this->Visit->find('first', $options);
		unset($this->request->data['Visit']['id']);
		unset($this->request->data['Visit']['created']);
		unset($this->request->data['Visit']['departure']);
		unset($this->request->data['Visit']['arrival']);
		$transports = $this->Visit->getEnums('transport');
		$statuses = $this->Visit->getEnums('status');
		$users = $this->Visit->User->find('list');
		$cities = $this->Visit->City->find('list');
		$teams = $this->Visit->Team->find('list');
		$disciplines = $this->Visit->Discipline->find('list');
		$courses = $this->Visit->Discipline->Course->find('list');
		$this->set(compact('users', 'cities', 'teams', 'transports', 'statuses', 'disciplines', 'courses'));
		$this->render('add');
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	// public function delete($id = null) {
	// 	$this->Visit->id = $id;
	// 	if (!$this->Visit->exists()) {
	// 		throw new NotFoundException(__('Invalid visit'));
	// 	}
	// 	$this->request->allowMethod('post', 'delete');
	// 	if ($this->Visit->delete()) {
	// 		$this->Flash->success(__('The visit has been deleted.'));
	// 	} else {
	// 		$this->Flash->error(__('The visit could not be deleted. Please, try again.'));
	// 	}
	// 	return $this->redirect(array('action' => 'index'));
	// }

	public function pre_approve_visit($id = null) {
		$this->Visit->id = $id;
		if (!$this->Visit->exists()) {
			throw new NotFoundException(__('Invalid visit'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Visit->field('transport') == '0') {
				$s = '1';
			} else {
				$s = '2';
			}
			if ($this->Visit->saveField('status', $s)) {
				$this->Flash->success(__('The visit has been pre approved.'));
			} else {
				$this->Flash->error(__('Pre approval could not be saved. Please, try again.'));
			}
		}
		return $this->redirect(array('action' => 'index'));
	}

	public function approve_visit($id = null) {
		$this->Visit->id = $id;
		if (!$this->Visit->exists()) {
			throw new NotFoundException(__('Invalid visit'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Visit->saveField('status', '3')) {
				$this->Flash->success(__('The visit has been approved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('Approval could not be saved. Please, try again.'));
			}
		}
		return $this->redirect(array('action' => 'index'));
	}

	public function approve_report($id = null) {
		$this->Visit->id = $id;
		if (!$this->Visit->exists()) {
			throw new NotFoundException(__('Invalid visit'));
		}
		if ($this->request->is(array('post', 'put'))) {
			$s = $this->Visit->field('status') + 2;
			if ($this->Visit->saveField('status', $s)) {
				$this->Flash->success(__('The visit report has been approved.'));
			} else {
				$this->Flash->error(__('Approval could not be saved. Please, try again.'));
			}
		}
		return $this->redirect(array('action' => 'index'));
	}

/**
* deliver_report method
*
* @throws NotFoundException
* @param string $id
* @return void
*/
	public function deliver_report() {
		if ($this->request->is(array('post', 'put'))) {
			$this->Visit->id = $this->request->data[$this->Visit->alias]['id'];
			if (!$this->Visit->exists()) {
				throw new NotFoundException(__('Invalid visit'));
			}
			$status = $this->Visit->field('status');
			if ($status > 7) {
				$this->Flash->info(__('The visit report has already been approved or the visit has been canceled.'));
			} else {
				if ($status < 6) {
					$this->request->data[$this->Visit->alias]['status'] = $this->Visit->field('status') + 2;
				}
				if ($this->Visit->save($this->request->data)) {
					$this->Flash->success(__('The visit report was delivered.'));
				} else {
					$this->Flash->error(__('The visit could not be saved. Please, try again.'));
				}
			}
		}
		return $this->redirect($this->referer());
	}

	public function downloadfile($id = null) {
		$this->Visit->id = $id;
		if (!$this->Visit->exists()) {
			throw new NotFoundException(__('Invalid visit'));
		}
		$file = $this->Visit->field('report');
		$this->response->file(WWW_ROOT.Configure::read('Parameter.System.dirReportFiles').DS.$file,array('download'=> true));
		return $this->response;
    }
}
