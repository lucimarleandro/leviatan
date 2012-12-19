<?php 
$this->Html->addCrumb('Home', array('controller'=>'items', 'action'=>'index'));
$this->Html->addCrumb('Gerência', array('controller'=>'manager', 'action'=>'index'));
$this->Html->addCrumb('Categorias de Insumos', array('controller'=>'input_categories', 'action'=>'index'));
$this->Html->addCrumb('Visualizar', array('controller'=>'input_categories', 'action'=>'view', $category['InputCategory']['id']));

echo $this->Html->link(
	$this->Html->image('back'),
	'javascript:window.history.go(-1)',
	array('escape'=>false)
);
?>
<div class="well">	
	<div class="page-header">
		<h3>Categoria de Insumos</h3>
	</div>
	<dl class="dl-horizontal">
		<dt><?php echo __('Nome');?></dt>
		<dd><?php echo $category['InputCategory']['name'];?></dd>
		<dt><?php echo __('Descrição');?></dt>
		<dd><?php echo $category['InputCategory']['description'];?></dd>
	</dl>	
</div>