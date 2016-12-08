<?php

    App::uses('AppModel', 'Model');

    class Parameter extends AppModel {
        public $useTable = false;

        public function beforeValidate($options = array()){
            parent::beforeValidate($options);

        }

        public $validate = array(
            'port' => array(
    			'naturalNumber' => array(
    				'rule' => array('naturalNumber'),
    				'message' => 'Only natural numbers (greater than zero)',
    				//'allowEmpty' => false,
    				//'required' => false,
    				//'last' => false, // Stop validation after this rule
    				//'on' => 'create', // Limit validation to 'create' or 'update' operations
    			),
    		),
            'tls' => array(
    			'boolean' => array(
    				'rule' => array('boolean'),
    				'message' => 'Boolean options only',
    				//'allowEmpty' => false,
    				//'required' => false,
    				//'last' => false, // Stop validation after this rule
    				//'on' => 'create', // Limit validation to 'create' or 'update' operations
    			),
    		),
            'timeout' => array(
    			'naturalNumber' => array(
    				'rule' => array('naturalNumber'),
    				'message' => 'Only natural numbers (greater than zero)',
    				//'allowEmpty' => false,
    				//'required' => false,
    				//'last' => false, // Stop validation after this rule
    				//'on' => 'create', // Limit validation to 'create' or 'update' operations
    			),
    		),
            'username' => array(
    			'simplechars' => array(
    				'rule'    => '/^[A-Za-z0-9-\.\@\_]*$/i',
    				'message' => 'Only letters, numbers, underline "_", point ".", at "@" and hyphen "-"',
    				'allowEmpty' => true,
    				// 'required' => false,
    				//'last' => false, // Stop validation after this rule
    				//'on' => 'create', // Limit validation to 'create' or 'update' operations
    			),
    		),
            'fromEmail' => array(
                'email' => array(
                    'rule' => array('email'),
                    'message' => 'Enter a valid email',
                    'allowEmpty' => false,
                    // 'required' => true,
                    //'last' => false, // Stop validation after this rule
                    //'on' => 'create', // Limit validation to 'create' or 'update' operations
                ),
            ),
            'replyTo' => array(
                'emailsValid' => array(
                    'rule'    => array('emailsValid'),
                    'message' => 'Invalid email. Use commas "," to separate emails',
                    'allowEmpty' => true,
                    // 'required' => false,
                    //'last' => false, // Stop validation after this rule
                    //'on' => 'create', // Limit validation to 'create' or 'update' operations
                ),
            ),
            'costPerKmCampus' => array(
                'numeric' => array(
                    'rule' => array('numeric'),
                    'message' => 'Enter a valid numerical value with 2 decimal places',
                    'allowEmpty' => false,
                    // 'required' => true,
                    //'last' => false, // Stop validation after this rule
                    //'on' => 'create', // Limit validation to 'create' or 'update' operations
                ),
            ),
            'costPerKmOutsourced' => array(
                'numeric' => array(
                    'rule' => array('numeric'),
                    'message' => 'Enter a valid numerical value with 2 decimal places',
                    'allowEmpty' => false,
                    // 'required' => true,
                    //'last' => false, // Stop validation after this rule
                    //'on' => 'create', // Limit validation to 'create' or 'update' operations
                ),
            ),
            'updatePassword' => array(
                'url' => array(
                    'rule' => array('url'),
                    'message' => 'Enter a valid url',
                    'allowEmpty' => false,
                    // 'required' => true,
                    //'last' => false, // Stop validation after this rule
                    //'on' => 'create', // Limit validation to 'create' or 'update' operations
                ),
            ),
        );

        public function emailsValid($check) {
            $emailsIsValid=false;
            $emails = array();
            $fname = '';
            foreach ($check as $key => $value) {
                $fname = $key;
                $value = str_replace(' ', '', $value);
                $emails = preg_split('/[,]/i', $value,-1, PREG_SPLIT_NO_EMPTY);
            }
            foreach ($emails as $email) {
                if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $emailsIsValid=true;
                } else {
                    $emailsIsValid=false;
                    break;
                }
            }
            if ($emailsIsValid) {
                $this->data[$this->name][$fname] = implode(',', $emails);
            }
            return $emailsIsValid;
        }

    }
