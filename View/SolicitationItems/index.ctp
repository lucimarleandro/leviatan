<?php 
$this->Html->addCrumb('Itens', '/items/');
$this->Html->addCrumb('Solicitar', '/solicitation_items/');
?>
<?php if(!$ajax) {?>
<div class="box">
	<?php echo $this->element('box_search');?>
	<?php echo $this->Form->input('url', array('type'=>'hidden', 'id'=>'url', 'value'=>'/solicitation_items/index'));?>
	<div id="items">
		<?php echo $this->element('ajax/solicitation_items/index');?>
	</div>
</div>
<?php }else {
	echo $this->element('ajax/solicitation_items/index');
}?>