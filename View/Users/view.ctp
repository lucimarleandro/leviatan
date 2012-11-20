<?php 
$this->Html->addCrumb('Gerência', '/manager/');
$this->Html->addCrumb('Usuários', '/users/');
$this->Html->addCrumb('Visualizar', '/users/view/'.$userC['User']['id']);

echo $this->Html->link(
	$this->Html->image('back'),
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