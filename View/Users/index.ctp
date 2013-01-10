<?php 
$this->Html->addCrumb('Home', array('controller'=>'items', 'action'=>'home'));
$this->Html->addCrumb('Gerência', array('controller'=>'manager', 'action'=>'index'));
$this->Html->addCrumb('Usuários', array('controller'=>'users', 'action'=>'index'));
?>
<div style="padding-bottom: 20px;">
	<?php 
	echo $this->Html->link('Adicionar', 
		array('controller'=>'users', 'action'=>'add'), 
		array('class'=>'btn', 'escape'=>false)
	);
	?>
</div>
<?php if(empty($users)) {?>
	<h3><?php echo __('Não há usuários');?>
<?php } else {?>
	<div class="box-content">
		<table id="table" class="table table-bordered table-hover">
			<thead>
				<tr>
					<th><?php echo __('Grupo')?></th>
					<th><?php echo __('Login');?></th>
					<th><?php echo __('Nome');?></th>
                    <th><?php echo __('Ação');?></th>
				</tr>
			</thead>	
			<tbody>
				<?php foreach($users AS $user):?>
				<tr>
					<td><?php echo $user['Group']['name'];?></td>
					<td>
					<?php 
					echo $this->Html->link(
						$user['Employee']['registration'],
						array('controller'=>'users', 'action'=>'view', $user['User']['id'])
					);
					?>
					</td>
					<td><?php echo $user['Employee']['name'].' '.$user['Employee']['surname'];?></td>
					<td class="acoes">
						<?php 
						echo $this->Form->postLink(
							$this->Html->image('delete.png'),
							array('controller'=>'users', 'action'=>'delete', $user['User']['id']),
							array(
								'escape'=>false, 
								'alt'=>'delete', 
								'title'=>'Deletar usuário',
							),
							__('Deseja, realmente, deletar o usuário?')
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
