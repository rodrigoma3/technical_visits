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
		$options = array(
			'conditions' => array(
				$this->Visit->alias.'.user_id' => $this->Auth->user('id'),
			),
			'fields' => array(
				$this->Visit->alias.'.id',
				$this->Visit->alias.'.user_id',
				$this->Visit->alias.'.status',
			),
		);
		$visits = $this->Visit->find('list', $options);
		$total = $this->Visit->find('count', $options);

		$status = $this->Visit->getEnums('status');
		$stats = array();
		foreach ($status as $id => $title) {
			if (isset($visits[$id])) {
				$quantity = count($visits[$id]);
			} else {
				$quantity = 0;
			}
			if ($total == 0) {
				$percent = CakeNumber::toPercentage(0);
			} else {
				$percent = CakeNumber::toPercentage(($quantity/$total)*100);
			}
			$stats[] = array(
				'title' => $title,
				'percent' => $percent,
				'quantity' => $quantity,
				'backgroundColor' => $this->randomColor(),
			);
		}

		$options = array(
			'fields' => array(
				$this->Visit->alias.'.destination AS title',
				$this->Visit->alias.'.departure AS start',
				$this->Visit->alias.'.arrival AS end',
			),
			'conditions' => array(
				$this->Visit->alias.'.user_id' => $this->Auth->user('id'),
				$this->Visit->alias.'.status < ' => '4',
			),
			'recursive' => -1
		);
		$eventsOpened = $this->Visit->find('all', $options);
		if(!empty($eventsOpened)){
				$eventsOpened = Set::classicExtract($eventsOpened, '{n}.'.$this->Visit->alias);
				$eventsOpened = Set::insert($eventsOpened, '{n}.color', 'blue');
		}

		$options = array(
			'fields' => array(
				$this->Visit->alias.'.destination AS title',
				$this->Visit->alias.'.departure AS start',
				$this->Visit->alias.'.arrival AS end',
			),
			'conditions' => array(
				$this->Visit->alias.'.user_id' => $this->Auth->user('id'),
				$this->Visit->alias.'.status > ' => '3',
				$this->Visit->alias.'.status < ' => '10',
			),
			'recursive' => -1
		);
		$eventsHeld = $this->Visit->find('all', $options);
		if(!empty($eventsHeld)){
				$eventsHeld = Set::classicExtract($eventsHeld, '{n}.'.$this->Visit->alias);
				$eventsHeld = Set::insert($eventsHeld, '{n}.color', 'green');
		}

		$events = array_merge($eventsOpened, $eventsHeld);
		$events = json_encode($events);

		$this->set(compact('stats', 'events'));
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

	public function general_analysis() {
		$charts = array(
			array(
				'icon' => 'fa fa-pie-chart',
				'title' => __('Total of visits x frequency of students'),
				'controller' => 'visits',
				'action' => 'visits_x_frequency_of_students',
				'allow' => false,
			),
			array(
				'icon' => 'fa fa-pie-chart',
				'title' => __('Total of visits x long and short distance'),
				'controller' => 'visits',
				'action' => 'visits_x_long_short_distance',
				'allow' => false,
			),
			array(
				'icon' => 'fa fa-bar-chart',
				'title' => __('Course x visits'),
				'controller' => 'visits',
				'action' => 'course_x_visits',
				'allow' => false,
			),
			array(
				'icon' => 'fa fa-bar-chart',
				'title' => __('Course x mileage'),
				'controller' => 'visits',
				'action' => 'course_x_mileage',
				'allow' => false,
			),
			array(
				'icon' => 'fa fa-bar-chart',
				'title' => __('Course x total cost'),
				'controller' => 'visits',
				'action' => 'course_x_cost',
				'allow' => false,
			),
			array(
				'icon' => 'fa fa-bar-chart',
				'title' => __('User x visits'),
				'controller' => 'visits',
				'action' => 'user_x_visits',
				'allow' => false,
			),
			array(
				'icon' => 'fa fa-bar-chart',
				'title' => __('User x mileage'),
				'controller' => 'visits',
				'action' => 'user_x_mileage',
				'allow' => false,
			),
			array(
				'icon' => 'fa fa-bar-chart',
				'title' => __('User x total cost'),
				'controller' => 'visits',
				'action' => 'user_x_cost',
				'allow' => false,
			),
			array(
				'icon' => 'fa fa-bar-chart',
				'title' => __('Visits x status'),
				'controller' => 'visits',
				'action' => 'visits_x_status',
				'allow' => false,
			),
			array(
				'icon' => 'fa fa-bar-chart',
				'title' => __('Visits x city'),
				'controller' => 'visits',
				'action' => 'visits_x_city',
				'allow' => false,
			),
			array(
				'icon' => 'fa fa-bar-chart',
				'title' => __('Visits x destination'),
				'controller' => 'visits',
				'action' => 'visits_x_destination',
				'allow' => false,
			),
			array(
				'icon' => 'fa fa-bar-chart',
				'title' => __('Mileage x total cost per type of transport'),
				'controller' => 'visits',
				'action' => 'mileage_x_cost_per_type_transport',
				'allow' => false,
			),
			array(
				'icon' => 'fa fa-bar-chart',
				'title' => __('Total of visits x long and short distance per type of transport'),
				'controller' => 'visits',
				'action' => 'visits_x_long_short_distance_per_type_transport',
				'allow' => false,
			),
			array(
				'icon' => 'fa fa-bar-chart',
				'title' => __('Total of visits x long and short distance x mileage per type of transport'),
				'controller' => 'visits',
				'action' => 'visits_x_long_short_distance_x_mileage_per_type_transport',
				'allow' => false,
			),
			array(
				'icon' => 'fa fa-bar-chart',
				'title' => __('Total of visits x long and short distance x total cost per type of transport'),
				'controller' => 'visits',
				'action' => 'visits_x_long_short_distance_x_cost_per_type_transport',
				'allow' => false,
			),
			array(
				'icon' => 'fa fa-bar-chart',
				'title' => __('Mileage x total cost per total of visits x long and short distance'),
				'controller' => 'visits',
				'action' => 'mileage_x_cost_per_visits_x_long_short_distance',
				'allow' => false,
			),
		);

		foreach ($charts as $k => $chart) {
			$charts[$k]['allow'] = $this->Acl->check(array('User' => $this->Auth->user()), $chart['controller'].'/'.$chart['action']);
		}

		$this->set(compact('charts'));
	}

	public function visits_x_frequency_of_students() {
		$options = array(
			'conditions' => array(
				$this->Visit->alias.'.status > ' => '3',
			),
			'fields' => array(
				$this->Visit->alias.'.id',
				'('.$this->Visit->alias.'.number_of_students_present/'.$this->Visit->alias.'.number_of_students*100) AS frequency',
			),
		);
		$visits = $this->Visit->find('all', $options);
		$frequency = array();
		foreach ($visits as $visit) {
			$frequency[($visit[0]['frequency'] > 75)][] = 1;
		}

		if (isset($frequency[0]) && !empty($frequency[0])) {
			$frequency[0] = count($frequency[0]);
		} else {
			$frequency[0] = 0;
		}
		if (isset($frequency[1]) && !empty($frequency[1])) {
			$frequency[1] = count($frequency[1]);
		} else {
			$frequency[1] = 0;
		}

		$data = json_encode(array($frequency[0], $frequency[1], ($frequency[0]+$frequency[1])));
		$labels = json_encode(array(__('Less than 75%'), __('Greater than 75%'), __('Total technical visits')));
		$backgroundColor = json_encode(array($this->randomColor(), $this->randomColor(), $this->randomColor()));
		$this->set(compact('data', 'labels', 'backgroundColor'));
	}

	public function visits_x_long_short_distance() {
		$options = array(
			'fields' => array(
				$this->Visit->alias.'.id',
				$this->Visit->alias.'.city_id',
				$this->Visit->City->alias.'.short_distance',
			),
			'joins' => array(
				array(
					'table' => $this->Visit->City->table,
					'alias' => $this->Visit->City->alias,
					'type' => 'LEFT',
					'conditions' => array(
						$this->Visit->alias.'.city_id = '.$this->Visit->City->alias.'.id'
					)
				)
			),
		);
		$visits = $this->Visit->find('list', $options);

		$short = 0;
		$long = 0;
		if (isset($visits[0]) && !empty($visits[0])) {
			$long = count($visits[0]);
		}
		if (isset($visits[1]) && !empty($visits[1])) {
			$short = count($visits[1]);
		}

		$data = json_encode(array($short, $long, ($short+$long)));
		$labels = json_encode(array(__('Short distance'), __('Long distance'), __('Total technical visits')));
		$backgroundColor = json_encode(array($this->randomColor(), $this->randomColor(), $this->randomColor()));
		$this->set(compact('data', 'labels', 'backgroundColor'));
	}

	public function visits_x_long_short_distance_per_type_transport() {
		$options = array(
			'fields' => array(
				$this->Visit->alias.'.id',
				$this->Visit->City->alias.'.short_distance',
				$this->Visit->alias.'.transport',
			),
			'joins' => array(
				array(
					'table' => $this->Visit->City->table,
					'alias' => $this->Visit->City->alias,
					'type' => 'LEFT',
					'conditions' => array(
						$this->Visit->alias.'.city_id = '.$this->Visit->City->alias.'.id'
					)
				)
			),
		);
		$visits = $this->Visit->find('list', $options);
		$transports = $this->Visit->getEnums('transport');

		$tmb = array();
		foreach ($visits as $transport => $distance) {
			foreach ($distance as $id => $shortDistance) {
				if (!isset($tmb[$transports[$transport]][$shortDistance]) || empty($tmb[$transports[$transport]][$shortDistance])) {
					$tmb[$transports[$transport]][$shortDistance] = 0;
				}
				if (!isset($tmb[$transports[$transport]]['totalVisits']) || empty($tmb[$transports[$transport]]['totalVisits'])) {
					$tmb[$transports[$transport]]['totalVisits'] = 0;
				}
				$tmb[$transports[$transport]][$shortDistance] = $tmb[$transports[$transport]][$shortDistance] + 1;
				$tmb[$transports[$transport]]['totalVisits'] = $tmb[$transports[$transport]]['totalVisits'] + 1;
			}
		}
		$shortDistanceFalse = array();
		$shortDistanceTrue = array();
		$totalVisits = array();
		foreach ($tmb as $transportType => $content) {
			$shortDistanceFalse[] = $content[false];
			$shortDistanceTrue[] = $content[true];
			$totalVisits[] = $content['totalVisits'];
			$labels[] = $transportType;
		}
		$backgroundColorShortDistanceFalse = $this->randomColor();
		$backgroundColorShortDistanceTrue = $this->randomColor();
		$backgroundColorTotalVisits = $this->randomColor();
		$datasets = array();
		$datasets[] = array(
			'label' => __('Long distance'),
			'data' => $shortDistanceFalse,
			'backgroundColor' => array($backgroundColorShortDistanceFalse, $backgroundColorShortDistanceFalse, $backgroundColorShortDistanceFalse, $backgroundColorShortDistanceFalse),
			'borderWidth' => 1,
		);
		$datasets[] = array(
			'label' => __('Short distance'),
			'data' => $shortDistanceTrue,
			'backgroundColor' => array($backgroundColorShortDistanceTrue, $backgroundColorShortDistanceTrue, $backgroundColorShortDistanceTrue, $backgroundColorShortDistanceTrue),
			'borderWidth' => 1,
		);
		$datasets[] = array(
			'label' => __('Total technical visits'),
			'data' => $totalVisits,
			'backgroundColor' => array($backgroundColorTotalVisits, $backgroundColorTotalVisits, $backgroundColorTotalVisits, $backgroundColorTotalVisits),
			'borderWidth' => 1,
		);

		$datasets = json_encode($datasets);
		$labels = json_encode($labels);
		$this->set(compact('datasets', 'labels'));
	}

	public function visits_x_long_short_distance_x_mileage_per_type_transport() {
		$options = array(
			'fields' => array(
				$this->Visit->alias.'.id',
				$this->Visit->alias.'.distance',
				$this->Visit->City->alias.'.short_distance',
				$this->Visit->alias.'.transport',
			),
		);
		$visits = $this->Visit->find('all', $options);

		$tmb = array();
		foreach ($visits as $visit) {
			if (!isset($tmb[$visit['Transport']['name']][$visit[$this->Visit->City->alias]['short_distance']]) || empty($tmb[$visit['Transport']['name']][$visit[$this->Visit->City->alias]['short_distance']])) {
				$tmb[$visit['Transport']['name']][$visit[$this->Visit->City->alias]['short_distance']] = 0;
			}
			if (!isset($tmb[$visit['Transport']['name']]['totalVisits']) || empty($tmb[$visit['Transport']['name']]['totalVisits'])) {
				$tmb[$visit['Transport']['name']]['totalVisits'] = 0;
			}
			if (!isset($tmb[$visit['Transport']['name']]['totalDistance']) || empty($tmb[$visit['Transport']['name']]['totalDistance'])) {
				$tmb[$visit['Transport']['name']]['totalDistance'] = 0;
			}
			$tmb[$visit['Transport']['name']][$visit[$this->Visit->City->alias]['short_distance']] = $tmb[$visit['Transport']['name']][$visit[$this->Visit->City->alias]['short_distance']] + 1;
			$tmb[$visit['Transport']['name']]['totalDistance'] = CakeNumber::precision($tmb[$visit['Transport']['name']]['totalDistance'] + $visit[$this->Visit->alias]['distance'], 2);
			$tmb[$visit['Transport']['name']]['totalVisits'] = $tmb[$visit['Transport']['name']]['totalVisits'] + 1;
		}
		$shortDistanceFalse = array();
		$shortDistanceTrue = array();
		$totalDistance = array();
		$totalVisits = array();
		foreach ($tmb as $transportType => $content) {
			$shortDistanceFalse[] = $content[false];
			$shortDistanceTrue[] = $content[true];
			$totalDistance[] = $content['totalDistance'];
			$totalVisits[] = $content['totalVisits'];
			$labels[] = $transportType;
		}
		$backgroundColorShortDistanceFalse = $this->randomColor();
		$backgroundColorShortDistanceTrue = $this->randomColor();
		$backgroundColorTotalDistance = $this->randomColor();
		$backgroundColorTotalVisits = $this->randomColor();
		$datasets = array();
		$datasets[] = array(
			'label' => __('Long distance'),
			'data' => $shortDistanceFalse,
			'backgroundColor' => array($backgroundColorShortDistanceFalse, $backgroundColorShortDistanceFalse, $backgroundColorShortDistanceFalse, $backgroundColorShortDistanceFalse),
			'borderWidth' => 1,
		);
		$datasets[] = array(
			'label' => __('Short distance'),
			'data' => $shortDistanceTrue,
			'backgroundColor' => array($backgroundColorShortDistanceTrue, $backgroundColorShortDistanceTrue, $backgroundColorShortDistanceTrue, $backgroundColorShortDistanceTrue),
			'borderWidth' => 1,
		);
		$datasets[] = array(
			'label' => __('Total distance'),
			'data' => $totalDistance,
			'backgroundColor' => array($backgroundColorTotalDistance, $backgroundColorTotalDistance, $backgroundColorTotalDistance, $backgroundColorTotalDistance),
			'borderWidth' => 1,
		);
		$datasets[] = array(
			'label' => __('Total technical visits'),
			'data' => $totalVisits,
			'backgroundColor' => array($backgroundColorTotalVisits, $backgroundColorTotalVisits, $backgroundColorTotalVisits, $backgroundColorTotalVisits),
			'borderWidth' => 1,
		);

		$datasets = json_encode($datasets);
		$labels = json_encode($labels);
		$this->set(compact('datasets', 'labels'));
	}

	public function visits_x_long_short_distance_x_cost_per_type_transport() {
		$options = array(
			'fields' => array(
				$this->Visit->alias.'.id',
				$this->Visit->alias.'.refund',
				$this->Visit->alias.'.transport_cost',
				$this->Visit->City->alias.'.short_distance',
				$this->Visit->alias.'.transport',
			),
		);
		$visits = $this->Visit->find('all', $options);

		$tmb = array();
		foreach ($visits as $visit) {
			if (!isset($tmb[$visit['Transport']['name']][$visit[$this->Visit->City->alias]['short_distance']]) || empty($tmb[$visit['Transport']['name']][$visit[$this->Visit->City->alias]['short_distance']])) {
				$tmb[$visit['Transport']['name']][$visit[$this->Visit->City->alias]['short_distance']] = 0;
			}
			if (!isset($tmb[$visit['Transport']['name']]['totalVisits']) || empty($tmb[$visit['Transport']['name']]['totalVisits'])) {
				$tmb[$visit['Transport']['name']]['totalVisits'] = 0;
			}
			if (!isset($tmb[$visit['Transport']['name']]['totalCost']) || empty($tmb[$visit['Transport']['name']]['totalCost'])) {
				$tmb[$visit['Transport']['name']]['totalCost'] = 0;
			}
			$tmb[$visit['Transport']['name']][$visit[$this->Visit->City->alias]['short_distance']] = $tmb[$visit['Transport']['name']][$visit[$this->Visit->City->alias]['short_distance']] + 1;
			$tmb[$visit['Transport']['name']]['totalCost'] = CakeNumber::precision($tmb[$visit['Transport']['name']]['totalCost'] + $visit[$this->Visit->alias]['refund'] + $visit[$this->Visit->alias]['transport_cost'], 2);
			$tmb[$visit['Transport']['name']]['totalVisits'] = $tmb[$visit['Transport']['name']]['totalVisits'] + 1;
		}
		$shortDistanceFalse = array();
		$shortDistanceTrue = array();
		$totalCost = array();
		$totalVisits = array();
		foreach ($tmb as $transportType => $content) {
			$shortDistanceFalse[] = $content[false];
			$shortDistanceTrue[] = $content[true];
			$totalCost[] = $content['totalCost'];
			$totalVisits[] = $content['totalVisits'];
			$labels[] = $transportType;
		}
		$backgroundColorShortDistanceFalse = $this->randomColor();
		$backgroundColorShortDistanceTrue = $this->randomColor();
		$backgroundColorTotalCost = $this->randomColor();
		$backgroundColorTotalVisits = $this->randomColor();
		$datasets = array();
		$datasets[] = array(
			'label' => __('Long distance'),
			'data' => $shortDistanceFalse,
			'backgroundColor' => array($backgroundColorShortDistanceFalse, $backgroundColorShortDistanceFalse, $backgroundColorShortDistanceFalse, $backgroundColorShortDistanceFalse),
			'borderWidth' => 1,
		);
		$datasets[] = array(
			'label' => __('Short distance'),
			'data' => $shortDistanceTrue,
			'backgroundColor' => array($backgroundColorShortDistanceTrue, $backgroundColorShortDistanceTrue, $backgroundColorShortDistanceTrue, $backgroundColorShortDistanceTrue),
			'borderWidth' => 1,
		);
		$datasets[] = array(
			'label' => __('Total cost'),
			'data' => $totalCost,
			'backgroundColor' => array($backgroundColorTotalCost, $backgroundColorTotalCost, $backgroundColorTotalCost, $backgroundColorTotalCost),
			'borderWidth' => 1,
		);
		$datasets[] = array(
			'label' => __('Total technical visits'),
			'data' => $totalVisits,
			'backgroundColor' => array($backgroundColorTotalVisits, $backgroundColorTotalVisits, $backgroundColorTotalVisits, $backgroundColorTotalVisits),
			'borderWidth' => 1,
		);

		$datasets = json_encode($datasets);
		$labels = json_encode($labels);
		$this->set(compact('datasets', 'labels'));
	}

	public function mileage_x_cost_per_type_transport() {
		$options = array(
			'conditions' => array(
				$this->Visit->alias.'.status > ' => '3',
			),
			'fields' => array(
				$this->Visit->alias.'.id',
				$this->Visit->alias.'.distance',
				$this->Visit->alias.'.refund',
				$this->Visit->alias.'.transport_cost',
				$this->Visit->alias.'.transport',
			),
		);
		$visits = $this->Visit->find('all', $options);

		$tmb = array();
		foreach ($visits as $visit) {
			$totalCost = CakeNumber::precision(($visit[$this->Visit->alias]['refund'] + $visit[$this->Visit->alias]['transport_cost']), 2);
			if (!isset($tmb[$visit['Transport']['name']]['totalCost']) || empty($tmb[$visit['Transport']['name']]['totalCost'])) {
				$tmb[$visit['Transport']['name']]['totalCost'] = 0;
			}
			if (!isset($tmb[$visit['Transport']['name']]['totalDistance']) || empty($tmb[$visit['Transport']['name']]['totalDistance'])) {
				$tmb[$visit['Transport']['name']]['totalDistance'] = 0;
			}
			if (!isset($tmb[$visit['Transport']['name']]['totalVisits']) || empty($tmb[$visit['Transport']['name']]['totalVisits'])) {
				$tmb[$visit['Transport']['name']]['totalVisits'] = 0;
			}
			$tmb[$visit['Transport']['name']]['totalCost'] = $tmb[$visit['Transport']['name']]['totalCost'] + $totalCost;
			$tmb[$visit['Transport']['name']]['totalDistance'] = $tmb[$visit['Transport']['name']]['totalDistance'] + $visit[$this->Visit->alias]['distance'];
			$tmb[$visit['Transport']['name']]['totalVisits'] = $tmb[$visit['Transport']['name']]['totalVisits'] + 1;
		}
		$totalCost = array();
		$totalDistance = array();
		$totalVisits = array();
		foreach ($tmb as $transportType => $content) {
			$totalCost[] = $content['totalCost'];
			$totalDistance[] = $content['totalDistance'];
			$totalVisits[] = $content['totalVisits'];
			$labels[] = $transportType;
		}
		$backgroundColorTotalCost = $this->randomColor();
		$backgroundColorTotalDistance = $this->randomColor();
		$backgroundColorTotalVisits = $this->randomColor();
		$datasets = array();
		$datasets[] = array(
			'label' => __('Total cost'),
			'data' => $totalCost,
			'backgroundColor' => array($backgroundColorTotalCost, $backgroundColorTotalCost, $backgroundColorTotalCost, $backgroundColorTotalCost),
			'borderWidth' => 1,
		);
		$datasets[] = array(
			'label' => __('Total distance'),
			'data' => $totalDistance,
			'backgroundColor' => array($backgroundColorTotalDistance, $backgroundColorTotalDistance, $backgroundColorTotalDistance, $backgroundColorTotalDistance),
			'borderWidth' => 1,
		);
		$datasets[] = array(
			'label' => __('Total technical visits'),
			'data' => $totalVisits,
			'backgroundColor' => array($backgroundColorTotalVisits, $backgroundColorTotalVisits, $backgroundColorTotalVisits, $backgroundColorTotalVisits),
			'borderWidth' => 1,
		);

		$datasets = json_encode($datasets);
		$labels = json_encode($labels);
		$this->set(compact('datasets', 'labels'));
	}

	public function mileage_x_cost_per_visits_x_long_short_distance() {
		$options = array(
			'fields' => array(
				$this->Visit->alias.'.id',
				$this->Visit->alias.'.distance',
				$this->Visit->alias.'.refund',
				$this->Visit->alias.'.transport_cost',
				$this->Visit->City->alias.'.short_distance',
			),
		);
		$visits = $this->Visit->find('all', $options);

		$tmb = array();
		foreach ($visits as $visit) {
			if (!isset($tmb[$visit[$this->Visit->City->alias]['short_distance']]['totalDistance']) || empty($tmb[$visit[$this->Visit->City->alias]['short_distance']]['totalDistance'])) {
				$tmb[$visit[$this->Visit->City->alias]['short_distance']]['totalDistance'] = 0;
			}
			if (!isset($tmb[$visit[$this->Visit->City->alias]['short_distance']]['totalCost']) || empty($tmb[$visit[$this->Visit->City->alias]['short_distance']]['totalCost'])) {
				$tmb[$visit[$this->Visit->City->alias]['short_distance']]['totalCost'] = 0;
			}
			if (!isset($tmb[$visit[$this->Visit->City->alias]['short_distance']]['totalVisits']) || empty($tmb[$visit[$this->Visit->City->alias]['short_distance']]['totalVisits'])) {
				$tmb[$visit[$this->Visit->City->alias]['short_distance']]['totalVisits'] = 0;
			}
			if (!isset($tmb[3]['totalDistance']) || empty($tmb[3]['totalDistance'])) {
				$tmb[3]['totalDistance'] = 0;
			}
			if (!isset($tmb[3]['totalCost']) || empty($tmb[3]['totalCost'])) {
				$tmb[3]['totalCost'] = 0;
			}
			if (!isset($tmb[3]['totalVisits']) || empty($tmb[3]['totalVisits'])) {
				$tmb[3]['totalVisits'] = 0;
			}
			$tmb[$visit[$this->Visit->City->alias]['short_distance']]['totalDistance'] = CakeNumber::precision($tmb[$visit[$this->Visit->City->alias]['short_distance']]['totalDistance'] + $visit[$this->Visit->alias]['distance'], 2);
			$tmb[$visit[$this->Visit->City->alias]['short_distance']]['totalCost'] = CakeNumber::precision($tmb[$visit[$this->Visit->City->alias]['short_distance']]['totalCost'] + $visit[$this->Visit->alias]['refund'] + $visit[$this->Visit->alias]['transport_cost'], 2);
			$tmb[$visit[$this->Visit->City->alias]['short_distance']]['totalVisits'] = $tmb[$visit[$this->Visit->City->alias]['short_distance']]['totalVisits'] + 1;
			$tmb[3]['totalDistance'] = CakeNumber::precision($tmb[3]['totalDistance'] + $tmb[$visit[$this->Visit->City->alias]['short_distance']]['totalDistance'], 2);
			$tmb[3]['totalCost'] = CakeNumber::precision($tmb[3]['totalCost'] + $tmb[$visit[$this->Visit->City->alias]['short_distance']]['totalCost'], 2);
			$tmb[3]['totalVisits'] = $tmb[3]['totalVisits'] + 1;
		}
		asort($tmb);
		$totalDistance = array();
		$totalCost = array();
		$totalVisits = array();
		foreach ($tmb as $label => $content) {
			$totalDistance[] = $content['totalDistance'];
			$totalCost[] = $content['totalCost'];
			$totalVisits[] = $content['totalVisits'];
			$labels[] = Set::enum($label, array(1 => __('Short distance'), 0 => __('Long distance'), 3 => __('Total Visits')));
		}
		$backgroundColorTotalDistance = $this->randomColor();
		$backgroundColorTotalCost = $this->randomColor();
		$backgroundColorTotalVisits = $this->randomColor();
		$datasets = array();
		$datasets[] = array(
			'label' => __('Total cost'),
			'data' => $totalCost,
			'backgroundColor' => array($backgroundColorTotalCost, $backgroundColorTotalCost, $backgroundColorTotalCost),
			'borderWidth' => 1,
		);
		$datasets[] = array(
			'label' => __('Total distance'),
			'data' => $totalDistance,
			'backgroundColor' => array($backgroundColorTotalDistance, $backgroundColorTotalDistance, $backgroundColorTotalDistance),
			'borderWidth' => 1,
		);
		$datasets[] = array(
			'label' => __('Total technical visits'),
			'data' => $totalVisits,
			'backgroundColor' => array($backgroundColorTotalVisits, $backgroundColorTotalVisits, $backgroundColorTotalVisits),
			'borderWidth' => 1,
		);

		$datasets = json_encode($datasets);
		$labels = json_encode($labels);
		$this->set(compact('datasets', 'labels'));
	}

	public function visits_x_city() {
		$options = array(
			'fields' => array(
				$this->Visit->alias.'.id',
				$this->Visit->alias.'.city_id',
				$this->Visit->City->alias.'.name',
			),
			'joins' => array(
				array(
					'table' => $this->Visit->City->table,
					'alias' => $this->Visit->City->alias,
					'type' => 'INNER',
					'conditions' => array(
						$this->Visit->alias.'.city_id = '.$this->Visit->City->alias.'.id'
					)
				)
			),
		);
		$visits = $this->Visit->find('list', $options);

		$data = array();
		$label = array();
		$backgroundColor = array();
		foreach ($visits as $city => $list) {
			$data[] = count($list);
			$label[] = $city;
			$backgroundColor[] = $this->randomColor();
		}

		$data = json_encode($data);
		$labels = json_encode($label);
		$backgroundColor = json_encode($backgroundColor);
		$this->set(compact('data', 'labels', 'backgroundColor'));
	}

	public function visits_x_destination() {
		$options = array(
			'fields' => array(
				$this->Visit->alias.'.id',
				$this->Visit->alias.'.status',
				$this->Visit->alias.'.destination',
			),
		);
		$visits = $this->Visit->find('list', $options);

		$data = array();
		$label = array();
		$backgroundColor = array();
		foreach ($visits as $destination => $list) {
			$data[] = count($list);
			$label[] = $destination;
			$backgroundColor[] = $this->randomColor();
		}

		$data = json_encode($data);
		$labels = json_encode($label);
		$backgroundColor = json_encode($backgroundColor);
		$this->set(compact('data', 'labels', 'backgroundColor'));
	}

	public function visits_x_status() {
		$options = array(
			'fields' => array(
				$this->Visit->alias.'.id',
				$this->Visit->alias.'.user_id',
				$this->Visit->alias.'.status',
			),
		);
		$visits = $this->Visit->find('list', $options);
		$status = $this->Visit->getEnums('status');
		$data = array();
		$label = array();
		foreach ($status as $id => $title) {
			if (isset($visits[$id]) && !empty($visits[$id])) {
				$data[] = count($visits[$id]);
			} else {
				$data[] = 0;
			}
			$label[] = $title;
			$backgroundColor[] = $this->randomColor();
		}

		$data = json_encode($data);
		$labels = json_encode($label);
		$backgroundColor = json_encode($backgroundColor);
		$this->set(compact('data', 'labels', 'backgroundColor'));
	}

	public function course_x_visits() {
		$options = array(
			'fields' => array(
				$this->Visit->alias.'.id',
				$this->Visit->Discipline->Course->alias.'.id',
				$this->Visit->Discipline->Course->alias.'.name',
			),
			'joins' => array(
				array(
					'table' => $this->Visit->Discipline->table,
					'alias' => $this->Visit->Discipline->alias,
					'type' => 'INNER',
					'conditions' => array(
						$this->Visit->alias.'.discipline_id = '.$this->Visit->Discipline->alias.'.id'
					)
				),
				array(
					'table' => $this->Visit->Discipline->Course->table,
					'alias' => $this->Visit->Discipline->Course->alias,
					'type' => 'INNER',
					'conditions' => array(
						$this->Visit->Discipline->alias.'.course_id = '.$this->Visit->Discipline->Course->alias.'.id'
					)
				)
			),
		);
		$visits = $this->Visit->find('list', $options);

		$data = array();
		$label = array();
		$backgroundColor = array();
		foreach ($visits as $course => $list) {
			$data[] = count($list);
			$label[] = $course;
			$backgroundColor[] = $this->randomColor();
		}

		$data = json_encode($data);
		$labels = json_encode($label);
		$backgroundColor = json_encode($backgroundColor);
		$this->set(compact('data', 'labels', 'backgroundColor'));
	}

	public function course_x_mileage() {
		$options = array(
			'fields' => array(
				$this->Visit->alias.'.id',
				$this->Visit->alias.'.distance',
				$this->Visit->Discipline->Course->alias.'.name',
			),
			'joins' => array(
				array(
					'table' => $this->Visit->Discipline->table,
					'alias' => $this->Visit->Discipline->alias,
					'type' => 'INNER',
					'conditions' => array(
						$this->Visit->alias.'.discipline_id = '.$this->Visit->Discipline->alias.'.id'
					)
				),
				array(
					'table' => $this->Visit->Discipline->Course->table,
					'alias' => $this->Visit->Discipline->Course->alias,
					'type' => 'INNER',
					'conditions' => array(
						$this->Visit->Discipline->alias.'.course_id = '.$this->Visit->Discipline->Course->alias.'.id'
					)
				)
			),
		);
		$visits = $this->Visit->find('list', $options);

		$data = array();
		$label = array();
		$backgroundColor = array();
		foreach ($visits as $course => $list) {
			$data[] = CakeNumber::precision(array_sum($list), 2);
			$label[] = $course;
			$backgroundColor[] = $this->randomColor();
		}

		$data = json_encode($data);
		$labels = json_encode($label);
		$backgroundColor = json_encode($backgroundColor);
		$this->set(compact('data', 'labels', 'backgroundColor'));
	}

	public function course_x_cost() {
		$options = array(
			'fields' => array(
				$this->Visit->alias.'.id',
				$this->Visit->alias.'.refund',
				$this->Visit->alias.'.transport_cost',
				$this->Visit->Discipline->Course->alias.'.name',
			),
			'joins' => array(
				array(
					'table' => $this->Visit->Discipline->Course->table,
					'alias' => $this->Visit->Discipline->Course->alias,
					'type' => 'INNER',
					'conditions' => array(
						$this->Visit->Discipline->alias.'.course_id = '.$this->Visit->Discipline->Course->alias.'.id'
					)
				)
			),
		);
		$visits = $this->Visit->find('all', $options);

		$tmp = array();
		foreach ($visits as $visit) {
			$sum = CakeNumber::precision(($visit[$this->Visit->alias]['refund'] + $visit[$this->Visit->alias]['transport_cost']), 2);
			if (!isset($tmp[$visit[$this->Visit->Discipline->Course->alias]['name']]) || empty($tmp[$visit[$this->Visit->Discipline->Course->alias]['name']])) {
				$tmp[$visit[$this->Visit->Discipline->Course->alias]['name']] = 0;
			}
			$tmp[$visit[$this->Visit->Discipline->Course->alias]['name']] = $tmp[$visit[$this->Visit->Discipline->Course->alias]['name']] + $sum;
		}
		for ($i=0; $i < count($tmp); $i++) {
			$backgroundColor[] = $this->randomColor();
		}

		$data = json_encode(array_values($tmp));
		$labels = json_encode(array_keys($tmp));
		$backgroundColor = json_encode($backgroundColor);
		$this->set(compact('data', 'labels', 'backgroundColor'));
	}

	public function user_x_visits() {
		$options = array(
			'fields' => array(
				$this->Visit->alias.'.id',
				$this->Visit->alias.'.user_id',
				$this->Visit->User->alias.'.name',
			),
			'joins' => array(
				array(
					'table' => $this->Visit->User->table,
					'alias' => $this->Visit->User->alias,
					'type' => 'INNER',
					'conditions' => array(
						$this->Visit->alias.'.user_id = '.$this->Visit->User->alias.'.id'
					)
				)
			),
		);
		$visits = $this->Visit->find('list', $options);

		$data = array();
		$label = array();
		$backgroundColor = array();
		foreach ($visits as $user => $list) {
			$data[] = count($list);
			$label[] = $user;
			$backgroundColor[] = $this->randomColor();
		}

		$data = json_encode($data);
		$labels = json_encode($label);
		$backgroundColor = json_encode($backgroundColor);
		$this->set(compact('data', 'labels', 'backgroundColor'));
	}

	public function user_x_mileage() {
		$options = array(
			'fields' => array(
				$this->Visit->alias.'.id',
				$this->Visit->alias.'.distance',
				$this->Visit->User->alias.'.name',
			),
			'joins' => array(
				array(
					'table' => $this->Visit->User->table,
					'alias' => $this->Visit->User->alias,
					'type' => 'INNER',
					'conditions' => array(
						$this->Visit->alias.'.user_id = '.$this->Visit->User->alias.'.id'
					)
				)
			),
		);
		$visits = $this->Visit->find('list', $options);

		$data = array();
		$label = array();
		$backgroundColor = array();
		foreach ($visits as $user => $list) {
			$data[] = CakeNumber::precision(array_sum($list), 2);
			$label[] = $user;
			$backgroundColor[] = $this->randomColor();
		}

		$data = json_encode($data);
		$labels = json_encode($label);
		$backgroundColor = json_encode($backgroundColor);
		$this->set(compact('data', 'labels', 'backgroundColor'));
	}

	public function user_x_cost() {
		$options = array(
			'fields' => array(
				$this->Visit->alias.'.id',
				$this->Visit->alias.'.refund',
				$this->Visit->alias.'.transport_cost',
				$this->Visit->User->alias.'.name',
			),
		);
		$visits = $this->Visit->find('all', $options);

		$tmp = array();
		foreach ($visits as $visit) {
			$sum = CakeNumber::precision(($visit[$this->Visit->alias]['refund'] + $visit[$this->Visit->alias]['transport_cost']), 2);
			if (!isset($tmp[$visit[$this->Visit->User->alias]['name']]) || empty($tmp[$visit[$this->Visit->User->alias]['name']])) {
				$tmp[$visit[$this->Visit->User->alias]['name']] = 0;
			}
			$tmp[$visit[$this->Visit->User->alias]['name']] = $tmp[$visit[$this->Visit->User->alias]['name']] + $sum;
		}
		for ($i=0; $i < count($tmp); $i++) {
			$backgroundColor[] = $this->randomColor();
		}

		$data = json_encode(array_values($tmp));
		$labels = json_encode(array_keys($tmp));
		$backgroundColor = json_encode($backgroundColor);
		$this->set(compact('data', 'labels', 'backgroundColor'));
	}

}
