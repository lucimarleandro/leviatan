<?php 
$this->Html->addCrumb('Gerência', '/manager/');
$this->Html->addCrumb('Distritos Sanitários', '/health_districts/');
$this->Html->addCrumb('Visualizar', '/health_districts/view/'.$district['HealthDistrict']['id']);

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
		<dd><?php echo $district['HealthDistrict']['name'];?></dd>
	</dl>	
</div>