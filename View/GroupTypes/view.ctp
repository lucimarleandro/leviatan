<?php 
$this->Html->addCrumb('Gerência', '/manager/');
$this->Html->addCrumb('Tipos de Grupos', '/group_types/');
$this->Html->addCrumb('Visualizar', '/group_types/view/'.$type['GroupType']['id']);

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