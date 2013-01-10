<?php 
$this->Html->addCrumb('Home', array('controller'=>'items', 'action'=>'home'));
$this->Html->addCrumb('Gerência', array('controller'=>'manager', 'action'=>'index'));
$this->Html->addCrumb('Funcionários', array('controller'=>'employees', 'action'=>'index'));
?>

<div style="padding-bottom: 20px;">
	<?php 
	echo $this->Html->link('Adicionar', 
		array('controller'=>'employees', 'action'=>'add'), 
		array('class'=>'btn', 'escape'=>false)
	);
	?>
</div>
<?php if(empty($employees)) {?>
	<h3><?php echo __('Não há funcionários');?>
<?php } else {?>
	<div class="box-content">
		<table id="table" class="table table-bordered table-hover">
			<thead>
				<tr>
					<th><?php echo __('Matrícula');?></th>
					<th><?php echo __('Nome');?></th>
					<th><?php echo __('email');?></th>
					<th><?php echo __('Telefone');?></th>
					<th><?php echo __('Ações');?></th>
				</tr>
			</thead>	
			<tbody>
				<?php foreach($employees AS $employee):?>
				<tr>
					<td>
					<?php 
						echo $this->Html->link(
							$employee['Employee']['registration'],
							array('controller'=>'employees', 'action'=>'view', $employee['Employee']['id'])
						);?>
					</td>
					<td><?php echo $employee['Employee']['name'];?></td>
					<td><?php echo $employee['Employee']['email']?></td>
					<td><?php echo $employee['Employee']['phone'];?></td>
                    <td class="acoes">
						<?php 
						echo $this->Html->link(
							$this->Html->image('edit.png'),
							array('controller'=>'employees', 'action'=>'edit', $employee['Employee']['id']),
							array(
								'escape'=>false, 
								'alt'=>'Editar', 
								'title'=>'Editar funcionário',
							)
						);						
						echo $this->Form->postLink(
							$this->Html->image('delete.png'),
							array('controller'=>'employees', 'action'=>'delete', $employee['Employee']['id']),
							array(
								'escape'=>false, 
								'alt'=>'Delete', 
								'title'=>'Deletar funcionário'								
							),
							__('Deseja, realmente, deletar o funcionário?')
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
