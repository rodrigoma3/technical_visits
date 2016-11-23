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
		$this->Visit->recursive = 2;
		$this->set('visits', $this->Visit->find('all'));
		$this->set('courses', $this->Visit->Discipline->Course->find('list'));
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
		$options = array('conditions' => array('Visit.' . $this->Visit->primaryKey => $id));
		$visit = $this->Visit->find('first', $options);
		$courses = $this->Visit->Discipline->Course->find('list');
		$refusal_types = $this->Visit->Refusal->getEnums('type');

		$approveVisit = false;
		$preApproveVisit = false;
		$approveReport = false;
		$deliverReport = false;

		$status = $visit[$this->Visit->alias]['status'];
		switch ($status) {
			case '0':
				$preApproveVisit = $this->Acl->check(array('User' => $this->Auth->user()), $this->Visit->table.'/pre_approve_visit');
				break;
			case '2':
				$approveVisit = $this->Acl->check(array('User' => $this->Auth->user()), $this->Visit->table.'/approve_visit');
				break;
			case '4':
			case '5':
				if ($visit[$this->Visit->alias]['user_id'] === $this->Auth->user('id')) $deliverReport = true;
				break;
			case '6':
			case '7':
				if ($visit[$this->Visit->alias]['user_id'] === $this->Auth->user('id')) $deliverReport = true;
				$approveReport = $this->Acl->check(array('User' => $this->Auth->user()), $this->Visit->table.'/approve_report');
				break;

			default:
				# code...
				break;
		}

		$this->set(compact('visit', 'courses', 'refusal_types', 'approveVisit', 'preApproveVisit', 'approveReport', 'deliverReport'));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if($this->request->is('ajax')){
			$this->autoRender = false;
			if ($this->request->query('state_id') !== null) {
				$options = array('conditions' => array($this->Visit->City->alias.'.state_id' => $this->request->query('state_id')));
				$result = $this->Visit->City->find('list', $options);
			}
			if ($this->request->query('course_id') !== null) {
				$options = array('conditions' => array($this->Visit->Discipline->alias.'.course_id' => $this->request->query('course_id')));
				$result = $this->Visit->Discipline->find('list', $options);
			}
			if ($this->request->query('discipline_id') !== null) {
				$options = array(
					'conditions' => array($this->Visit->Team->DisciplinesTeam->alias.'.discipline_id' => $this->request->query('discipline_id')),
					'joins' => array(
						array(
							'table' => $this->Visit->Team->DisciplinesTeam->table,
							'alias' => $this->Visit->Team->DisciplinesTeam->alias,
							'type' => 'INNER',
							'conditions' => array(
								$this->Visit->Team->alias.'.id = '.$this->Visit->Team->DisciplinesTeam->alias.'.team_id'
							)
				        )
					));
				$result = $this->Visit->Team->find('list', $options);
			}
			return json_encode($result);
		} elseif ($this->request->is('post')) {
			$this->request->data[$this->Visit->alias]['user_id'] = $this->Auth->user('id');
			$this->request->data[$this->Visit->alias]['status'] = '0';
			$this->Visit->create();
			if ($this->Visit->save($this->request->data)) {
				$this->Flash->success(__('The visit has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The visit could not be saved. Please, try again.'));
			}
		}
		$states = $this->Visit->City->State->find('list');
		$courses = $this->Visit->Discipline->Course->find('list');
		$this->set(compact('states', 'courses'));
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
		if($this->request->is('ajax')){
			$this->autoRender = false;
			if ($this->request->query('state_id') !== null) {
				$options = array('conditions' => array($this->Visit->City->alias.'.state_id' => $this->request->query('state_id')));
				$result = $this->Visit->City->find('list', $options);
			}
			if ($this->request->query('course_id') !== null) {
				$options = array('conditions' => array($this->Visit->Discipline->alias.'.course_id' => $this->request->query('course_id')));
				$result = $this->Visit->Discipline->find('list', $options);
			}
			if ($this->request->query('discipline_id') !== null) {
				$options = array(
					'conditions' => array($this->Visit->Team->DisciplinesTeam->alias.'.discipline_id' => $this->request->query('discipline_id')),
					'joins' => array(
						array(
							'table' => $this->Visit->Team->DisciplinesTeam->table,
							'alias' => $this->Visit->Team->DisciplinesTeam->alias,
							'type' => 'INNER',
							'conditions' => array(
								$this->Visit->Team->alias.'.id = '.$this->Visit->Team->DisciplinesTeam->alias.'.team_id'
							)
				        )
					));
				$result = $this->Visit->Team->find('list', $options);
			}
			return json_encode($result);
		} elseif ($this->request->is(array('post', 'put'))) {
			$this->request->data[$this->Visit->alias]['user_id'] = $this->Auth->user('id');
			// $this->request->data[$this->Visit->alias]['status'] = '0';
			if ($this->Visit->save($this->request->data)) {
				$visitOptions = array('conditions' => array('Visit.' . $this->Visit->primaryKey => $id));
				$visitInfo = $this->Visit->find('first', $visitOptions);
					// $options['to'] = Configure::read('Parameter.Email.fromEmail'); // TODO HABILITAR ESTA LINHA QD SISTEMA ESTIVER PRONTO
					$options['to'] = 'giba_fernando@hotmail.com'; // TODO EXCLUIR ESTA LINHA QD SISTEMA ESTIVER PRONTO
					$options['template'] = 'visit_edited';
					$options['subject'] = __('Visit to %s has been Edited! - Technical Visits', $visitInfo['Visit']['destination']);
					$options['v'] = $visitInfo;
					if ($this->sendMail($options)) {
							$emailSendFlag = true;
					} else {
							$emailSendFlag = false;
					}
				if($emailSendFlag){
					$this->Flash->success(__('The visit has been saved.'));
				}else{
					$this->Flash->warning(__('The visit has been saved, but the system failed to send the Administrator a notification e-mail.'));
				}
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The visit could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Visit.' . $this->Visit->primaryKey => $id));
			$this->request->data = $this->Visit->find('first', $options);
			$this->request->data[$this->Visit->alias]['states'] = $this->request->data[$this->Visit->City->alias]['state_id'];
			$this->request->data[$this->Visit->alias]['course'] = $this->request->data[$this->Visit->Discipline->alias]['course_id'];
		}
		$options = array(
			'conditions' => array($this->Visit->Team->DisciplinesTeam->alias.'.discipline_id' => $this->request->data[$this->Visit->alias]['discipline_id']),
			'joins' => array(
				array(
					'table' => $this->Visit->Team->DisciplinesTeam->table,
					'alias' => $this->Visit->Team->DisciplinesTeam->alias,
					'type' => 'INNER',
					'conditions' => array(
						$this->Visit->Team->alias.'.id = '.$this->Visit->Team->DisciplinesTeam->alias.'.team_id'
					)
				)
			));
		$teams = $this->Visit->Team->find('list', $options);
		$cities = $this->Visit->City->find('list', array('conditions' => array('state_id' => $this->request->data[$this->Visit->alias]['states'])));
		$disciplines = $this->Visit->Discipline->find('list', array('conditions' => array('course_id' => $this->request->data[$this->Visit->alias]['course'])));
		$states = $this->Visit->City->State->find('list');
		$courses = $this->Visit->Discipline->Course->find('list');
		$this->set(compact('teams', 'cities', 'disciplines', 'states', 'courses'));
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

/**
 * transport_update method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function transport_update($id = null) {
		$this->Visit->id = $id;
		if (!$this->Visit->exists()) {
			throw new NotFoundException(__('Invalid visit'));
		}
		if ($this->request->is(array('post', 'put'))) {
			$this->request->data[$this->Visit->alias]['status'] = $this->Visit->field('status') + 1;
			if ($this->Visit->save($this->request->data)) {
				$this->Flash->success(__('The visit has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The visit could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Visit.' . $this->Visit->primaryKey => $id));
			$this->request->data = $this->Visit->find('first', $options);
			$this->request->data[$this->Visit->alias]['states'] = $this->request->data[$this->Visit->City->alias]['state_id'];
			$this->request->data[$this->Visit->alias]['course'] = $this->request->data[$this->Visit->Discipline->alias]['course_id'];
		}
		$options = array(
			'conditions' => array($this->Visit->Team->DisciplinesTeam->alias.'.discipline_id' => $this->request->data[$this->Visit->alias]['discipline_id']),
			'joins' => array(
				array(
					'table' => $this->Visit->Team->DisciplinesTeam->table,
					'alias' => $this->Visit->Team->DisciplinesTeam->alias,
					'type' => 'INNER',
					'conditions' => array(
						$this->Visit->Team->alias.'.id = '.$this->Visit->Team->DisciplinesTeam->alias.'.team_id'
					)
				)
			));
		$teams = $this->Visit->Team->find('list', $options);
		$cities = $this->Visit->City->find('list', array('conditions' => array('state_id' => $this->request->data[$this->Visit->alias]['states'])));
		$disciplines = $this->Visit->Discipline->find('list', array('conditions' => array('course_id' => $this->request->data[$this->Visit->alias]['course'])));
		$states = $this->Visit->City->State->find('list');
		$courses = $this->Visit->Discipline->Course->find('list');
		$transports = $this->Visit->getEnums('transport');
		unset($transports[0]);
		unset($transports[1]);
		$cost_per_km = '';
		foreach (Configure::read('Parameter.Transport') as $k => $v) {
			$cost_per_km .= Inflector::humanize($k).' R$ <b id="'.$k.'">'.$v.'</b></br>';
		}
		$this->set(compact('teams', 'cities', 'disciplines', 'states', 'courses', 'transports', 'cost_per_km'));
	}
}
