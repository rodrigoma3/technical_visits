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
App::uses('CakeEmail', 'Network/Email');

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
                'action' => 'dashboard',
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

        CakeNumber::addFormat('BRL', array('thousands' => '.', 'decimals' => ','));

        $this->Auth->allow(Configure::read('Parameter.System.allowed_actions'));

        if ($this->Session->check('Config.language')) {
            Configure::write('Config.language', $this->Session->read('Config.language'));
        }

        if (!$this->Auth->loggedIn() && !in_array($this->action, Configure::read('Parameter.System.allowed_actions'))) {
            $this->Auth->authError = false;
            // return $this->redirect($this->Auth->logout());
        }
        $this->set('perms', $this->findPerms());
    }

    public function beforeRender() {

        if ($this->Auth->user()) {
            $menus = array(
                array(
                    'title' => __('Dashboard'),
                    'icon' => '<i class="fa fa-tachometer"></i>',
                    'controller' => 'visits',
                    'action' => 'dashboard',
                    'allow' => false,
                ),
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
                array(
                    'title' => __('General analysis'),
                    'icon' => '<i class="fa fa-signal"></i>',
                    'controller' => 'visits',
                    'action' => 'general_analysis',
                    'allow' => false,
                ),
            );

            foreach ($menus as $k => $menu) {
                $menus[$k]['allow'] = $this->Acl->check(array('User' => $this->Auth->user()), $menu['controller'].'/'.$menu['action']);
            }

            $topmenus = array(
                array(
                    'title' => '<i class="fa fa-cog fa-2x"></i><b class="caret"></b>',
                    'id' => 'parameter',
                    'allow' => false,
                    'subs' => array(
                        array(
                            'title' => __('E-mail'),
                            'controller' => 'parameters',
                            'action' => 'email',
                            'id' => null,
                            'allow' => false,
                        ),
                        array(
                            'title' => __('Cost per km'),
                            'controller' => 'parameters',
                            'action' => 'cost_per_km',
                            'id' => null,
                            'allow' => false,
                        ),
                        array(
                            'title' => __('Cities short distance'),
                            'controller' => 'cities',
                            'action' => 'cities_short_distance',
                            'id' => null,
                            'allow' => false,
                        ),
                        array(
                            'title' => __('System'),
                            'controller' => 'parameters',
                            'action' => 'system',
                            'id' => null,
                            'allow' => false,
                        ),
                    ),
                ),
                array(
                    'title' => __('Welcome, ').$this->Auth->user('name').'<b class="caret"></b>',
                    'id' => 'user',
                    'allow' => false,
                    'subs' => array(
                        array(
                            'title' => __('Profile'),
                            'controller' => 'users',
                            'action' => 'profile',
                            'id' => null,
                            'allow' => false,
                        ),
                        array(
                            'title' => __('Logout'),
                            'controller' => 'users',
                            'action' => 'logout',
                            'id' => null,
                            'allow' => false,
                        ),
                    ),
                ),
            );

            foreach ($topmenus as $k => $topmenu) {
                foreach ($topmenu['subs'] as $l => $sub) {
                    if (in_array($sub['action'], Configure::read('Parameter.System.allowed_actions'))) {
                        $topmenus[$k]['subs'][$l]['allow'] = true;
                    } else {
                        $topmenus[$k]['subs'][$l]['allow'] = $this->Acl->check(array('User' => $this->Auth->user()), $sub['controller'].'/'.$sub['action']);
                    }
                    if ($topmenus[$k]['subs'][$l]['allow']) {
                        $topmenus[$k]['allow'] = true;
                    }
                }
            }

            $this->set(compact('menus', 'topmenus'));
        }
    }

    protected function sendMail($options = array()){
        try {
            $parameter = Configure::read('Parameter.Email');
            $Email = new CakeEmail();
            $configEmail = array(
                    'host' => $parameter['ssl'].$parameter['host'],
                    'port' => $parameter['port'],
                    'timeout' => $parameter['timeout'],
                    'username' => $parameter['username'],
                    'password' => $this->decrypt($parameter['password']),
                    'transport' => 'Smtp',
                    'charset' => 'utf-8',
                    'headerCharset' => 'utf-8',
                    'from' => array($parameter['fromEmail'] => $parameter['fromName']),
                    'tls' => $parameter['tls'],
                    'to' => $options['to'],
                    'emailFormat' => 'html',
                    'template' => $options['template'],
                    'viewVars' => $options,
                    'subject' => $options['subject'],
                );
            if ($parameter['replyTo']) {
                $Email->replyTo($parameter['replyTo']);
            }
            $Email->config($configEmail);
            return $Email->send();

        } catch (Exception $e) {
            return false;
        }
    }

    protected function encrypt($string = null) {
        return base64_encode(Security::encrypt($string, Configure::read('Security.salt')));
    }

    protected function decrypt($string = null) {
        return Security::decrypt(base64_decode($string), Configure::read('Security.salt'));
    }

    protected function findPerms($views = array(), $user = null) {
        if (is_null($user)) {
            if (!$this->Auth->loggedIn()) {
                return array();
            } else {
                $user = $this->Auth->user();
            }
        }
        $perms = array();

        if (empty($views)) {
            $acosList = $this->Acl->Aco->find('list');
    		foreach ($acosList as $acoId) {
    			$tree = $this->Acl->Aco->getPath($acoId,'alias');
    			$aliases = array();
                foreach ($tree as $t) {
                    if ($t['Aco']['alias'] !== 'controllers') {
                        $aliases[] = $t['Aco']['alias'];
                    }
    			}
                if (!empty($aliases) && count($aliases) == 2) {
                    $views[] = array_combine(array('controller', 'action'), $aliases);
                }
    		}
        }

        foreach ($views as $view) {
            $perms[Inflector::camelize($view['controller']).Inflector::camelize($view['action'])] = $this->Acl->check(array('User' => $user), $view['controller'].'/'.$view['action']);
        }

        return $perms;
    }

    public function randomColor() {
        return '#'.substr(str_shuffle('ABCDEF0123456789'), 0, 6);
    }
}
