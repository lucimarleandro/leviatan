<?php 
$this->Html->addCrumb('Home', array('controller'=>'items', 'action'=>'home'));
$this->Html->addCrumb('Gerência', array('controller'=>'items', 'action'=>'home'));
$this->Html->addCrumb('Unidade', array('controller'=>'unities', 'action'=>'index'));
$this->Html->addCrumb('Visualizar', array('controller'=>'unities', 'action'=>'view', $unity['Unity']['id']));

echo $this->Html->link(
	$this->Html->image('back.png'),
	'javascript:window.history.go(-1)',
	array('escape'=>false)
);
?>
<div class="well">	
	<div class="page-header">
		<h3>Unidade</h3>
	</div>
	<dl class="dl-horizontal">
		<dt><?php echo __('Tipo da Unidade');?></dt>
		<dd><?php echo $unity['UnityType']['name'];?></dd>
		<dt><?php echo __('Distrito Sanitário');?></dt>
		<dd><?php echo $unity['HealthDistrict']['name'];?></dd>
		<dt><?php echo __('CNES');?></dt>
		<dd><?php echo $unity['Unity']['cnes'];?></dd>
		<dt><?php echo __('CNPJ');?></dt>
		<dd><?php echo $unity['Unity']['cnpj'];?></dd>
		<dt><?php echo __('Nome');?></dt>
		<dd><?php echo $unity['Unity']['name'];?></dd>
		<dt><?php echo __('CEP');?></dt>
		<dd><?php echo $unity['Address']['postal_code'];?></dd>
		<dt><?php echo __('Endereço');?></dt>
		<dd><?php echo $unity['Address']['name'].' - '.$unity['Unity']['number'];?></dd>
		<dt><?php echo __('Telefone');?></dt>
		<dd><?php echo $unity['Unity']['phone']?></dd>		
	</dl>	
</div>