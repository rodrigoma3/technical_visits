<?php
    class ParametersController extends AppController{

        public function beforeFilter() {
            parent::beforeFilter();

        }

        public function saveConfig(){
            try {
                Configure::dump('parameters', 'default', array('Parameter'));
                return true;
            } catch (Exception $e) {
                return false;
            }
        }

        public function email(){
            if ($this->request->is(array('post', 'put'))) {
                $this->Parameter->set($this->request->data);
                if($this->Parameter->validates()){
                    foreach ($this->request->data[$this->Parameter->name] as $key => $value) {
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
                                    $value = Configure::read('Parameter.Email.password');
                                }
                                break;

                            default:
                            break;
                        }
                        Configure::write('Parameter.Email.'.$key, $value);
                        if ($this->saveConfig()) {
                            $this->Flash->success(__('The parameters has been saved.'));
                        } else {
                            $this->Flash->error(__('The parameters could not be saved. Please, try again.'));
                        }
                    }
                } else {
                    $errors = $this->Parameter->validationErrors;
                }
            } elseif ($this->request->query('to') !== null) {
                if (!empty($this->request->query('to'))) {
                    $options['to'] = $this->request->query('to');
                    $options['template'] = 'testEmail';
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

        public function password(){
            if ($this->request->is(array('post', 'put'))) {
                $this->Parameter->set($this->request->data);
                if ($this->Parameter->validates()) {
                    Configure::write('Parameter.Password', $this->request->data[$this->Parameter->name]);
                    $this->saveConfig();
                } else {
                    $errors = $this->Parameter->validationErrors;
                }
            }
            if (empty($errors)) {
                $this->request->data[$this->Parameter->name] = Configure::read('Parameter.Password');
            }
        }

    }

 ?>
