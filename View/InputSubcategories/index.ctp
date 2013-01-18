<?php 
$this->Html->addCrumb('Home', array('controller'=>'items', 'action'=>'home'));
$this->Html->addCrumb('Gerência', array('controller'=>'manager', 'action'=>'index'));
$this->Html->addCrumb('Subcategorias de Insumos', array('controller'=>'input_subcategories', 'action'=>'index'));
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
	<div class="box-content">
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
					echo $subcategory['InputSubcategory']['description'];
					?>
					</td>
					<td class="acoes">
						<?php 
						echo $this->Html->link(
							$this->Html->image('edit.png'),
							array('controller'=>'input_subcategories', 'action'=>'edit', $subcategory['InputSubcategory']['id']),
							array(
								'escape'=>false, 
								'alt'=>'Editar', 
								'title'=>'Editar Subcategoria de Insumo',
							)
						);						
						echo $this->Form->postLink(
							$this->Html->image('delete.png'),
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
