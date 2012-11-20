<?php 
$this->Html->addCrumb('Gerência', '/manager/');
$this->Html->addCrumb('Grupos de Gastos', '/expense_groups/');
$this->Html->addCrumb('Visualizar', '/expense_groups/view/'.$group['ExpenseGroup']['id']);

echo $this->Html->link(
	$this->Html->image('back'),
	'javascript:window.history.go(-1)',
	array('escape'=>false)
);
?>
<div class="well">	
	<div class="page-header">
		<h3>Grupo de Gasto</h3>
	</div>
	<dl class="dl-horizontal">
		<dt><?php echo __('Nome');?></dt>
		<dd><?php echo $group['ExpenseGroup']['name'];?></dd>
		<dt><?php echo __('Descrição');?></dt>
		<dd><?php echo $group['ExpenseGroup']['description'];?></dd>
	</dl>	
</div>