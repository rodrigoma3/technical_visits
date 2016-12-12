<?php
App::uses('AppController', 'Controller');
/**
 * Courses Controller
 *
 * @property Course $Course
 */
class CoursesController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {

		$courses = $this->Course->find('all');
		$this->set(compact('courses'));
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->Course->id = $id;
		if (!$this->Course->exists()) {
			$this->Flash->error(__('Invalid course'));
			return $this->redirect(array('action' => 'index'));
		}
		$this->Course->recursive = 2;
		$course = $this->Course->read();
		$this->set(compact('course'));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Course->create();
			if ($this->Course->save($this->request->data)) {
				$this->Flash->success(__('The course has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The course could not be saved. Please, try again.'));
			}
		}
		$typeOfAcademicPeriods = $this->Course->getEnums('type_of_academic_period');
		$this->set(compact('typeOfAcademicPeriods'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Course->exists($id)) {
			throw new NotFoundException(__('Invalid course'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Course->save($this->request->data)) {
				$this->Flash->success(__('The course has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The course could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array($this->Course->alias.'.'.$this->Course->primaryKey => $id));
			$this->request->data = $this->Course->find('first', $options);
		}

		$options['fields'] = array('MAX(academic_period) AS max_academic_period');
		$maxAcademicPeriod = $this->Course->Discipline->find('first', $options);
		$maxAcademicPeriod = $maxAcademicPeriod[0]['max_academic_period'];
		if (is_null($maxAcademicPeriod)) {
			$maxAcademicPeriod = '1';
		}

		$typeOfAcademicPeriods = $this->Course->getEnums('type_of_academic_period');
		$this->set(compact('typeOfAcademicPeriods', 'maxAcademicPeriod'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Course->id = $id;
		if (!$this->Course->exists()) {
			$this->Flash->error(__('Invalid course'));
			return $this->redirect(array('action' => 'index'));
		}
		$options = array('conditions' => array($this->Course->alias.'.'.$this->Course->primaryKey => $id));
		if ($this->Course->Discipline->find('count', $options) === 0) {
			$this->request->allowMethod('post', 'delete');
			if ($this->Course->delete()) {
				$this->Flash->success(__('The course has been deleted.'));
			} else {
				$this->Flash->error(__('The course could not be deleted. Please, try again.'));
			}
		} else {
			$this->Flash->warning(__('The course could not be deleted because it is tied to a discipline.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
