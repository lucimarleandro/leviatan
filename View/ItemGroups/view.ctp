<?php 
$this->Html->addCrumb('Gerência', '/manager/');
$this->Html->addCrumb('Grupos dos Itens', '/item_groups/');
$this->Html->addCrumb('Visualizar', '/item_groups/view/'.$group['ItemGroup']['id']);

echo $this->Html->link(
	$this->Html->image('back'),
	'javascript:window.history.go(-1)',
	array('escape'=>false)
);
?>
<div class="well">	
	<div class="page-header">
		<h3>Grupo do Item</h3>
	</div>
	<dl class="dl-horizontal">
		<dt><?php echo __('Tipo do Grupo');?></dt>
		<dd><?php echo $group['GroupType']['name'];?></dd>
	</dl>
	<dl class="dl-horizontal">
		<dt><?php echo __('Código');?></dt>
		<dd><?php echo $group['ItemGroup']['keycode'];?></dd>
	</dl>
	<dl class="dl-horizontal">
		<dt><?php echo __('Nome');?></dt>
		<dd><?php echo $group['ItemGroup']['name'];?></dd>
	</dl>	
</div>