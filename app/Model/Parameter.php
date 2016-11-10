<?php

    App::uses('AppModel', 'Model');

    class Parameter extends AppModel {
        public $useTable = false;

        public function beforeValidate($options = array()){
            parent::beforeValidate($options);

        }

        public $validate = array(
            'size' => array(
                'required' => array(
                    'rule'    => array('range', 4, 20),
                    'message' => 'Por favor, escolha um número entre 4 e 20',
                ),
            ),
        );

    }
