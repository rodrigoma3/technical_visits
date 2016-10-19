<?php
App::uses('AppController', 'Controller');
App::uses('ShellDispatcher', 'Console');
/**
 * Groups Controller
 *
 * @property Group $Group
 * @property PaginatorComponent $Paginator
 */
class GroupsController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

/**
 * beforeFilter method
 *
 * @return void
 */
	public function beforeFilter() {
		parent::beforeFilter();

	}

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Group->recursive = 0;
		$this->set('groups', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Group->exists($id)) {
			throw new NotFoundException(__('Invalid group'));
		}
		$options = array('conditions' => array('Group.' . $this->Group->primaryKey => $id));
		$this->set('group', $this->Group->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Group->create();
			if ($this->Group->save($this->request->data)) {
				$this->denyAll($this->Group);
				$this->Flash->success(__('The group has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The group could not be saved. Please, try again.'));
			}
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
		if (!$this->Group->exists($id)) {
			throw new NotFoundException(__('Invalid group'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Group->save($this->request->data)) {
				$this->Flash->success(__('The group has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The group could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Group.' . $this->Group->primaryKey => $id));
			$this->request->data = $this->Group->find('first', $options);
		}
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Group->id = $id;
		if (!$this->Group->exists()) {
			throw new NotFoundException(__('Invalid group'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Group->delete()) {
			$this->Group->User->deleteAll(array($this->Group->User->alias.'.group_id' => $id));
			$this->Flash->success(__('The group has been deleted.'));
		} else {
			$this->Flash->error(__('The group could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}

/**
 * denyAll method
 *
 * @param string $obj
 * @return void
 */
	private function denyAll($obj) {
		if (!is_null($obj)) {
			$acos = $this->Acl->Aco->find('list');
			foreach ($acos as $aco) {
				$tree = $this->Acl->Aco->getPath($aco,'alias');
				$aliases = array();
				foreach ($tree as $t) {
					$aliases[] = $t['Aco']['alias'];
				}
				$this->Acl->deny($obj,implode('/',$aliases));
			}
		}
	}

/**
 * permission method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function permission($id = null) {
		if (!$this->Group->exists($id)) {
			throw new NotFoundException(__('Invalid group'));
		}
		$this->Group->id = $id;

		if ($this->request->is(array('post', 'put'))) {
			$this->denyAll($this->Group);
			$allowed = explode(',', $this->request->data[$this->Group->name]['allowed']);
			foreach ($allowed as $allow) {
				$this->Acl->allow($this->Group,$allow);
			}
			$this->Flash->success(__('The group permissions has been saved.'));
		}

		$group = $this->Group->read();
		$acos = $this->Acl->Aco->find('threaded');
		$perms = array();

		foreach($acos as $aco) {
			$perms[] = array(
				'id' => $aco['Aco']['alias'],
				'parent' => '#',
				'text' => $aco['Aco']['alias'],
				'icon' => '',
				'state' => array(
					'opened' => true,
					'disabled' => false,
					'selected' => $this->Acl->check($this->Group, $aco['Aco']['alias']),
				),
				'li_attr' => array(

				),
				'a_attr' => array(

				),
			);

			//Second Layer
			foreach($aco['children'] as $aco2) {
				$perms[] = array(
					'id' => $aco2['Aco']['alias'],
					'parent' => $aco['Aco']['alias'],
					'text' => $aco2['Aco']['alias'],
					'icon' => '',
					'state' => array(
						'opened' => false,
						'disabled' => false,
						'selected' => $this->Acl->check($this->Group, $aco2['Aco']['alias']),
					),
					'li_attr' => array(

					),
					'a_attr' => array(

					),
				);

				//Third Layer
				foreach($aco2['children'] as $aco3) {
					$perms[] = array(
						'id' => $aco2['Aco']['alias']."/".$aco3['Aco']['alias'],
						'parent' => $aco2['Aco']['alias'],
						'text' => $aco2['Aco']['alias']."/".$aco3['Aco']['alias'],
						'icon' => '',
						'state' => array(
							'opened' => false,
							'disabled' => false,
							'selected' => $this->Acl->check($this->Group, $aco2['Aco']['alias']."/".$aco3['Aco']['alias']),
						),
						'li_attr' => array(

						),
						'a_attr' => array(

						),
					);

					//Fourth Layer
					foreach($aco3['children'] as $aco4) {
						$perms[] = array(
							'id' => $aco2['Aco']['alias']."/".$aco3['Aco']['alias']."/".$aco4['Aco']['alias'],
							'parent' => $aco2['Aco']['alias']."/".$aco3['Aco']['alias'],
							'text' => $aco2['Aco']['alias']."/".$aco3['Aco']['alias']."/".$aco4['Aco']['alias'],
							'icon' => '',
							'state' => array(
								'opened' => false,
								'disabled' => false,
								'selected' => $this->Acl->check($this->Group, $aco2['Aco']['alias']."/".$aco3['Aco']['alias']."/".$aco4['Aco']['alias']),
							),
							'li_attr' => array(

							),
							'a_attr' => array(

							),
						);
					}
				}
			}
		}

		$this->set('group', $group);
		$this->set('jstreeData', json_encode($perms));
	}

/**
 * rebuilt method
 *
 * @return void
 */
	public function rebuilt(){
		$command = '-app '.APP.' AclExtras.AclExtras aco_sync';
		$args = explode(' ', $command);
		$dispatcher = new ShellDispatcher($args, false);
		$dispatcher->dispatch();
		$this->Acl->Aco->deleteAll(array('alias' => array('AclExtras', 'login', 'logout', 'set_language')), false);
		$this->Flash->success(__('Rebuild Aco Tree (Actions & Controllers) has been completed.'));
		return $this->redirect(array('action' => 'index'));
	}

/**
 * set_language method
 *
 * @param string $option
 * @return void
 */
	public function set_language($option = null){
		$this->Session->write('Config.language', $option);
		return $this->redirect($this->referer());
	}

}
