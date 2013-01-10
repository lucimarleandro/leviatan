<?php
$this->Html->addCrumb('Home', array('controller'=>'items', 'action'=>'home'));
$this->Html->addCrumb('Gerência', array('controller'=>'manager', 'action'=>'index'));
$this->Html->addCrumb('Funcionários', array('controller'=>'employees', 'action'=>'index'));
$this->Html->addCrumb('Visualizar', array('controller'=>'employees', 'action'=>'view', $employee['Employee']['id']));
 
echo $this->Html->link(
	$this->Html->image('back.png'),
	'javascript:window.history.go(-1)',
	array('escape'=>false)
);
?>
<div class="well">	
	<div class="page-header">
		<h3>Funcionário</h3>
	</div>
	<dl class="dl-horizontal">
		<dt><?php echo __('Unidade');?></dt>
		<dd><?php echo $employee['Unity']['name'];?></dd>
		<dt><?php echo __('Setor');?></dt>
		<dd><?php echo $employee['Sector']['name'];?></dd>
		<br>
		<dt><?php echo __('Matrícula');?></dt>
		<dd><?php echo $employee['Employee']['registration'];?></dd>
		<dt><?php echo __('Nome');?></dt>
		<dd><?php echo $employee['Employee']['name'].' '.$employee['Employee']['surname'];?></dd>
		<dt><?php echo __('Data de nascimento');?></dt>
		<dd><?php echo $this->Time->format('d-m-Y', $employee['Employee']['birth_date']);?></dd>
		<br>
		<dt><?php echo __('Telefone');?></dt>
		<dd><?php echo $employee['Employee']['phone'];?></dd>
		<dt><?php echo __('Email');?></dt>
		<dd><?php echo $employee['Employee']['email'];?></dd>
		<br>
		<dt><?php echo __('RG');?></dt>
		<dd><?php echo $employee['Employee']['rg'];?>&nbsp;</dd>
		<dt><?php echo __('CPF');?></dt>
		<dd><?php echo $employee['Employee']['cpf'];?>&nbsp;</dd>
		<dt><?php echo __('Título de eleitor');?></dt>
		<dd><?php echo $employee['Employee']['voter_card'];?>&nbsp;</dd>
		<dt><?php echo __('Carteira de trabalho');?></dt>
		<dd><?php echo $employee['Employee']['ctps'];?>&nbsp;</dd>
		<dt><?php echo __('Reservista');?></dt>
		<dd><?php echo $employee['Employee']['reservist']; ?>&nbsp;</dd>
		
		<dt><?php echo __('Agência');?></dt>
		<dd><?php echo $employee['Employee']['agency'];?>&nbsp;</dd>
		<dt><?php echo __('Conta');?></dt>
		<dd><?php echo $employee['Employee']['account'];?></dd>		
	</dl>	
</div>