<?php 
$this->Html->addCrumb('Gerência', '/manager/');
$this->Html->addCrumb('Distritos Sanitários', '/health_districts/');
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
	<div class="box-content well">
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
					<td>
						<?php 
						echo $this->Html->link(
							$this->Html->image('edit'),
							array('controller'=>'health_districts', 'action'=>'edit', $district['HealthDistrict']['id']),
							array(
								'escape'=>false, 
								'alt'=>'Editar', 
								'title'=>'Editar distrito',
							)
						);						
						echo $this->Form->postLink(
							$this->Html->image('delete'),
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
