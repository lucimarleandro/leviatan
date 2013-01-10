<?php 
$this->Html->addCrumb('Home', array('controller'=>'items', 'action'=>'home'));
$this->Html->addCrumb('Gerência', array('controller'=>'manager', 'action'=>'index'));
$this->Html->addCrumb('Subcategorias de Insumos', array('controller'=>'input_subcategories', 'action'=>'index'));
$this->Html->addCrumb('Visualizar', array('controller'=>'input_subcategories', 'action'=>'view', $subcategory['InputSubcategory']['id']));

echo $this->Html->link(
	$this->Html->image('back.png'),
	'javascript:window.history.go(-1)',
	array('escape'=>false)
);
?>
<div class="well">	
	<div class="page-header">
		<h3>Subcategoria de Insumos</h3>
	</div>
	<dl class="dl-horizontal">
		<dt><?php echo __('Nome');?></dt>
		<dd><?php echo $subcategory['InputSubcategory']['name'];?></dd>
		<dt><?php echo __('Descrição');?></dt>
		<dd><?php echo $subcategory['InputSubcategory']['description'];?></dd>
	</dl>	
</div>