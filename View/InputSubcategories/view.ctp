<?php 
$this->Html->addCrumb('Gerência', '/manager/');
$this->Html->addCrumb('Subcategorias de Insumos', '/input_subcategories/');
$this->Html->addCrumb('Visualizar', '/input_subcategories/view/'.$subcategory['InputSubcategory']['id']);

echo $this->Html->link(
	$this->Html->image('back'),
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