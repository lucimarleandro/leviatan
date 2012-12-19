<?php 
$this->Html->addCrumb('Home', array('controller'=>'items', 'action'=>'home'));
$this->Html->addCrumb('Gerência', array('controller'=>'manager', 'action'=>'index'));
$this->Html->addCrumb('Unidades de Medidas', array('controller'=>'measure_types', 'action'=>'index'));
?>
<div style="padding-bottom: 20px;">
	<?php 
	echo $this->Html->link('Adicionar', 
		array('controller'=>'measure_types', 'action'=>'add'), 
		array('class'=>'btn', 'escape'=>false)
	);
	?>
</div>

<?php if(empty($types)) {?>
	<h3><?php echo __('Não há Unidades de Medidas');?>
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
				<?php foreach($types AS $type):?>
				<tr>
					<td>
					<?php 
					echo $this->Html->link(
						$type['MeasureType']['name'],
						array('controller'=>'measure_types', 'action'=>'view', $type['MeasureType']['id'])						
					);
					?>
					</td>
					<td>
					<?php 
					echo $type['MeasureType']['description'];
					?>
					</td>
					<td>
						<?php 
						echo $this->Html->link(
							$this->Html->image('edit'),
							array('controller'=>'measure_types', 'action'=>'edit', $type['MeasureType']['id']),
							array(
								'escape'=>false, 
								'alt'=>'Editar', 
								'title'=>'Editar Unidade de Medida',
							)
						);						
						echo $this->Form->postLink(
							$this->Html->image('delete'),
							array('controller'=>'measure_types', 'action'=>'delete', $type['MeasureType']['id']),
							array(
								'escape'=>false, 
								'alt'=>'Deletar', 
								'title'=>'Deletar Unidade de Medida',
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
