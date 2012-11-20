<?php 
$this->Html->addCrumb('Gerência', '/manager/');
$this->Html->addCrumb('Categorias de Insumos', '/input_categories/');
$this->Html->addCrumb('Visualizar', '/input_categories/view/'.$category['InputCategory']['id']);

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