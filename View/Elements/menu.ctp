<div class="span3">
    <ul class="nav nav-list nav-tabs nav-stacked affix" style="display:block; width: 230px;">
        <?php foreach ($menus as $key => $menu): ?>
            <li>
                <?php echo $this->Html->link('<i class="icon-chevron-right"></i>' . $key, array('plugin' => $menu['plugin'], 'admin' => $menu['admin'], 'controller' => $menu['controller'], 'action' => $menu['action']), array('escape' => false)); ?>
            </li>
        <?php endforeach; ?>
        <?php if (isset($user) && $user['group_id'] == ADMIN) { ?>
            <li class="divider"></li>
            <li>
                <?php
                echo $this->Html->link(
                    '<i class="icon-chevron-right"></i>Gerência', array('plugin' => false, 'admin' => false, 'controller' => 'manager', 'action' => 'index'), array('escape' => false)
                );
                ?>
            </li>	
            <li>
                <?php
                echo $this->Html->link(
                    '<i class="icon-chevron-right"></i>Permissões', array('plugin' => false, 'admin' => false, 'controller' => 'manager', 'action' => 'permissions'), array('escape' => false)
                );
                ?>
            </li>
        <?php }?>	
    </ul>	
</div>	

