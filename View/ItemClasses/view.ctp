<?php 
$this->Html->addCrumb('Home', array('controller'=>'items', 'action'=>'home'));
$this->Html->addCrumb('Gerência', array('controller'=>'manager', 'action'=>'index'));
$this->Html->addCrumb('Classes dos Itens', array('controller'=>'item_classes', 'action'=>'index'));
$this->Html->addCrumb('Visualizar', array('controller'=>'item_classes', 'action'=>'view', $class['ItemClass']['id']));

echo $this->Html->link(
	$this->Html->image('back'),
	'javascript:window.history.go(-1)',
	array('escape'=>false)
);
?>
<div class="well">	
	<div class="page-header">
		<h3>Classe do Item</h3>
	</div>
	<dl class="dl-horizontal">
		<dt><?php echo __('Grupo do Item');?></dt>
		<dd><?php echo $class['ItemGroup']['keycode-name'];?></dd>
	</dl>
	<dl class="dl-horizontal">
		<dt><?php echo __('Código');?></dt>
		<dd><?php echo $class['ItemClass']['keycode'];?></dd>
	</dl>
	<dl class="dl-horizontal">
		<dt><?php echo __('Nome');?></dt>
		<dd><?php echo $class['ItemClass']['name'];?></dd>
	</dl>	
</div>