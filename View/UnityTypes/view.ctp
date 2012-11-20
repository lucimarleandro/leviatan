<?php 
$this->Html->addCrumb('Gerência', '/manager/');
$this->Html->addCrumb('Tipos de Unidades', '/unity_types/');
$this->Html->addCrumb('Visualizar', '/unity_types/view/'.$type['UnityType']['id']);

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
		<dd><?php echo $type['UnityType']['name'];?></dd>
	</dl>	
</div>