<?php 
$this->Html->addCrumb('Home', array('controller'=>'items', 'action'=>'index'));
$this->Html->addCrumb('Gerência', array('controller'=>'manager', 'action'=>'index'));
$this->Html->addCrumb('Categorias de Insumos', array('controller'=>'input_categories', 'action'=>'index'));
?>

<div style="padding-bottom: 20px;">
	<?php 
	echo $this->Html->link('Adicionar', 
		array('controller'=>'input_categories', 'action'=>'add'), 
		array('class'=>'btn', 'escape'=>false)
	);
	?>
</div>

<?php if(empty($categories)) {?>
	<h3><?php echo __('Não Categorias de Insumos');?>
<?php } else {?>
	<div class="box-content well">
		<table id="table" class="table table-bordered table-hover">
			<thead>
				<tr>
					<th><?php echo __('Nome');?></th>
					<th><?php echo __('Descrição')?></th>
					<th><?php echo __('Ações');?></th>
				</tr>
			</thead>	
			<tbody>
				<?php foreach($categories AS $category):?>
				<tr>
					<td>
					<?php 
					echo $this->Html->link(
						$category['InputCategory']['name'],
						array('controller'=>'input_categories', 'action'=>'view', $category['InputCategory']['id'])						
					);
					?>
					</td>
					<td>
					<?php 
					echo $this->Html->link(
						$category['InputCategory']['description'],
						array('controller'=>'input_categories', 'action'=>'view', $category['InputCategory']['id'])
					);
					?>
					</td>
					<td style="white-space: nowrap;">
						<?php 
						echo $this->Html->link(
							$this->Html->image('edit'),
							array('controller'=>'input_categories', 'action'=>'edit', $category['InputCategory']['id']),
							array(
								'escape'=>false, 
								'alt'=>'Editar', 
								'title'=>'Editar Categoria de Insumo',
							)
						);						
						echo $this->Form->postLink(
							$this->Html->image('delete'),
							array('controller'=>'input_categories', 'action'=>'delete', $category['InputCategory']['id']),
							array(
								'escape'=>false, 
								'alt'=>'Deletar', 
								'title'=>'Deletar Categoria de Insumo',
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
