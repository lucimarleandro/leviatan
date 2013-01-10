<?php 
$this->Html->addCrumb('Home', array('controller'=>'items', 'action'=>'home'));
$this->Html->addCrumb('Gerência', array('controller'=>'manager', 'action'=>'index'));
$this->Html->addCrumb('PNGC', array('controller'=>'pngc_codes', 'action'=>'index'));
$this->Html->addCrumb('Visualizar', array('controller'=>'pngc_codes', 'action'=>'view', 'id'=>$pngcCode['PngcCode']['id']));

echo $this->Html->link(
	$this->Html->image('back.png'),
	'javascript:window.history.go(-1)',
	array('escape'=>false)
);
?>
<div class="well">	
	<div class="page-header">
		<h3>PNGC</h3>
	</div>
	<dl class="dl-horizontal">
		<dt><?php echo __('Código');?></dt>
		<dd><?php echo $pngcCode['PngcCode']['keycode'];?></dd>
		<dt><?php echo __('Grupo de Gastos');?></dt>
		<dd><?php echo $this->Html->link($pngcCode['ExpenseGroup']['name'], array('controller'=>'expense_groups', 'action'=>'view', 'id'=>$pngcCode['ExpenseGroup']['id']));?></dd>
		<dt><?php echo __('Unidade de Medida');?></dt>
		<dd><?php echo $this->Html->link($pngcCode['MeasureType']['name'], array('controller'=>'measure_types', 'action'=>'view', 'id'=>$pngcCode['MeasureType']['id']));?></dd>
		<dt><?php echo __('Categoria');?></dt>
		<dd><?php echo $this->Html->link($pngcCode['InputCategory']['name'], array('controller'=>'input_categories', 'action'=>'view', 'id'=>$pngcCode['InputCategory']['id']));?></dd>
		<dt><?php echo __('Subcategoria');?></dt>
		<dd><?php echo $this->Html->link($pngcCode['InputSubcategory']['name'], array('controller'=>'input_subcategories', 'action'=>'view', 'id'=>$pngcCode['InputSubcategory']['id']));?></dd>
	</dl>	
</div>