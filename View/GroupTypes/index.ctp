<?php 
$this->Html->addCrumb('Home', array('controller'=>'items', 'action'=>'home'));
$this->Html->addCrumb('Gerência', array('controller'=>'manager', 'action'=>'index'));
$this->Html->addCrumb('Tipos de Grupos', array('controller'=>'group_types', 'action'=>'index'));
?>

<div style="padding-bottom: 20px;">
	<?php 
	echo $this->Html->link('Adicionar', 
		array('controller'=>'group_types', 'action'=>'add'), 
		array('class'=>'btn', 'escape'=>false)
	);
	?>
</div>

<?php if(empty($groups)) {?>
	<h3><?php echo __('Não há Tipos de Grupos');?>
<?php } else {?>
	<div class="box-content">
		<table id="table" class="table table-bordered table-hover">
			<thead>
				<tr>
					<th><?php echo __('Nome');?></th>
					<th><?php echo __('Ações');?></th>
				</tr>
			</thead>	
			<tbody>
				<?php foreach($groups AS $group):?>
				<tr>
					<td>
					<?php 
					echo $this->Html->link(
						$group['GroupType']['name'],
						array('controller'=>'group_types', 'action'=>'view', $group['GroupType']['id'])						
					);
					?>
					</td>
					<td class="acoes">
						<?php 
						echo $this->Html->link(
							$this->Html->image('edit.png'),
							array('controller'=>'group_types', 'action'=>'edit', $group['GroupType']['id']),
							array(
								'escape'=>false, 
								'alt'=>'Editar', 
								'title'=>'Editar tipo da grupo',
							)
						);						
						echo $this->Form->postLink(
							$this->Html->image('delete.png'),
							array('controller'=>'group_types', 'action'=>'delete', $group['GroupType']['id']),
							array(
								'escape'=>false, 
								'alt'=>'Deletar', 
								'title'=>'Deletar tipo da grupo',
							)
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
