<?php 
$this->Html->addCrumb('Gerência', '/manager/');
$this->Html->addCrumb('Grupos de Gastos', '/expense_groups/');
?>
<div style="padding-bottom: 20px;">
	<?php 
	echo $this->Html->link('Adicionar', 
		array('controller'=>'expense_groups', 'action'=>'add'), 
		array('class'=>'btn', 'escape'=>false)
	);
	?>
</div>

<?php if(empty($groups)) {?>
	<h3><?php echo __('Não há Grupos de Gastos');?>
<?php } else {?>
	<div class="box-content well">
		<table id="table" class="table table-bordered table-hover">
			<thead>
				<tr>
					<th><?php echo __('Nome');?></th>
					<th><?php echo __('Descrição');?></th>
					<th><?php echo __('Ações');?></th>
				</tr>
			</thead>	
			<tbody>
				<?php foreach($groups AS $group):?>
				<tr>
					<td>
					<?php 
					echo $this->Html->link(
						$group['ExpenseGroup']['name'],
						array('controller'=>'expense_groups', 'action'=>'view', $group['ExpenseGroup']['id'])						
					);
					?>
					</td>
					<td>
					<?php 
					echo $group['ExpenseGroup']['description'];
					?>
					</td>
					<td style="white-space: nowrap;">
						<?php 
						echo $this->Html->link(
							$this->Html->image('edit'),
							array('controller'=>'expense_groups', 'action'=>'edit', $group['ExpenseGroup']['id']),
							array(
								'escape'=>false, 
								'alt'=>'Editar', 
								'title'=>'Editar Grupo de Gasto',
							)
						);						
						echo $this->Form->postLink(
							$this->Html->image('delete'),
							array('controller'=>'expense_groups', 'action'=>'delete', $group['ExpenseGroup']['id']),
							array(
								'escape'=>false, 
								'alt'=>'Deletar', 
								'title'=>'Deletar Grupo de Gasto',
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
