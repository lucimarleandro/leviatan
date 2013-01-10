<?php 
$this->Html->addCrumb('Home', array('controller'=>'items', 'action'=>'home'));
$this->Html->addCrumb('Gerência', array('controller'=>'manager', 'action'=>'index'));
$this->Html->addCrumb('Distritos Sanitários', array('controller'=>'health_districts', 'action'=>'index'));
?>

<div style="padding-bottom: 20px;">
	<?php 
	echo $this->Html->link('Adicionar', 
		array('controller'=>'health_districts', 'action'=>'add'), 
		array('class'=>'btn', 'escape'=>false)
	);
	?>
</div>

<?php if(empty($districts)) {?>
	<h3><?php echo __('Não há Distritos Sanitários');?>
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
				<?php foreach($districts AS $district):?>
				<tr>
					<td>
					<?php 
					echo $this->Html->link(
						$district['HealthDistrict']['name'],
						array('controller'=>'health_districts', 'action'=>'view', $district['HealthDistrict']['id'])						
					);
					?>
					</td>
					<td class="acoes">
						<?php 
						echo $this->Html->link(
							$this->Html->image('edit.png'),
							array('controller'=>'health_districts', 'action'=>'edit', $district['HealthDistrict']['id']),
							array(
								'escape'=>false, 
								'alt'=>'Editar', 
								'title'=>'Editar distrito',
							)
						);						
						echo $this->Form->postLink(
							$this->Html->image('delete.png'),
							array('controller'=>'health_districts', 'action'=>'delete', $district['HealthDistrict']['id']),
							array(
								'escape'=>false, 
								'alt'=>'Deletar', 
								'title'=>'Deletar distrito',
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
