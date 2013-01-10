<?php 
$this->Html->addCrumb('Home', array('controller'=>'items', 'action'=>'home'));
$this->Html->addCrumb('Gerência', array('controller'=>'manager', 'action'=>'index'));
$this->Html->addCrumb('Grupos dos itens', array('controller'=>'item_groups', 'action'=>'index'));
?>

<div style="padding-bottom: 20px;">
	<?php 
	echo $this->Html->link('Adicionar', 
		array('controller'=>'item_groups', 'action'=>'add'), 
		array('class'=>'btn', 'escape'=>false)
	);
	?>
</div>

<?php if(empty($groups)) {?>
	<h3><?php echo __('Não há Grupo de Itens');?>
<?php } else {?>
	<div class="box-content">
		<table id="table" class="table table-bordered table-hover">
			<thead>
				<tr>
					<th><?php echo __('Tipo')?></th>
					<th><?php echo __('Código')?></th>
					<th><?php echo __('Nome');?></th>
					<th><?php echo __('Ações');?></th>
				</tr>
			</thead>	
			<tbody>
				<?php foreach($groups AS $group):?>
				<tr>
					<td>
					<?php 
					echo $group['GroupType']['name'];
					?>
					</td>
					<td>
					<?php 
					echo $group['ItemGroup']['keycode']; 
					?>
					</td>
					<td>
					<?php 
					echo $this->Html->link(
						$group['ItemGroup']['name'],
						array('controller'=>'item_groups', 'action'=>'view', $group['ItemGroup']['id'])						
					);
					?>
					</td>
					<td class="acoes">
						<?php 
						echo $this->Html->link(
							$this->Html->image('edit.png'),
							array('controller'=>'item_groups', 'action'=>'edit', $group['ItemGroup']['id']),
							array(
								'escape'=>false, 
								'alt'=>'Editar', 
								'title'=>'Editar grupo do item',
							)
						);						
						echo $this->Form->postLink(
							$this->Html->image('delete.png'),
							array('controller'=>'item_groups', 'action'=>'delete', $group['ItemGroup']['id']),
							array(
								'escape'=>false, 
								'alt'=>'Deletar', 
								'title'=>'Deletar grupo do item',
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
