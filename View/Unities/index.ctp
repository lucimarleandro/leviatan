<?php 
$this->Html->addCrumb('Home', array('controller'=>'items', 'action'=>'home'));
$this->Html->addCrumb('Gerência', array('controller'=>'items', 'action'=>'home'));
$this->Html->addCrumb('Unidade', array('controller'=>'unities', 'action'=>'index'));
?>

<div style="padding-bottom: 20px;">
	<?php 
	echo $this->Html->link('Adicionar', 
		array('controller'=>'unities', 'action'=>'add'), 
		array('class'=>'btn', 'escape'=>false)
	);
	?>
</div>
<?php if(empty($unities)) {?>
	<h3><?php echo __('Não há solicitações');?>
<?php } else {?>
	<div class="box-content">
		<table id="table" class="table table-bordered table-hover">
			<thead>
				<tr>
					<th><?php echo __('CNES');?></th>
					<th><?php echo __('Nome');?></th>
					<th><?php echo __('Endereço');?></th>
					<th><?php echo __('Ações');?></th>
				</tr>
			</thead>	
			<tbody>
				<?php foreach($unities AS $unity):?>
				<tr>
					<td><?php echo $unity['Unity']['cnes'];?></td>
					<td><?php echo $this->Html->link($unity['Unity']['name'], array('controller'=>'unities', 'action'=>'view', $unity['Unity']['id']));?></td>
					<td><?php echo $unity['Address']['name'];?></td>
					<td class="acoes">
						<?php 
						echo $this->Html->link(
							$this->Html->image('edit.png'),
                                                        array('controller'=>'unities', 'action'=>'edit', $unity['Unity']['id']),
							array(
								'escape'=>false, 
								'alt'=>'Visualizar', 
								'title'=>'Editar unidade',
							)
						);						
						echo $this->Form->postLink(
							$this->Html->image('delete.png'),
							array('controller'=>'unities', 'action'=>'delete', $unity['Unity']['id']),
							array(
								'escape'=>false, 
								'alt'=>'delete', 
								'title'=>'Deletar unidade',
							),
							__('Deseja, realmente, deletar a unidade?')
						);						
						?>
					</td>
				</tr>
				<?php endforeach;?>
			</tbody>	
		</table>
	</div>	
	<?php echo $this->element('pagination');?>
<?php }?>
