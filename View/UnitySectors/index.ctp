<?php
$this->Html->addCrumb('Home', array('controller'=>'items', 'action'=>'home'));
$this->Html->addCrumb('Gerência', array('controller'=>'items', 'action'=>'home'));
$this->Html->addCrumb('Unidades-Setores', array('controller'=>'unity_sectors', 'action'=>'index'));
?>

<div style="padding-bottom: 20px;">
	<?php 
	echo $this->Html->link('Adicionar', 
		array('controller'=>'unity_sectors', 'action'=>'add'), 
		array('class'=>'btn', 'escape'=>false)
	);
	?>
</div>
<?php if(empty($unitySectors)) {?>
	<h3><?php echo __('Não há relação de unidade com os setores');?>
<?php } else {?>
	<div class="box-content well">
		<table id="table" class="table table-bordered table-hover">
			<thead>
				<tr>
					<th><?php echo __('Unidade');?></th>
					<th><?php echo __('Setor');?></th>
					<th><?php echo __('Ação');?></th>
				</tr>
			</thead>	
			<tbody>
				<?php foreach($unitySectors AS $us):?>
				<tr>
					<td><?php echo $us['Unity']['name'];?></td>
					<td><?php echo $us['Sector']['name'];?></td>
					<td>
						<?php 
						echo $this->Form->postLink(
							$this->Html->image('delete'),
							array('controller'=>'unity_sectors', 'action'=>'delete', $us['UnitySector']['id']),
							array(
								'escape'=>false, 
								'alt'=>'delete', 
								'title'=>'Deletar relação',
							),
							__('Deseja, realmente, deletar a relação da unidade e do setor?')
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
