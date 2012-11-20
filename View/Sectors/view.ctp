<?php 
$this->Html->addCrumb('Gerência', '/manager/');
$this->Html->addCrumb('Setores', '/sectors/');
$this->Html->addCrumb('Visualizar', '/sectors/view/'.$sector['Sector']['id']);

echo $this->Html->link(
	$this->Html->image('back'),
	'javascript:window.history.go(-1)',
	array('escape'=>false)
);
?>
<div class="well">	
	<div class="page-header">
		<h3>Setor</h3>
	</div>
	<dl class="dl-horizontal">
		<dt><?php echo __('Nome');?></dt>
		<dd><?php echo $sector['Sector']['name'];?></dd>
	</dl>	
</div>