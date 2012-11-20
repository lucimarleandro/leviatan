<?php 
$this->Html->addCrumb('Gerência', '/manager/');
$this->Html->addCrumb('Setores', '/sectors/');
?>
<div style="padding-bottom: 20px;">
	<?php 
	echo $this->Html->link('Adicionar', 
		array('controller'=>'sectors', 'action'=>'add'), 
		array('class'=>'btn', 'escape'=>false)
	);
	?>
</div>

<?php if(empty($sectors)) {?>
	<h3><?php echo __('Não há Setores');?>
<?php } else {?>
	<div class="box-content well">
		<table id="table" class="table table-bordered table-hover">
			<thead>
				<tr>
					<th><?php echo __('Nome');?></th>
					<th><?php echo __('Ações');?></th>
				</tr>
			</thead>	
			<tbody>
				<?php foreach($sectors AS $sector):?>
				<tr>
					<td>
					<?php 
					echo $this->Html->link(
						$sector['Sector']['name'],
						array('controller'=>'sectors', 'action'=>'view', $sector['Sector']['id'])						
					);
					?>
					</td>
					<td>
						<?php 
						echo $this->Html->link(
							$this->Html->image('edit'),
							array('controller'=>'sectors', 'action'=>'edit', $sector['Sector']['id']),
							array(
								'escape'=>false, 
								'alt'=>'Editar', 
								'title'=>'Editar setor',
							)
						);						
						echo $this->Form->postLink(
							$this->Html->image('delete'),
							array('controller'=>'sectors', 'action'=>'delete', $sector['Sector']['id']),
							array(
								'escape'=>false, 
								'alt'=>'Deletar', 
								'title'=>'Deletar setor',
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
