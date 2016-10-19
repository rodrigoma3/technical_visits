<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
    public $components = array(
        'Acl',
        'Auth' => array(
            'authorize' => array(
                'Actions' => array('actionPath' => 'controllers')
            ),
            'authenticate' => array(
                'Form' => array(
                    'fields' => array('username' => 'email'),
                    'passwordHasher' => 'Blowfish'
                )
            ),
            'loginRedirect' => array(
                'controller' => 'visits',
                'action' => 'index',
            ),
            'logoutRedirect' => array(
                'controller' => 'users',
                'action' => 'login',
            ),
            'loginAction' => array(
                'controller' => 'users',
                'action' => 'login',
            ),
        ),
        'Session',
        'Flash',
        'Cookie'
    );
    public $helpers = array('Html', 'Form', 'Session');

    public function beforeFilter() {
        $this->Auth->unauthorizedRedirect = $this->referer();
        $this->Auth->authError = __('You are not authorized to access that location.');

        $allowAction = array('logout', 'login', 'set_language');

        $this->Auth->allow($allowAction);

        Configure::write('Config.language', $this->Session->read('Config.language'));

        if (!$this->Auth->loggedIn() && !in_array($this->action, $allowAction)) {
            $this->Auth->authError = false;
            return $this->redirect($this->Auth->logout());
        }

    }

    public function beforeRender() {

        if ($this->Auth->user()) {
            $menus = array(
                array(
                    'title' => __('Visits'),
                    'icon' => '<i class="fa fa-calendar"></i>',
                    'controller' => 'visits',
                    'action' => 'index',
                    'allow' => false,
                ),
                array(
                    'title' => __('Users'),
                    'icon' => '<i class="fa fa-user"></i>',
                    'controller' => 'users',
                    'action' => 'index',
                    'allow' => false,
                ),
                array(
                    'title' => __('Groups'),
                    'icon' => '<i class="fa fa-users"></i>',
                    'controller' => 'groups',
                    'action' => 'index',
                    'allow' => false,
                ),
                array(
                    'title' => __('City'),
                    'icon' => '<i class="fa fa-building"></i>',
                    'controller' => 'cities',
                    'action' => 'index',
                    'allow' => false,
                ),
                array(
                    'title' => __('States'),
                    'icon' => '<i class="fa fa-map"></i>',
                    'controller' => 'states',
                    'action' => 'index',
                    'allow' => false,
                ),
                array(
                    'title' => __('Teams'),
                    'icon' => '<i class="fa fa-venus-mars"></i>',
                    'controller' => 'teams',
                    'action' => 'index',
                    'allow' => false,
                ),
                array(
                    'title' => __('Disciplines'),
                    'icon' => '<i class="fa fa-file"></i>',
                    'controller' => 'disciplines',
                    'action' => 'index',
                    'allow' => false,
                ),
                array(
                    'title' => __('Courses'),
                    'icon' => '<i class="fa fa-graduation-cap"></i>',
                    'controller' => 'courses',
                    'action' => 'index',
                    'allow' => false,
                ),
            );

            foreach ($menus as $k => $menu) {
                $menus[$k]['allow'] = $this->Acl->check(array('User' => $this->Auth->user()), $menu['controller'].'/'.$menu['action']);
            }

            $this->set('menus', $menus);
        }
    }
}