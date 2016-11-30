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
				$visitOptions = array('conditions' => array('Visit.' . $this->Refusal->Visit->primaryKey => $this->request->data[$this->Refusal->alias]['visit_id']));
				$visitInfo = $this->Refusal->Visit->find('first', $visitOptions);
				switch ($this->request->data[$this->Refusal->alias]['type']) {
					case '0':
						$this->Refusal->Visit->saveField('status', '10');
							// $options['to'] = Configure::read('Parameter.Email.fromEmail'); // TODO HABILITAR ESTA LINHA QD SISTEMA ESTIVER PRONTO
							$options['to'] = 'giba_fernando@hotmail.com'; // TODO EXCLUIR ESTA LINHA QD SISTEMA ESTIVER PRONTO
							$options['template'] = 'visit_canceled';
							$options['subject'] = __('Visit to %s has been Canceled! - Technical Visits', $visitInfo['Visit']['destination']);
							$options['reason'] = $this->request->data[$this->Refusal->alias]['reason'];
							$options['v'] = $visitInfo;
							if ($this->sendMail($options)) {
									$emailSendFlag = true;
							} else {
									$emailSendFlag = false;
							}
						break;
					case '1':
						$this->Refusal->Visit->saveField('status', '11');
							// $options['to'] = $visitInfo['User']['email'];
							$options['to'] = 'giba_fernando@hotmail.com';
							$options['template'] = 'visit_desaproved';
							$options['subject'] = __('Visit to %s has been Desaproved! - Technical Visits', $visitInfo['Visit']['destination']);
							$options['reason'] = $this->request->data[$this->Refusal->alias]['reason'];
							$options['adminEmail'] = $this->Auth->user('email');
							$options['v'] = $visitInfo;
							if ($this->sendMail($options)) {
									$emailSendFlag = true;
							} else {
									$emailSendFlag = false;
							}
						break;
					case '2':
						$s = $this->Refusal->Visit->field('status') - 2;
						$this->Refusal->Visit->saveField('status', $s);
						break;
					case '3':
						$visitEdit = $this->Refusal->Visit->find('first', array('conditions' => array($this->Refusal->Visit->alias.'.visit_id_edit' => $this->request->data[$this->Refusal->alias]['visit_id'])));
						$this->Refusal->Visit->saveField('status', $visitEdit[$this->Refusal->Visit->alias]['status']);
						$this->Refusal->Visit->deleteAll(array($this->Refusal->Visit->alias.'.visit_id_edit' => $this->request->data[$this->Refusal->alias]['visit_id']), false);
						// enviar email
						break;
					default:

						break;
				}

				if($emailSendFlag){
					$this->Flash->success(__('The refusal has been saved.'));
				}else{
					$this->Flash->warning(__('The refusal has been saved, but the system failed to send the Administrator a notification e-mail.'));
				}
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

}
