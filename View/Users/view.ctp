<?php 
$this->Html->addCrumb('Home', array('controller'=>'items', 'action'=>'home'));
$this->Html->addCrumb('Gerência', array('controller'=>'manager', 'action'=>'index'));
$this->Html->addCrumb('Usuários', array('controller'=>'users', 'action'=>'index'));
$this->Html->addCrumb('Visualizar', array('controller'=>'users', 'action'=>'view', $userC['User']['id']));

echo $this->Html->link(
	$this->Html->image('back.png'),
	'javascript:window.history.go(-1)',
	array('escape'=>false)
);
?>
<div class="well">	
	<div class="page-header">
		<h3>Usuário</h3>
	</div>
	<dl class="dl-horizontal">
		<dt><?php echo __('Grupo');?></dt>
		<dd><?php echo $userC['Group']['name'];?></dd>
		<dt><?php echo __('Login');?></dt>
		<dd><?php echo $userC['User']['username'];?></dd>
		<dt><?php echo __('Funcionário');?></dt>
		<dd><?php echo $userC['Employee']['name'].' '.$user['Employee']['surname'];?></dd>
	</dl>	
</div>