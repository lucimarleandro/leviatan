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
    public $uses = array('Permission', 'Module', 'Solicitation', 'CartItem');

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
        //layout
        $this->layout = 'motiro2';
        
        //Configure AuthComponent
        $this->Auth->loginAction = array('controller'=>'users', 'action'=>'login');
        $this->Auth->loginRedirect = array('controller'=>'items', 'action'=>'home');
        $this->Auth->logoutRedirect = array('controller'=>'users', 'action'=>'login');
        // Mensagens de erro
        $this->Auth->authError = '<div class="alert alert-error">' . __('Você precisa fazer login ou não tem autorização para acessar esta página', true) . '</div>';

        $user = $this->Auth->user();
        if($user != null) {
            $this->set(compact('user'));
        }

        $this->__getMenus();
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

        $this->Navigation = ClassRegistry::init('Navigation');
        $this->Navigation->useTable = 'menu_motiro';

        // Lista todos os menus da barra principal de acordo com o perfil
        $group_id = $this->Auth->user('group_id');
        $lista_menus = $this->Navigation->find('all', array(
            'conditions' => array(
                'Navigation.parent_id' => NULL,
                'Navigation.group_id' => $group_id
            )
        ));
        
        // Verifica qual o link que está aberto.
        $activeLink = $this->request->params;
        if (isset($activeLink['pass']))
            $activeLink = array_merge($activeLink, $activeLink['pass']);
        if (isset($activeLink['named']))
            $activeLink = array_merge($activeLink, $activeLink['named']);
        unset($activeLink['pass'], $activeLink['named']);

        // Prepara todos os itens da barra principal do menu, verificando
        // qual receberá o atributo ativo.
        $active_id = null;
        $menus = array();
        foreach ($lista_menus as $menu) {
            $menu = $menu['Navigation'];
            $url = json_decode($menu['url'], true);

            // Força a comparação quando for definida a regra de comparação.
            // Quando o link não possui regra de comparação, então só faz a
            // comparação se nenhum outro já tiver sido encontrado.
            if (isset($menu['compare']) || $active_id == NULL) {
                $compare = isset($menu['compare']) ? json_decode($menu['compare'], true) : $url;
                $isActive = (isset($compare) && count(array_diff_assoc($compare, $activeLink)) == 0);
                $active_id = $isActive ? $menu['id'] : $active_id;
            } else
                $isActive = false;
            
            // Verifica se há notificador para esse menu.
            if (isset($menu['notify'])) {
                if (method_exists($this, $menu['notify']))
                    $notify = $this->{$menu['notify']}();
            }

            // Estrutura o array do menu
            $menus[] = array(
                'url' => $url,
                'text' => $menu['text'],
                'icon' => $menu['icon'],
                'ball' => isset($notify) ? $notify : null,
                'active' => $isActive
            );

            // Limpa as variáveis temporárias para evitar conflito dentro do loop.
            unset($menu, $url, $isActive, $notify);
        }

        // Verifica se existe algum ativo
        if (isset($active_id)) {
            // Carrega a lista de submenus de acordo com o menu ativo.
            $lista_sub = $this->Navigation->find('all', array(
                'conditions' => array(
                    'Navigation.parent_id' => $active_id,
                    'Navigation.group_id' => $group_id
                )
            ));

            $submenu = array();
            foreach ($lista_sub as $sub) {
                $sub = $sub['Navigation'];
                $url = json_decode($sub['url'], true);
                $text = $sub['text'];
                $isActive = (is_array($url) && count(array_diff_assoc($url, $activeLink)) == 0);
                
                // Verifica se há notificador para esse menu.
                if (isset($sub['notify'])) {
                    if (method_exists($this, $sub['notify']))
                        $text .= " ({$this->{$sub['notify']}()})";
                }

                $submenu[] = array(
                    'url' => $url,
                    'text' => $text,
                    'active' => $isActive,
                );

                unset($sub, $url, $text, $isActive);
            }
        }
        
        $this->set(compact('menus', 'submenu'));
    }
    
/**
 * 
 */
    private function __getPendingSolicitationItems() {
        
        $options['joins'] = array(
             array(
                'table'=>'solicitation_items',
                'alias'=>'SolicitationItem',
                'type'=>'INNER',
                'conditions'=>array(
                    'SolicitationItem.solicitation_id = Solicitation.id'
                )
            ),
            array(
                'table'=>'items',
                'alias'=>'Item',
                'type'=>'INNER',
                'conditions'=>array(
                    'Item.id = SolicitationItem.item_id'
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
            )
        );
        $options['conditions'] = array(
            'SolicitationItem.status_id'=>PENDENTE  
        );
        $options['group'] = 'Solicitation.id';
        
        $this->Solicitation->recursive = -1;
        $pending = $this->Solicitation->find('count', $options);

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
