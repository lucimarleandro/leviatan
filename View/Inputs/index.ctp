<?php 
$this->Html->addCrumb('Home', array('controller'=>'items', 'action'=>'home'));
$this->Html->addCrumb('Gerência', array('controller'=>'manager', 'action'=>'index'));
$this->Html->addCrumb('Insumos', array('controller'=>'inputs', 'action'=>'index'));
?>

<div style="padding-bottom: 20px;">
	<?php 
	echo $this->Html->link('Adicionar', 
		array('controller'=>'inputs', 'action'=>'add'), 
		array('class'=>'btn', 'escape'=>false)
	);
	?>
</div>

<?php if(empty($inputs)) {?>
	<h3><?php echo __('Não há Insumos');?>
<?php } else {?>
	<div class="box-content">
		<table id="table" class="table table-bordered table-hover">
			<thead>
				<tr>
					<th><?php echo __('Categoria');?></th>
					<th><?php echo __('Subcategoria')?></th>
					<th><?php echo __('Ações');?></th>
				</tr>
			</thead>	
			<tbody>
				<?php foreach($inputs AS $input):?>
				<tr>
					<td>
					<?php 
					echo $this->Html->link(
						$input['InputCategory']['name'],
						array('controller'=>'input_categories', 'action'=>'view', $input['InputCategory']['id'])						
					);
					?>
					</td>
					<td>
					<?php 
					echo $this->Html->link(
						$input['InputSubcategory']['name'],
						array('controller'=>'input_subcategories', 'action'=>'view', $input['InputSubcategory']['id'])
					);
					?>
					</td>
					<td class="acoes">
						<?php 
						echo $this->Form->postLink(
							$this->Html->image('delete.png'),
							array('controller'=>'inputs', 'action'=>'delete', $input['Input']['id']),
							array(
								'escape'=>false, 
								'alt'=>'Deletar', 
								'title'=>'Deletar Insumo',
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
