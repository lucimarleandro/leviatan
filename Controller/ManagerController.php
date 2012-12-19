<?php

App::uses('AppController', 'Controller');

/**
 * Users Controller
 *
 * @property User $User
 */
class ManagerController extends AppController {
    
/**
 *
 * @var type 
 */
    public $uses = array('Module', 'Permission' , 'Group');

/**
 *
 * @var type 
 */
    public $components = array('Ctrl');
    
/**
 * 
 */
    public function index() {
        
    }
    
/**
 * 
 */
    public function permissions() {
        $this->syncronize();
        
        $modules = $this->__getModules($list = false);
        $groups = $this->__getGroups($name = true);
        $permissions = $this->__getPermissions();
        
        $this->Permission->recursive = -1;
        foreach($groups as $id=>$group):
            $options['conditions'] = array(
                'Permission.group_id'=>$id,
                'Permission.permission'=>0
            );
            $count = $this->Permission->find('count', $options);
            
            $checked[$id] = $count == 0;
        endforeach;
        
        $this->set(compact('groups', 'checked', 'modules', 'permissions'));
    }
    
/**
 * 
 */
    public function changePermission() {
        $this->autoRender = false;
        if($this->request->is('AJAx')) {
            
            $this->Permission->id = $this->request->data['id'];
            $permission = $this->request->data['permission'];
            
            if ($this->Permission->saveField('permission', $permission, false)) {
                $result = true;
            } else {
                $result = false;
            }

            echo json_encode(array('result' => $result));
        }        
    }
    
/**
 * 
 */
    public function changePermissionAllModules() {
        $this->autoRender = false;
        if($this->request->is('AJAX')) {
            
            $permission = $this->request->data['permission'];
            $group_id = $this->request->data['group_id'];
            
            $this->Permission->begin();
            $fields = array('Permission.permission'=>$permission);
            $conditions = array('Permission.group_id'=>$group_id);
            
            $status = $this->Permission->updateAll($fields, $conditions);
            if($status) {
                $this->Permission->commit();
                $return = true;
            }else {
                $this->Permission->rollback();
                $return = false;
            }
            
            return json_encode(array('result'=>$return));
        }
    } 
    
/**
 * 
 */
    private function syncronize() {

        $aControllers = $this->Ctrl->get();
        
        $options['fields'] = array(
            'Permission.id', 'Permission.module_id', 'Module.controller', 'Module.action'
        );
        $permissions = $this->Permission->find('all', $options);
        
        $permissionsBD = array();
        foreach($permissions as $key=>$permission):
            $permissionsBD[] = array_merge(
                                   $permission['Permission'], 
                                   array($permission['Module']['controller']=>$permission['Module']['action'])
                               );
        endforeach;        
        
        foreach($aControllers as $controller=>$actions):
            foreach($actions as $action):
                $data[] = array(str_replace('Controller', '', $controller)=>$action);
            endforeach;
        endforeach;
        
        $news = array_udiff(
            $data, 
            $permissionsBD, 
            array($this, '__compareArrays')
        );
        $olds = array_udiff(
            $permissionsBD, 
            $data,
            array($this, '__compareArrays')
        );
        if(!empty($news)) {
            foreach($news as $module):                
                $controller = array_keys($module);
                $action = array_values($module);
                
                $modules[] = array('controller'=>$controller[0], 'action'=>$action[0]);
            endforeach;
            $save = true;
            
            //Organiza values da query
            $values = array();            
            foreach($modules as $module):
                $values[] = "('".$module['controller']."', '".$module['action']."')";
            endforeach;
            $values = (implode(',', $values));
            $sqlModule = 'INSERT INTO `modules` (`controller`, `action`) VALUES '.$values.';'; 
            
            $this->Module->begin();
            $this->Module->create();            
            $queryModule = $this->Module->query($sqlModule);
            if(!empty($queryModule)) {
               $this->Module->rollback();
               $save = false;
            }
            //Organiza os dados para salvar na tabela de permissões
            //---------------
            $groups = $this->__getGroups();
            $module_ids = $this->__getModules();
            
            $values = array();
            foreach($groups as $group_id):
                if($group_id == 1) {
                    $permisionByGroup = 1;
                }else {
                    $permisionByGroup = 0;
                }
                foreach($module_ids as $module_id):
                    $values[] = "('".$module_id."', '".$group_id."', '".$permisionByGroup."')";
                endforeach;
            endforeach;
            
            $values = (implode(',', $values));
            $sqlPermission = 'INSERT INTO `permissions` (`module_id`, `group_id`, `permission`) VALUES '.$values.';'; 
            
            $this->Permission->begin();
            $this->Permission->create();
            $queryPermission = $this->Permission->query($sqlPermission);
            
            if(!empty($queryPermission)) {
               $this->Permission->rollback();
               $save = false;
            }
            
            if($save) {
                $this->Module->commit();
                $this->Permission->commit();
            }else {
                $this->Session->setFlash(__('Problema ao adicionar novas módulos'), 'default', array('class'=>'alert alert-error'));                
            }
        }

        $permission_ids = array();
        $module_ids = array();
        if(!empty($olds)) {
            
            $save = true;
            
            foreach($olds as $value):
                $module_ids[] = $value['module_id'];
                $permission_ids[] = $value['id'];
            endforeach;
            $conditions = array('Permission.id'=>$permission_ids);
            
            $this->Permission->begin();
            if(!$this->Permission->deleteAll($conditions)) {
                $this->Permission->rollback();
                $save = false;
            }
            $conditions = array('Module.id'=>$module_ids);
            if(!$this->Module->deleteAll($conditions)) {
                $this->Module->rollback();
                $save = false;
            }
            
            if($save) {
                $this->Permission->commit();
                $this->Module->commit();
                
                $this->Session->setFlash(__('Sincronização bem sucessida'), 'default', array('class'=>'alert alert-success'));
            }else {
                $this->Session->setFlash(__('Problema ao remover módulos na sincronização'), 'default', array('class'=>'alert alert-error'));
            }            
        }
    }
    
/**
 * 
 * @return type
 */
    private function __getGroups($name = false) {
        
        $this->Group->recursive = -1;
        
        if($name) {
            $options['fields'] = array('Group.id', 'Group.name');
        }else {
            $options['fields'] = array('Group.id');        
        }
        $options['order'] = array('Group.id'=>'asc');
        
        $groups = $this->Group->find('list', $options);
        
        return $groups;
    }
    
/**
 * 
 */
    private function __getModules($list = true) {
        
        $this->Module->recursive = -1;
        
        if($list) {   
            $options['joins'] = array(
                array(
                    'table'=>'permissions',
                    'alias'=>'Permission',
                    'type'=>'LEFT',
                    'conditions'=>array(
                        'Module.id = Permission.module_id'
                    )            
                )
            );
            $options['conditions'] = array('Permission.id is NULL');
            $options['fields'] = array('Module.id');
            
            $modules = $this->Module->find('list', $options);
        }else {
            $options['order'] = array(
                'Module.controller'=>'asc',
                'Module.action'=>'asc'
            );
            $options['fields'] = array('Module.controller', 'Module.action');
            
            $modules = $this->Module->find('all', $options);
        }      
        
        return $modules;
    }
    
/**
 * 
 */
    private function __getPermissions() {
        
        $options['joins'] = array(
            array(
                'table'=>'permissions',
                'alias'=>'Permission',
                'type'=>'LEFT',
                'conditions'=>array(
                    'Module.id = Permission.module_id'
                )            
            )
        );
        $optoins['order'] = array(
            'Permission.group_id'=>'asc',
            'Module.controller'=>'asc',
            'Module.action'=>'asc'
        );
        $options['fields'] = array(
            'Permission.id',
            'Permission.permission',
            'Permission.group_id',
            'Module.controller',
            'Module.action'
        );
        
        $permissions = $this->Module->find('all', $options);
        
        foreach($permissions as $permission):
            $data[$permission['Module']['controller'].'->'.$permission['Module']['action']][] = $permission['Permission'];
        endforeach;

        return $data;
    }
    
/**
 * 
 * @param type $a
 * @param type $b
 */
    private function __compareArrays($a, $b) {
        unset($a['id'], $a['module_id'], $b['id'], $b['module_id']);
                
        $key_a = array_keys($a);
        $key_a = $key_a[0];
        $value_a = array_values($a);
        $value_a = $value_a[0];

        $key_b = array_keys($b);
        $key_b = $key_b[0];
        $value_b = array_values($b);
        $value_b = $value_b[0];

        $module_a = $key_a.$value_a;
        $module_b = $key_b.$value_b;

        return strcmp($module_a, $module_b);
    }

}