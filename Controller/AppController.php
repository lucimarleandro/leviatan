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
    
/**
 *
 * @var type 
 */
    public $components = array(
        'Auth' => array(
            'authorize' => array(
                'Controller'
            )
        ),
        'Session',
        'RequestHandler'
    );
    
/**
 *
 * @var type 
 */
    public $helpers = array('Html', 'Form', 'Session', 'Js');
    
/**
 *
 * @var type 
 */
    public $uses = array('Permission', 'Module', 'SolicitationItem', 'CartItem');

/**
 * (non-PHPdoc)
 * @see Controller::beforeFilter()
 */
    public function beforeFilter() {
        
         if (Configure::read('App.maintenance')) {
            if($this->Auth->user('group_id') != ADMIN) {                   
                $this->layout = 'maintenance';
                $this->Auth->deny('*');
            }
        }
        
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
        
        if($this->Auth->user('group_id') == HOMOLOGADOR) {
            $pendingSolicitationItems = $this->__getPendingSolicitationItems();
            $this->set(compact('pendingSolicitationItems'));
        }
        
        if($this->Auth->user('group_id') == DIRETOR) {
            $pendingCartItems = $this->__getPendingCartItems();
            $this->set(compact('pendingCartItems'));
        }

        $this->set(compact('menus'));
        
        //$this->Auth->allow('*');
    }
    
/**
 * 
 * @param type $user
 * @return boolean
 */
    public function isAuthorized($user) {
        
        $group_id = $user['group_id'];
        
        $options['conditions'] = array(
            'Permission.group_id'=>$group_id,
            'Permission.permission'=>1
        );
        $options['fields'] = array(
            'Module.controller', 'Module.action'
        );
        
        $permissions = $this->Permission->find('all', $options);
        
        $allow = array();
        foreach($permissions as $permission) {
            $allows[] = array($permission['Module']['controller']=>$permission['Module']['action']);
        }

        if(!empty($allows)) {            
            $controller = Inflector::camelize($this->params['controller']);
            $action = $this->params['action'];
            $module = array($controller=>$action);

            if(in_array($module, $allows)) {
                return true;
            }
        }
        
        return false;
    }

/**
 * 
 */
    public function __getMenus() {

        $menus['Home'] = array('controller' => 'items', 'action' => 'home', 'admin' => false, 'plugin' => false);

        if ($this->Auth->user()) {
            switch ($this->Auth->user('group_id')) {
                case ADMIN:
                    /*$menus['Itens'] = array('controller' => 'items', 'action' => 'index', 'admin' => false, 'plugin' => false);
                    $menus['Minhas Solicitações'] = array('controller' => 'solicitations', 'action' => 'index', 'admin' => false, 'plugin' => false);
                    $menus['Fazer Solicitação'] = array('controller' => 'solicitation_items', 'action' => 'index', 'admin' => false, 'plugin' => false);
                    $menus['Finalizar Solicitação'] = array('controller' => 'cart_items', 'action' => 'index', 'admin' => false, 'plugin' => false);
                    $menus['Analisar solicitações'] = array('controller' => 'solicitations', 'action' => 'analyze', 'admin' => false, 'plugin' => false);
                    $menus['Pedidos'] = array('controller' => 'orders', 'action' => 'index', 'admin' => false, 'plugin' => false);
                     * 
                     */
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
                    $menus['Iniciar Nova Solicitação'] = array('controller' => 'solicitation_items', 'action' => 'index', 'admin' => false, 'plugin' => false);
                    $menus['Finalizar Solicitação'] = array('controller' => 'cart_items', 'action' => 'index', 'admin' => false, 'plugin' => false);
                    break;
                case GERENCIADOR:
                    $menus['Minhas Solicitações'] = array('controller' => 'solicitations', 'action' => 'index', 'admin' => false, 'plugin' => false);
                    $menus['Iniciar Nova Solicitação'] = array('controller' => 'solicitation_items', 'action' => 'index', 'admin' => false, 'plugin' => false);
                    $menus['Finalizar Solicitação'] = array('controller' => 'cart_items', 'action' => 'index', 'admin' => false, 'plugin' => false);
                    break;
            }
        }

        return $menus;
    }
    
/**
 * 
 */
    private function __getPendingSolicitationItems() {
        
        $this->SolicitationItem->recursive = -1;
        $options['joins'] = array(
            array(
                'table'=>'items',
                'alias'=>'Item',
                'type'=>'INNER',
                'conditions'=>array(
                    'Item.id = SolicitationItem.item_id'
                )
            ),
            array(
                'table'=>'solicitations',
                'alias'=>'Solicitation',
                'type'=>'INNER',
                'conditions'=>array(
                    'SolicitationItem.solicitation_id = Solicitation.id'
                )
            ),
            array(
                'table'=>'users',
                'alias'=>'User',
                'type'=>'INNER',
                'conditions'=>array(
                    'User.id'=>$this->Auth->user('id')
                )
            ),
            array(
                'table'=>'employees',
                'alias'=>'Employee',
                'type'=>'INNER',
                'conditions'=>array(
                    'Employee.id = User.employee_id'
                )
            ),
            array(
                'table'=>'unity_sectors',
                'alias'=>'UnitySector',
                'type'=>'INNER',
                'conditions'=>array(
                    'UnitySector.id = Employee.unity_sector_id'
                )
            ),     
           array(
                'table'=>'head_orders',
                'alias'=>'HeadOrder',
                'type'=>'INNER',
                'conditions'=>array(
                    'HeadOrder.item_class_id = Item.item_class_id',
                    'HeadOrder.unity_sector_id = UnitySector.id'
                )
            ),
            
        );
        
        $options['conditions'] = array(
            'SolicitationItem.status_id'=>PENDENTE  
        );
        
        $pending = $this->SolicitationItem->find('count', $options);

        return $pending;
    }
    
/**
 * 
 */
    private function __getPendingCartItems() {
        
        $options['conditions'] = array(
            'CartItem.user_id'=>$this->Auth->user('id')
        );
        
        $pending = $this->CartItem->find('count', $options);
        
        return $pending;
    }
    
}
