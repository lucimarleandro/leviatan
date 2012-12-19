<?php 
$this->Html->addCrumb('Home', array('controller'=>'items', 'action'=>'home'));
$this->Html->addCrumb('Gerência', array('controller'=>'items', 'action'=>'home'));
$this->Html->addCrumb('Tipos de Unidades', array('controller'=>'unity_types', 'action'=>'index'));
?>

<div style="padding-bottom: 20px;">
	<?php 
	echo $this->Html->link('Adicionar', 
		array('controller'=>'unity_types', 'action'=>'add'), 
		array('class'=>'btn', 'escape'=>false)
	);
	?>
</div>

<?php if(empty($types)) {?>
	<h3><?php echo __('Não há tipos de unidades');?>
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
				<?php foreach($types AS $type):?>
				<tr>
					<td>
					<?php 
					echo $this->Html->link(
						$type['UnityType']['name'],
						array('controller'=>'unity_types', 'action'=>'view', $type['UnityType']['id'])						
					);
					?>
					</td>
					<td>
						<?php 
						echo $this->Html->link(
							$this->Html->image('edit'),
							array('controller'=>'unity_types', 'action'=>'edit', $type['UnityType']['id']),
							array(
								'escape'=>false, 
								'alt'=>'Editar', 
								'title'=>'Editar tipo da unidade',
							)
						);						
						echo $this->Form->postLink(
							$this->Html->image('delete'),
							array('controller'=>'unity_types', 'action'=>'delete', $type['UnityType']['id']),
							array(
								'escape'=>false, 
								'alt'=>'Deletar', 
								'title'=>'Deletar tipo da unidade',
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
