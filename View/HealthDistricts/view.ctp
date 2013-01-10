<?php 
$this->Html->addCruumb('Home', array('controller'=>'items', 'action'=>'home'));
$this->Html->addCrumb('Gerência', array('controller'=>'manager', 'action'=>'index'));
$this->Html->addCrumb('Distritos Sanitários', array('controller'=>'health_districts', 'action'=>'index'));
$this->Html->AddCrumb('Visualizar', array('controller'=>'health_districts', 'action'=>'view', $district['HealthDistrict']['id']));

echo $this->Html->link(
	$this->Html->image('back.png'),
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
		<dd><?php echo $district['HealthDistrict']['name'];?></dd>
	</dl>	
</div>