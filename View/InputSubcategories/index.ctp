<?php 
$this->Html->addCrumb('Gerência', '/manager/');
$this->Html->addCrumb('Subcategoria de Insumos', '/input_subcategories/');
?>

<div style="padding-bottom: 20px;">
	<?php 
	echo $this->Html->link('Adicionar', 
		array('controller'=>'input_subcategories', 'action'=>'add'), 
		array('class'=>'btn', 'escape'=>false)
	);
	?>
</div>

<?php if(empty($subcategories)) {?>
	<h3><?php echo __('Não há Subcategorias de Insumos');?>
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
				<?php foreach($subcategories AS $subcategory):?>
				<tr>
					<td>
					<?php 
					echo $this->Html->link(
						$subcategory['InputSubcategory']['name'],
						array('controller'=>'input_subcategories', 'action'=>'view', $subcategory['InputSubcategory']['id'])						
					);
					?>
					</td>
					<td>
					<?php 
					echo $this->Html->link(
						$subcategory['InputSubcategory']['description'],
						array('controller'=>'input_subcategories', 'action'=>'view', $subcategory['InputSubcategory']['id'])
					);
					?>
					</td>
					<td style="white-space: nowrap;">
						<?php 
						echo $this->Html->link(
							$this->Html->image('edit'),
							array('controller'=>'input_subcategories', 'action'=>'edit', $subcategory['InputSubcategory']['id']),
							array(
								'escape'=>false, 
								'alt'=>'Editar', 
								'title'=>'Editar Subcategoria de Insumo',
							)
						);						
						echo $this->Form->postLink(
							$this->Html->image('delete'),
							array('controller'=>'input_subcategories', 'action'=>'delete', $subcategory['InputSubcategory']['id']),
							array(
								'escape'=>false, 
								'alt'=>'Deletar', 
								'title'=>'Deletar Subcategoria de Insumo',
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
