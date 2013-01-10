<?php 
$this->Html->addCrumb('Home', array('controller'=>'items', 'action'=>'home'));
$this->Html->addCrumb('Gerência', array('controller'=>'manager', 'action'=>'index'));
$this->Html->addCrumb('PNGC', array('controller'=>'pngc_codes', 'action'=>'index'));
?>

<div style="padding-bottom: 20px;">
	<?php 
	echo $this->Html->link('Adicionar', 
		array('controller'=>'pngc_codes', 'action'=>'add'), 
		array('class'=>'btn', 'escape'=>false)
	);
	?>
</div>

<?php if(empty($pngcs)) {?>
	<h3><?php echo __('Não há PNGCs');?>
<?php } else {?>
	<div class="box-content">
		<table id="table" class="table table-bordered table-hover">
			<thead>
				<tr>
					<th><?php echo __('Código');?></th>
					<th><?php echo __('Grupo de Gastos')?></th>
					<th><?php echo __('Categoria');?></th>
					<th><?php echo __('Subcategoria');?></th>
					<th><?php echo __('Unidade de Medida');?></th>
					<th><?php echo __('Ações');?></th>
				</tr>
			</thead>	
			<tbody>
				<?php foreach($pngcs AS $pngc):?>
				<tr>
					<td>
					<?php 
					echo $this->Html->link(
						$pngc['PngcCode']['keycode'],
						array('controller'=>'pngc_codes', 'action'=>'view', $pngc['PngcCode']['id'])						
					);
					?>
					</td>
					<td>
					<?php 
					echo $this->Html->link(
						$pngc['ExpenseGroup']['name'],
						array('controller'=>'expense_groups', 'action'=>'view', $pngc['ExpenseGroup']['id'])
					);
					?>
					</td>
					<td>
					<?php 
					echo $this->Html->link(
						$pngc['InputCategory']['name'],
						array('controller'=>'input_categories', 'action'=>'view', $pngc['InputCategory']['id'])
					);
					?>
					</td>
					<td>
					<?php 
					echo $this->Html->link(
						$pngc['InputSubcategory']['name'],
						array('controller'=>'input_subcategories', 'action'=>'view', $pngc['InputSubcategory']['id'])
					);
					?>
					</td>
					<td>
					<?php 
					echo $this->Html->link(
						$pngc['MeasureType']['name'],
						array('controller'=>'measure_types', 'action'=>'view', $pngc['MeasureType']['id'])
					);
					?>
					</td>
					<td class="acoes">
						<?php 
						echo $this->Form->postLink(
							$this->Html->image('delete.png'),
							array('controller'=>'pngc_codes', 'action'=>'delete', $pngc['PngcCode']['id']),
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
