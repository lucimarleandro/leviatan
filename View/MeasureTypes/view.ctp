<?php 
$this->Html->addCrumb('Gerência', '/manager/');
$this->Html->addCrumb('Unidades de Medidas', '/measure_types/');
$this->Html->addCrumb('Visualizar', '/measure_types/view/'.$type['MeasureType']['id']);

echo $this->Html->link(
	$this->Html->image('back'),
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