<?php 
$this->Html->addCrumb('Home', array('controller'=>'items', 'action'=>'home'));
$this->Html->addCrumb('Pedidos', array('controller'=>'orders', 'action'=>'index'));
$this->Html->addCrumb('Visualizar', '');


echo $this->Html->link(
	$this->Html->image('back'),
	array('controller'=>'orders', 'action'=>'index'),
	array('escape'=>false, 'title'=>'Retornar')		
);
?>

<?php if(empty($orders)) {?>
	<h3><?php echo __('Não há pedidos');?></h3>
<?php }else {?>
	<div class="box-content">
		<div>
			<table id="table" class="table table-bordered table-hover">
				<thead>
					<tr>
						<th>Código</th>
						<th>Data</th>
						<th>Ação</th>
					</tr>
				</thead>	
				<tbody>
					<?php foreach($orders AS $order):?>
					<tr>
						<td><?php echo $order['Order']['keycode'];?></td>
						<td><?php echo $this->Time->format('d/m/Y', $order['Order']['created']);?></td>
						<td>
						<?php 
						echo $this->Form->postLink(
							$this->Html->image('print'), 
							array('controller'=>'orders','action' => 'report', $order['Order']['id'], 'ext'=>'pdf'), 
							array('escape'=>false)); 
						?>
						</td>
					</tr>
					<?php endforeach;?>
				</tbody>	
			</table>
		</div>
	</div>	
	<?php echo $this->element('pagination');?>
<?php }?>