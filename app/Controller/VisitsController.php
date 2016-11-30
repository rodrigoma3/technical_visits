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
		$visits = $this->Visit->find('all', array('conditions' => array($this->Visit->alias.'.visit_id_edit' => 0)));
		$courses = $this->Visit->Discipline->Course->find('list');
		$transportUpdater = $this->Acl->check(array('User' => $this->Auth->user()), $this->Visit->table.'/transport_update');
		$reviewerChange = $this->Acl->check(array('User' => $this->Auth->user()), $this->Visit->table.'/review_change');
		$this->set(compact('visits', 'courses', 'transportUpdater', 'reviewerChange'));
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
			$this->Flash->error(__('Invalid visit'));
			return $this->redirect(array('action' => 'index'));
		}
		$visit = $this->Visit->findById($id);
		if ($visit[$this->Visit->alias]['status'] < 4) {
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
				if ($visit[$this->Visit->alias]['status'] !== '0') {
					// $options = array('conditions' => array($this->Visit->alias.'.id' => $id), 'recursive' => -1);
					// $data = $this->Visit->find('first', $options);
					if ($visit[$this->Visit->alias]['transport'] > 1) {
						if ($this->request->data[$this->Visit->alias]['transport'] === '1') {
							$this->request->data[$this->Visit->alias]['transport_cost'] = '0';
							$this->request->data[$this->Visit->alias]['distance'] = '0';
						} else {
							unset($this->request->data[$this->Visit->alias]['transport']);
						}
					}
					if ($this->request->data[$this->Visit->alias]['city_id'] !== $visit[$this->Visit->alias]['city_id']) {
						$visit[$this->Visit->alias]['refund'] = '0';
					}
					foreach ($this->request->data[$this->Visit->alias] as $field => $content) {
						$visit[$this->Visit->alias][$field] = $content;
					}
					$visit[$this->Visit->alias]['visit_id_edit'] = $id;
					unset($visit[$this->Visit->alias]['id']);
					unset($visit[$this->Visit->alias]['created']);
					unset($visit[$this->Visit->alias]['modified']);
					unset($visit[$this->Visit->alias]['report']);
					$this->request->data = $visit;
					$this->Visit->create();
				}
				if ($this->Visit->save($this->request->data)) {
					$visitOptions = array('conditions' => array('Visit.' . $this->Visit->primaryKey => $id));
						$visitInfo = $this->Visit->find('first', $visitOptions);
	 					// $options['to'] = Configure::read('Parameter.Email.fromEmail'); // HABILITAR ESTA LINHA QD SISTEMA ESTIVER PRONTO
	 					$options['to'] = 'giba_fernando@hotmail.com'; // EXCLUIR ESTA LINHA QD SISTEMA ESTIVER PRONTO
	 					$options['template'] = 'visit_edited';
	 					$options['subject'] = __('Visit to %s has been Edited! - Technical Visits', $visitInfo['Visit']['destination']);
	 					$options['v'] = $visitInfo;
	 					if ($this->sendMail($options)) {
	 							$emailSendFlag = true;
	 					} else {
	 							$emailSendFlag = false;
	 					}
						if($emailSendFlag){
						if (isset($data) && !empty($data)) {
							$this->Visit->id = $id;
							$this->Visit->saveField('status', '12');
							$this->Flash->success(__('The change of visit has been saved. Wait for the changes to be reviewed.'));
						} else {
							$this->Flash->success(__('The visit has been saved.'));
						}
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
				$this->request->data = $visit;
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
			$this->set(compact('teams', 'cities', 'disciplines', 'states', 'courses', 'change'));
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
		$copy[$this->Visit->alias]['states'] = $copy[$this->Visit->City->alias]['state_id'];
		$copy[$this->Visit->alias]['course'] = $copy[$this->Visit->Discipline->alias]['course_id'];
		$this->Session->write('copy', $copy);
		return $this->redirect(array('action' => 'add'));
	}

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

	public function approve_change($id = null) {
		if (!$this->Visit->exists($id)) {
			throw new NotFoundException(__('Invalid visit'));
		}
		$visitChange = $this->Visit->find('first', array('conditions' => array($this->Visit->alias.'.visit_id_edit' => $id)));
		if (empty($visitChange)) {
			$this->Flash->error(__('There are no changes to review for this visit.'));
			return $this->redirect(array('action' => 'index'));
		}
		if ($this->request->is(array('post', 'put'))) {
			$visitChange[$this->Visit->alias]['id'] = $visitChange[$this->Visit->alias]['visit_id_edit'];
			$visitChange[$this->Visit->alias]['status'] = '0'; // Ver sobre status
			unset($visitChange[$this->Visit->alias]['visit_id_edit']);
			unset($visitChange[$this->Visit->alias]['created']);
			unset($visitChange[$this->Visit->alias]['modified']);
			unset($visitChange[$this->Visit->alias]['report']);
			if ($this->Visit->save($visitChange)) {
				$this->Visit->deleteAll(array($this->Visit->alias.'.visit_id_edit' => $visitChange[$this->Visit->alias]['id']), false);
				$this->Flash->success(__('The visit has been saved.'));
			} else {
				$this->Flash->error(__('The visit could not be saved. Please, try again.'));
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
				$cost_per_km = 'Cost Per Km Campus R$ <b id="cost_per_km_campus">'.CakeNumber::currency(Configure::read('Parameter.Transport.cost_per_km_campus'), 'BRL').'</b></br>';
				$cost_per_km .= 'Cost Per Km Outsourced R$ <b id="cost_per_km_outsourced">'.CakeNumber::currency(Configure::read('Parameter.Transport.cost_per_km_outsourced'), 'BRL').'</b>';
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
				$this->set(compact('teams', 'cities', 'disciplines', 'states', 'courses', 'transports', 'cost_per_km', 'statuses', 'visits'));
		} else {
			return $this->redirect(array('action' => 'index'));
		}
	}

	public function review_change($id = null) {
		$change = $this->Visit->find('first', array('conditions' => array($this->Visit->alias.'.visit_id_edit' => $id)));
		if (empty($change)) {
			$this->Flash->error(__('There are no changes to review for this visit.'));
			return $this->redirect(array('action' => 'index'));
		}
		$this->request->data = $change;
		$this->request->data[$this->Visit->alias]['states'] = $this->request->data[$this->Visit->City->alias]['state_id'];
		$this->request->data[$this->Visit->alias]['course'] = $this->request->data[$this->Visit->Discipline->alias]['course_id'];

		$options = array(
			'conditions' => array(
				$this->Visit->Team->DisciplinesTeam->alias.'.discipline_id' => $this->request->data[$this->Visit->alias]['discipline_id'],
				$this->Visit->Team->alias.'.id' => $this->request->data[$this->Visit->alias]['team_id']
			),
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
		$cities = $this->Visit->City->find('list', array('conditions' => array('state_id' => $this->request->data[$this->Visit->alias]['states'], $this->Visit->City->alias.'.id' => $this->request->data[$this->Visit->alias]['city_id'])));
		$disciplines = $this->Visit->Discipline->find('list', array('conditions' => array('course_id' => $this->request->data[$this->Visit->alias]['course'], $this->Visit->Discipline->alias.'.id' => $this->request->data[$this->Visit->alias]['discipline_id'])));
		$states = $this->Visit->City->State->find('list', array('conditions' => array($this->Visit->City->State->alias.'.id' => $this->request->data[$this->Visit->alias]['states'])));
		$courses = $this->Visit->Discipline->Course->find('list', array('conditions' => array($this->Visit->Discipline->Course->alias.'.id' => $this->request->data[$this->Visit->alias]['course'])));
		$transportEnums = $this->Visit->getEnums('transport');
		$transports = array($this->request->data[$this->Visit->alias]['transport'] => $transportEnums[$this->request->data[$this->Visit->alias]['transport']]);
		$this->set(compact('teams', 'cities', 'disciplines', 'states', 'courses', 'transports'));

		$this->render('edit');
	}

	public function notify_report(){
		$visits = $this->Visit->find('all', array('conditions' => array(
			$this->Visit->alias.'.status' => array(4,5),$this->Visit->alias.'.report' => '')));
		$reportNotifyDayParam = 3; // TODO AQUI BUSCAR PARAMETRO DE QTS DIAS APÓS TERMINO DA VISITA PARA ENVIAR NOTIFICAÇÃO DO RELATÓRIO
		foreach($visits as $v){
			if((strtotime($v['Visit']['arrival']) + $reportNotifyDayParam * 86400) < time()){
				$options['to'] = $v['User']['email'];
				$options['template'] = 'report_missing';
				$options['subject'] = __('Your visit to %s is missing report! - Technical Visits', $v['Visit']['destination']);
				$options['v'] = $v;
				$this->sendMail($options);
			}
		}
		die;
	}
}
