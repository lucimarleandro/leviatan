<?php 

$this->Html->addCrumb('Home', array('controller'=>'items', 'action'=>'home'));
$this->Html->addCrumb('Gerência', array('controller'=>'manager', 'action'=>'index'));
$this->Html->addCrumb('Unidades de Medidas', array('controller'=>'expense_groups', 'action'=>'index'));
$this->Html->addCrumb('Visualizar', array('controller'=>'expense_groups', 'action'=>'view', 'id'=>$group['ExpenseGroup']['id']));

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