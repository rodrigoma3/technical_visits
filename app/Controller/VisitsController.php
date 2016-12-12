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

	public function dashboard() {
		
	}

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Visit->recursive = 2;
		$visits = $this->Visit->find('all');
		$courses = $this->Visit->Discipline->Course->find('list');
		$this->set(compact('visits', 'courses'));
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->Visit->id = $id;
		if (!$this->Visit->exists()) {
			$this->Flash->error(__('Invalid visit'));
			return $this->redirect(array('action' => 'index'));
		}
		$this->Visit->recursive = 2;
		$visit = $this->Visit->read();
		$courses = $this->Visit->Discipline->Course->find('list');
		$refusal_types = $this->Visit->Refusal->getEnums('type');

		$perms = $this->findPerms();
		$p = array(
			'VisitsApproveVisit' => false,
			'RefusalsDisapprovedVisit' => false,
			'VisitsPreApproveVisit' => false,
			'VisitsApproveReport' => false,
			'VisitsDisapprovedReport' => false,
			'VisitsDeliverReport' => false,
		);
		$perms = array_merge($perms, $p);

		$status = $visit[$this->Visit->alias]['status'];
		switch ($status) {
			case '0':
				$p = $this->findPerms(array(
					array(
						'controller' => $this->Visit->table,
						'action' => 'pre_approve_visit',
					),
					array(
						'controller' => $this->Visit->Refusal->table,
						'action' => 'disapproved_visit',
					),
				));
				$perms = array_merge($perms, $p);
				break;
			case '2':
				$p = $this->findPerms(array(
					array(
						'controller' => $this->Visit->table,
						'action' => 'approve_visit',
					),
					array(
						'controller' => $this->Visit->Refusal->table,
						'action' => 'disapproved_visit',
					),
				));
				$perms = array_merge($perms, $p);
				break;
			case '4':
			case '5':
				if ($visit[$this->Visit->alias]['user_id'] === $this->Auth->user('id')) {
					$p = $this->findPerms(array(
						array(
							'controller' => $this->Visit->table,
							'action' => 'deliver_report',
						),
					));
					$perms = array_merge($perms, $p);
				}
				break;
			case '6':
			case '7':
				$options = array(
					array(
						'controller' => $this->Visit->table,
						'action' => 'approve_report',
					),
					array(
						'controller' => $this->Visit->Refusal->table,
						'action' => 'disapproved_report',
					),
				);

				if ($visit[$this->Visit->alias]['user_id'] === $this->Auth->user('id')) {
					$options[] = array(
						'controller' => $this->Visit->table,
						'action' => 'deliver_report',
					);
				}

				$p = $this->findPerms($options);
				$perms = array_merge($perms, $p);
				break;

			default:

				break;
		}

		$this->set(compact('visit', 'courses', 'refusal_types', 'perms'));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->Session->read('copy')) {
			$this->request->data = $this->Session->read('copy');
			$this->Session->delete('copy');
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
			$this->set(compact('teams', 'cities', 'disciplines'));
		}
		if($this->request->is('ajax')){
			$this->autoRender = false;
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
			$this->request->data[$this->Visit->alias]['status'] = '0';
			$this->Visit->create();
			if ($this->Visit->save($this->request->data)) {
				$this->Flash->success(__('The visit has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The visit could not be saved. Please, try again.'));
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
			$disciplines = $this->Visit->Discipline->find('list', array('conditions' => array('course_id' => $this->request->data[$this->Visit->alias]['course'])));
		}
		$cities = $this->Visit->City->superlist();
		$courses = $this->Visit->Discipline->Course->find('list');
		$this->set(compact('courses', 'teams', 'cities', 'disciplines'));
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
			$this->Flash->error(__('Invalid visit'));
			return $this->redirect(array('action' => 'index'));
		}
		$visit = $this->Visit->findById($id);
		if ($visit[$this->Visit->alias]['status'] < 4) {
			if($this->request->is('ajax')){
				$this->autoRender = false;
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
				if ($visit[$this->Visit->alias]['status'] !== '0') {
					$this->request->data[$this->Visit->alias]['status'] = '0';
				}
				if ($this->Visit->save($this->request->data)) {
					$visitOptions = array('conditions' => array('Visit.' . $this->Visit->primaryKey => $id));
					$visitInfo = $this->Visit->find('first', $visitOptions);
					$users = $this->Visit->User->usersAllowed('visits', 'transport_update', $this->Acl, array('fields' => array($this->Visit->User->alias.'.email')));
					$emails = implode(',', Set::classicExtract($users, '{n}.'.$this->Visit->User->alias.'.email'));
					$options['to'] = $emails;
					$options['template'] = 'visit_changed';
 					$options['subject'] = __('Visit to %s has been Changed! - Technical Visits', $visitInfo['Visit']['destination']);
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
				$this->request->data = $visit;
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
			$cities = $this->Visit->City->superlist();
			$disciplines = $this->Visit->Discipline->find('list', array('conditions' => array('course_id' => $this->request->data[$this->Visit->alias]['course'])));
			$courses = $this->Visit->Discipline->Course->find('list');
			$this->set(compact('teams', 'cities', 'disciplines', 'courses'));
		} else {
			$this->Flash->error(__('The visit is invalid or can not be changed.'));
			return $this->redirect(array('action' => 'index'));
		}
	}

	public function copy($id = null){
		if (!$this->Visit->exists($id)) {
			throw new NotFoundException(__('Invalid visit'));
		}
		$options = array('conditions' => array('Visit.' . $this->Visit->primaryKey => $id));
		$copy = $this->Visit->find('first', $options);
		$copy[$this->Visit->alias]['course'] = $copy[$this->Visit->Discipline->alias]['course_id'];
		$this->Session->write('copy', $copy);
		return $this->redirect(array('action' => 'add'));
	}

	public function information_update($id = null) {
		$this->Visit->id = $id;
		if (!$this->Visit->exists()) {
			$this->Flash->error(__('Invalid visit'));
			return $this->redirect(array('action' => 'index'));
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
			if ($this->Visit->save($this->request->data)) {
				$this->Flash->success(__('The visit has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The visit could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Visit->read();
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

	public function pre_approve_visit($id = null) {
		$this->Visit->id = $id;
		if (!$this->Visit->exists()) {
			$this->Flash->error(__('Invalid visit'));
			return $this->redirect(array('action' => 'index'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Visit->field('transport') == '0') {
				$this->request->data[$this->Visit->alias]['status'] = '1';
			} else {
				$this->request->data[$this->Visit->alias]['status'] = '2';
			}
			if ($this->Visit->save($this->request->data)) {
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

	public function download_report($id = null) {
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
		if (in_array($this->Visit->field('status'), array(1, 4, 6, 8))) {
			if ($this->request->is(array('post', 'put'))) {
				$data[$this->Visit->alias]['id'] = $this->request->data[$this->Visit->alias]['id'];
				$data[$this->Visit->alias]['transport'] = $this->request->data[$this->Visit->alias]['transport'];
				$data[$this->Visit->alias]['distance'] = $this->request->data[$this->Visit->alias]['distance'];
				$data[$this->Visit->alias]['transport_cost'] = $this->request->data[$this->Visit->alias]['transport_cost'];
				$data[$this->Visit->alias]['status'] = $this->Visit->field('status') + 1;
				if ($this->Visit->save($data)) {
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
				$statuses = $this->Visit->getEnums('status');
				$transports = $this->Visit->getEnums('transport');
				unset($transports[0]);
				unset($transports[1]);
				$costPerKm = 'Cost Per Km Campus R$ <b id="costPerKmCampus">'.CakeNumber::currency(Configure::read('Parameter.Transport.costPerKmCampus'), 'BRL').'</b></br>';
				$costPerKm .= 'Cost Per Km Outsourced R$ <b id="costPerKmOutsourced">'.CakeNumber::currency(Configure::read('Parameter.Transport.costPerKmOutsourced'), 'BRL').'</b>';
				$options = array(
					'conditions' => array(
						$this->Visit->alias.'.departure >=' => date('Y-m-d', strtotime($this->request->data[$this->Visit->alias]['departure'])),
						$this->Visit->alias.'.departure <' => date('Y-m-d', strtotime($this->request->data[$this->Visit->alias]['departure'].' + 1 day')),
						$this->Visit->alias.'.id <>' => $id,
						$this->Visit->alias.'.status <' => '4',
					),
					'recursive' => 2
				);
				$visits = $this->Visit->find('all', $options);

				$perms = $this->findPerms(array(
					array(
						'controller' => $this->Visit->table,
						'action' => 'copy',
					),
					array(
						'controller' => $this->Visit->table,
						'action' => 'view',
					),
					array(
						'controller' => $this->Visit->table,
						'action' => 'edit',
					),
					array(
						'controller' => $this->Visit->table,
						'action' => 'information_update',
					),
					array(
						'controller' => $this->Visit->table,
						'action' => 'transport_update',
					),
					array(
						'controller' => $this->Visit->Refusal->table,
						'action' => 'cancel',
					),
					array(
						'controller' => $this->Visit->Refusal->table,
						'action' => 'invalidate_visit',
					),
				));

				$this->set(compact('teams', 'cities', 'disciplines', 'states', 'courses', 'transports', 'costPerKm', 'statuses', 'visits', 'perms'));
		} else {
			return $this->redirect(array('action' => 'index'));
		}
	}

	public function notify_pending_report(){
		$date = date('Y-m-d 00:00:00', strtotime('- '.Configure::read('Parameter.System.notifyPendingReport').' days'));
		$options = array('conditions' => array(
				$this->Visit->alias.'.status' => array(4,5),
				$this->Visit->alias.'.arrival <=' => $date,
			)
		);
		$visits = $this->Visit->find('all', $options);
		foreach($visits as $visit){
			$options['to'] = $visit['User']['email'];
			$options['template'] = 'report_missing';
			$options['subject'] = __('Your visit to %s is missing report! - Technical Visits', $visit['Visit']['destination']);
			$options['visit'] = $visit;
			$this->sendMail($options);
		}
		die;
	}

	public function made_visits() {
		$optionsOwnTransport = array(
			$this->Visit->alias.'.arrival < ' => date('Y-m-d H:i:s'),
			$this->Visit->alias.'.status' => '3',
			$this->Visit->alias.'.transport' => '1',
		);
		$this->Visit->updateAll(array('status' => '5'), $optionsOwnTransport);
		$optionsNonOwnedTransport = array(
			$this->Visit->alias.'.arrival < ' => date('Y-m-d H:i:s'),
			$this->Visit->alias.'.status' => '3',
			$this->Visit->alias.'.transport > ' => '1',
		);
		$this->Visit->updateAll(array('status' => '4'), $optionsNonOwnedTransport);
		die;
	}

	public function notify_upcoming_visits(){
		$date = date('Y-m-d 23:59:59', strtotime('+ '.Configure::read('Parameter.System.notifyUpcomingVisits').' days'));
		$options = array('conditions' => array(
			$this->Visit->alias.'.departure <= ' => $date,
			$this->Visit->alias.'.status' => '3',
			)
		);
		$visits = $this->Visit->find('all', $options);
		foreach($visits as $visit){
			$options['to'] = $visit['User']['email'];
			$options['template'] = 'upcoming_visit';
			$options['subject'] = __('Your visit to %s is near! - Technical Visits', $visit['Visit']['destination']);
			$options['visit'] = $visit;
			$this->sendMail($options);
		}
		die;
	}
}
