<?php 
$this->Html->addCrumb('Home', array('controller'=>'items', 'action'=>'home'));
$this->Html->addCrumb('Solicitações', array('controller'=>'solicitations', 'action'=>'analyze'));
$this->Html->addCrumb('Itens', array('controller'=>'solicitation_items', 'action'=>'analyze', $solicitation_id));
?>
<?php
if(!$ajax) { 
	echo $this->Html->link(
		$this->Html->image('back.png'),
		array('controller'=>'solicitations', 'action'=>'analyze'),
		array('escape'=>false, 'title'=>'Retorna para a lista de solicitações')
	);
	?>

    <ul class="nav nav-tabs" id="myTab">
		<li class="active"><a title="Descrição da solicitação" href="#text"><?php echo __('Descrição')?></a></li>
		<li><a title="Itens da solicitação" href="#items"><?php echo __('Itens')?></a></li>
        <li><a title="Anexo da solicitação" href="#attachment"><?php echo __('Anexo')?></a></li>
	</ul>
    <div class="tab-content">
        <div class="tab-pane active well" id="text">
            <p><?php echo '<b>Unidade: </b>'.$solicitationItems[0]['Unity']['name']; ?></p>
            <p><?php echo '<b>Setor: </b>'.$solicitationItems[0]['Sector']['name']; ?></p>
            <p><?php echo '<b>Nº memorando: </b>'.$solicitationItems[0]['Solicitation']['memo_number']; ?></p>
            <?php echo $solicitationItems[0]['Solicitation']['description']; ?>
        </div>   
        <div style="overflow: hidden;" class="tab-pane" id="items">
            <?php echo $this->element('ajax/solicitation_items/analyze');?>
        </div>
        <div class="tab-pane well" id="attachment">
            <?php 
            if($solicitationItems[0]['Solicitation']['attachment']) {
                echo $solicitationItems[0]['Solicitation']['attachment'];
            }else {
                echo '<b>Não existe anexo</b>';
            }
            ?>
        </div>
    </div>
<?php
}else {	
	echo $this->element('ajax/solicitation_items/analyze');	
} 
?>

<script>
$('#myTab a').click(function (e) {
  e.preventDefault();
  $(this).tab('show');
});
</script>

