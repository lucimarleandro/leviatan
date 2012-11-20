<?php if(empty($items)) {?>
	<h3><?php echo __('Não há Itens');?></h3>
<?php }else {?>
	<div class="box-content">
		<div>
			<table id="table" class="table table-bordered table-hover">
				<thead>
					<tr>
						<th><?php echo $this->Form->checkbox('checkall')?></th>
						<th>Código</th>
						<th>Nome</th>
						<th>Classe</th>
						<th>PNGC</th>
						<th>Ações</th>
					</tr>
				</thead>	
				<tbody>
					<?php foreach($items AS $item):?>
					<tr>
						<td>
							<?php 
							echo $this->Form->checkbox('check', 
								array(
									'checked'=>$item['Item']['status_id'] == ATIVO ? TRUE : FALSE, 
									'disabled'=>($user['group_id'] == ADMIN || $user['group_id'] == HOMOLOGADOR) ? "" : 'disabled',
									'class'=>'changeStatus',
									'value'=>$item['Item']['id']
								)
							);
							?>
						</td>
						<td><?php echo $item['Item']['keycode'];?></td>
						<td><?php echo $this->Html->link($item['Item']['name'], array('controller'=>'items', 'action'=>'view', $item['Item']['id']));?></td>
						<td><?php echo $this->Html->link($item['ItemClass']['keycode'], array('controller'=>'item_classes', 'action'=>'view', $item['Item']['item_class_id']));?></td>
						<td><?php echo $this->Html->link($item['PngcCode']['keycode'], array('controller'=>'pngc_codes', 'action'=>'view', $item['Item']['pngc_code_id']));?></td>
						<td style="white-space: nowrap;">
							<?php 
							echo $this->Html->link(
								$this->Html->image('edit'), 
								array('controller'=>'items', 'action'=>'edit', $item['Item']['id']), 
								array('escape'=>false, 'title'=>'Editar item')
							);
							echo $this->Form->postLink(
								$this->Html->image('delete'), 
								array('controller'=>'items', 'action'=>'delete', $item['Item']['id']), 
								array('escape'=>false, 'title'=>'Deletar item', 'confirm'=>'Tem certeza que deseja excluir o item?')
							);
							?>
						</td>
					</tr>
					<?php endforeach;?>
				</tbody>	
			</table>
		</div>
	</div>	
	<?php echo $this->Paginator->options(array(
			'update'=>'#items',
			'evalScript'=>true
		)
	);
	?>
	<?php echo $this->element('pagination');?>
<?php }?>