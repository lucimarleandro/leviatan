<?php

/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {

    public $components = array(
        'Acl',
        'Auth' => array(
            'authorize' => array(
                'Actions' => array('actionPath' => 'controllers/')
            )
        ),
        'Session',
        'RequestHandler'
    );
    public $helpers = array('Html', 'Form', 'Session', 'Js');

    /**
     * (non-PHPdoc)
     * @see Controller::beforeFilter()
     */
    public function beforeFilter() {
        //Configure AuthComponent
        $this->Auth->loginAction = array('controller' => 'items', 'action' => 'home');
        $this->Auth->logoutRedirect = array('controller' => 'items', 'action' => 'home');
        $this->Auth->loginRedirect = array('controller' => 'items', 'action' => 'home');
        // Mensagens de erro
        $this->Auth->authError = '<div class="alert alert-error">' . __('Você precisa fazer login ou não tem autorização para acessar esta página', true) . '</div>';

        $user = $this->Auth->user();
        if ($user != null) {
            $this->set(compact('user'));
        }
        $menus = $this->__getMenus();
        $this->set(compact('menus'));
    }

    /**
     * 
     */
    public function __getMenus() {

        $menus['Home'] = array('controller' => 'items', 'action' => 'home', 'admin' => false, 'plugin' => false);

        if ($this->Auth->user()) {
            switch ($this->Auth->user('group_id')) {
                case ADMIN:
                    $menus['Itens'] = array('controller' => 'items', 'action' => 'index', 'admin' => false, 'plugin' => false);
                    $menus['Minhas Solicitações'] = array('controller' => 'solicitations', 'action' => 'index', 'admin' => false, 'plugin' => false);
                    $menus['Fazer Solicitação'] = array('controller' => 'solicitation_items', 'action' => 'index', 'admin' => false, 'plugin' => false);
                    $menus['Finalizar Solicitação'] = array('controller' => 'cart_items', 'action' => 'index', 'admin' => false, 'plugin' => false);
                    $menus['Analisar solicitações'] = array('controller' => 'solicitations', 'action' => 'analyze', 'admin' => false, 'plugin' => false);
                    $menus['Pedidos'] = array('controller' => 'orders', 'action' => 'index', 'admin' => false, 'plugin' => false);
                    break;
                case CADASTRADOR:
                    $menus['Itens'] = array('controller' => 'items', 'action' => 'index', 'admin' => false, 'plugin' => false);
                    break;
                case HOMOLOGADOR:
                    $menus['Itens'] = array('controller' => 'items', 'action' => 'index', 'admin' => false, 'plugin' => false);
                    $menus['Analisar solicitações'] = array('controller' => 'solicitations', 'action' => 'analyze', 'admin' => false, 'plugin' => false);
                    $menus['Pedidos'] = array('controller' => 'orders', 'action' => 'index', 'admin' => false, 'plugin' => false);
                    break;
                case DIRETOR:
                    $menus['Minhas Solicitações'] = array('controller' => 'solicitations', 'action' => 'index', 'admin' => false, 'plugin' => false);
                    $menus['Fazer Solicitação'] = array('controller' => 'solicitation_items', 'action' => 'index', 'admin' => false, 'plugin' => false);
                    $menus['Finalizar Solicitação'] = array('controller' => 'cart_items', 'action' => 'index', 'admin' => false, 'plugin' => false);
                    break;
                case GERENCIADOR:
                    $menus['Minhas Solicitações'] = array('controller' => 'solicitations', 'action' => 'index', 'admin' => false, 'plugin' => false);
                    $menus['Fazer Solicitação'] = array('controller' => 'solicitation_items', 'action' => 'index', 'admin' => false, 'plugin' => false);
                    $menus['Finalizar Solicitação'] = array('controller' => 'cart_items', 'action' => 'index', 'admin' => false, 'plugin' => false);
                    break;
            }
        }

        return $menus;
    }

}
