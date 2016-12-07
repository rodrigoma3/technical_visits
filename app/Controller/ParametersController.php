<?php
App::uses('AppController', 'Controller');
App::uses('ShellDispatcher', 'Console');
/**
 * Parameters Controller
 *
 * @property Parameter $Parameter
 */
class ParametersController extends AppController{

    public function beforeFilter() {
        parent::beforeFilter();

    }

    protected function saveConfig($data = array()){
        try {
            foreach ($data as $parameter => $values) {
                foreach ($values as $key => $value) {
                    if ($parameter === 'Email') {
                        switch ($key) {
                            case 'ssl':
                                if ($value) {
                                    $value = 'ssl://';
                                } else {
                                    $value = '';
                                }
                                break;
                            case 'password':
                                if (empty($value)) {
                                    $value = Configure::read('Parameter.'.$parameter.'.'.$key);
                                } else {
                                    $value = $this->encrypt($value);
                                }
                                break;

                            default:
                            break;
                        }
                    }
                    Configure::write('Parameter.'.$parameter.'.'.$key, $value);
                }
            }
            Configure::dump('parameters', 'default', array('Parameter'));
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public function email(){ // senha do email = 1q2w3e4r
        if ($this->request->is(array('post', 'put'))) {
            $this->Parameter->set($this->request->data);
            if($this->Parameter->validates()){
                $data['Email'] = $this->request->data[$this->Parameter->name];
                if ($this->saveConfig($data)) {
                    $this->Flash->success(__('The parameters has been saved.'));
                } else {
                    $this->Flash->error(__('The parameters could not be saved. Please, try again.'));
                }
            } else {
                $errors = $this->Parameter->validationErrors;
            }
        } elseif ($this->request->query('to') !== null) {
            if (!empty($this->request->query('to'))) {
                $options['to'] = $this->request->query('to');
                $options['template'] = 'test_email';
                $options['subject'] = __('Test email - Technical Visits');
                if ($this->sendMail($options)) {
                    $this->Flash->success(__('Test email successfully sent.'));
                } else {
                    $this->Flash->error(__('Could not send test email.'));
                }
            } else {
                $this->Flash->warning(__('Informed email is invalid or absent.'));
            }
            $this->redirect(array('action' => 'email'));
        }
        if (empty($errors)){
            foreach (Configure::read('Parameter.Email') as $key => $value) {
                switch ($key) {
                    case 'ssl':
                        if ($value != '') {
                            $value = true;
                        } else {
                            $value = false;
                        }
                        break;

                    default:
                        break;
                }
                $this->request->data[$this->Parameter->name][$key] = $value;
            }
            unset($this->request->data[$this->Parameter->name]['password']);
        }

    }

    public function cost_per_km(){
        if ($this->request->is(array('post', 'put'))) {
            $this->Parameter->set($this->request->data);
            if ($this->Parameter->validates()) {
                $data['Transport'] = $this->request->data[$this->Parameter->name];
                if ($this->saveConfig($data)) {
                    $this->Flash->success(__('The parameters has been saved.'));
                } else {
                    $this->Flash->error(__('The parameters could not be saved. Please, try again.'));
                }
            } else {
                $errors = $this->Parameter->validationErrors;
            }
        }
        if (empty($errors)) {
            $this->request->data[$this->Parameter->name] = Configure::read('Parameter.Transport');
        }
    }

    public function system(){
        if ($this->request->is(array('post', 'put'))) {
            $this->Parameter->set($this->request->data);
            if ($this->Parameter->validates()) {
                $data['System'] = $this->request->data[$this->Parameter->name];
                if ($this->saveConfig($data)) {
                    $this->Flash->success(__('The parameters has been saved.'));
                } else {
                    $this->Flash->error(__('The parameters could not be saved. Please, try again.'));
                }
            } else {
                $errors = $this->Parameter->validationErrors;
            }
        }
        if (empty($errors)) {
            $this->request->data[$this->Parameter->name] = Configure::read('Parameter.System');
        }
        $this->set('rebuilt', $this->Acl->check(array('User' => $this->Auth->user()), 'parameters/rebuilt'));
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
		$this->Acl->Aco->deleteAll(array('alias' => Configure::read('Parameter.System.allowed_actions')), false);
		$this->Flash->success(__('Rebuild Aco Tree (Actions & Controllers) has been completed.'));
        return $this->redirect(array('action' => 'system'));
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

 ?>
