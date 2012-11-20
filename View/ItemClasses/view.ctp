<?php 
$this->Html->addCrumb('Gerência', '/manager/');
$this->Html->addCrumb('Classes dos Itens', '/item_classes/');
$this->Html->addCrumb('Visualizar', '/item_classes/view/'.$class['ItemClass']['id']);

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