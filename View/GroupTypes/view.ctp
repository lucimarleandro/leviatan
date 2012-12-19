<?php 
$this->Html->addCrumb('Home', array('controller'=>'items', 'action'=>'home'));
$this->Html->addCrumb('Gerência', array('controller'=>'manager', 'action'=>'index'));
$this->Html->addCrumb('Tipos de Grupos', array('controller'=>'group_types', 'action'=>'index'));
$this->Html->addCrumb('Visualizar', array('controller'=>'group_types', 'action'=>'view', $type['GroupType']['id']));

echo $this->Html->link(
	$this->Html->image('back'),
	'javascript:window.history.go(-1)',
	array('escape'=>false)
);
?>
<div class="well">	
	<div class="page-header">
		<h3>Setor</h3>
	</div>
	<dl class="dl-horizontal">
		<dt><?php echo __('Nome');?></dt>
		<dd><?php echo $type['GroupType']['name'];?></dd>
	</dl>	
</div>