<?php 
$this->Html->addCrumb('Home', array('controller'=>'items', 'action'=>'home'));
$this->Html->addCrumb('Gerência', array('controller'=>'manager', 'action'=>'index'));
$this->Html->addCrumb('Unidades de Medidas', array('controller'=>'measure_types', 'action'=>'index'));
$this->Html->addCrumb('Visualizar', array('controller'=>'measure_types', 'action'=>'view', $type['MeasureType']['id']));

echo $this->Html->link(
	$this->Html->image('back.png'),
	'javascript:window.history.go(-1)',
	array('escape'=>false)
);
?>
<div class="well">	
	<div class="page-header">
		<h3>Unidade de Medida</h3>
	</div>
	<dl class="dl-horizontal">
		<dt><?php echo __('Nome');?></dt>
		<dd><?php echo $type['MeasureType']['name'];?></dd>
		<dt><?php echo __('Descrição');?></dt>
		<dd><?php echo $type['MeasureType']['description'];?></dd>
	</dl>	
</div>