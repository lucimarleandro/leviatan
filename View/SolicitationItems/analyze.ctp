<?php
if(!$ajax) { 
	echo $this->Html->link(
		$this->Html->image('back'),
		array('controller'=>'solicitations', 'action'=>'analyze'),
		array('escape'=>false, 'title'=>'Retorna para a lista de solicitações')
	);
	?>
	<div id="ajax">
		<?php echo $this->element('ajax/solicitation_items/analyze');?>
	</div>
<?php
}else {	
	echo $this->element('ajax/solicitation_items/analyze');	
} 
?>



