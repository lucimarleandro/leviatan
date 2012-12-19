<?php 
$this->Html->addCrumb('Home', array('controller'=>'items', 'action'=>'home'));
$this->Html->addCrumb('Minhas Solicitações', array('controller'=>'solicitations', 'action'=>'index'));
$this->Html->addCrumb('Visualizar', array('controller'=>'solicitations', 'action'=>'view', $solicitation[0]['Solicitation']['id']));
if(!$ajax) {
	echo $this->Html->link(
		$this->Html->image('back'),
		'javascript:window.history.go(-1)',
		array('escape'=>false)
	);
?>
	<ul class="nav nav-tabs" id="myTab">
		<li class="active"><a title="Descrição da solicitação" href="#text"><?php echo __('Descrição')?></a></li>
		<li><a title="Itens da solicitação" href="#items"><?php echo __('Itens')?></a></li>
        <li><a title="Anexo da solicitação" href="#attachment"><?php echo __('Anexo')?></a></li>
	</ul>
	<div class="tab-content">
		<div class="tab-pane active well" id="text">	
			<div id="validation"></div>
			<?php echo $this->Form->create('Solicitation', array('class'=>'form-horizontal')); ?>
			<fieldset>
				<div class="control-group">
					<label class="control-label" for="Nº do memorando">Nº do memorando</label>
					<div class="controls">
						<?php echo $solicitation[0]['Solicitation']['memo_number']; ?>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="Decrição da solicitação">Texto</label>
					<div class="controls">
						<?php echo $solicitation[0]['Solicitation']['description'];?>
					</div>
				</div>
			</fieldset>
			<?php echo $this->Form->end();?>
		</div>
		<div class="tab-pane well" id="items">
			<?php echo $this->element('ajax/solicitations/view');?>
		</div>		
        <div class="tab-pane well" id="attachment">
            <?php 
            if($solicitation[0]['Solicitation']['attachment']) {
                echo $solicitation[0]['Solicitation']['attachment'];
            }else {
                echo '<b>Não existe anexo</b>';
            }
            ?>
        </div>
	</div>
<?php 
}else {	
	echo $this->element('ajax/solicitations/view');
}
?>

<script>
$('#myTab a').click(function (e) {
  e.preventDefault();
  $(this).tab('show');
});
</script>
