<?php 
foreach($data as $key=>$value):
?>
	<div style="margin-left:1,5cm;margin-right: 1,5cm">
		
		<table width="100%" style="margin-top: 40px;">
			<tr>
				<td align="left">Memo <?php echo $value['Solicitation']['memo_number'];?></td>
				<td align="right"><?php echo $this->Utils->full_date($value['Solicitation']['created']);?></td>
			</tr>
		</table>
		
		<p>
		DA: <?php echo $value['Sector']['name'];?>
		<br>		
		PARA: Núcleo de Engenharia Clínica
		</p>
		
		<!-- descrição da solicitação-->
		<div style="text-align: justify; margin-top: 50px; line-height: 170%;">
		 	<?php echo strip_tags($value['Solicitation']['description']);?>
		</div>
		
		<p align="center" style="margin-top: 60px;">Atenciosamente,</p>
		<!-- solicitante-->
		<p align="center" style="margin-top: 30px;"><?php echo $value['Employee']['name'].' '.$value['Employee']['surname'];?></p>
	</div>
	
	
	<!-- Pula linha para listar os itens solicitados -->
	<div class="page-break"></div>
	
	
	<p style="padding-bottom: 10px;">
	Unidade: <?php echo $value['Unity']['name'];?>
	<br>
	Setor: <?php echo $value['Sector']['name'];?>
	<br>
	Nº do memorando: <?php echo $value['Solicitation']['memo_number'];?>
	</p>
	<table class="table table-bordered table-condensed">
		<thead>
			<tr>
				<th style="white-space: nowrap;">Código</th>
				<th>Nome</th>
				<th align="center">Qtde</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($value['solicitation_items'] as $item):?>
				<tr>
					<td valign="middle" style="white-space: nowrap;"><?php echo $item['Item']['keycode'];?></td>
					<td align="left"><?php echo $item['Item']['name'];?></td>
					<td align="center" valign="middle"><?php echo $item['SolicitationItem']['quantity'];?></td>
				</tr>
			<?php endforeach;?>
		</tbody>
	</table>	
	
	<div class="page-break"></div>
<?php
endforeach;
?>

<!-- Consolidado -->
<h3 style="text-align:left; padding-bottom:10px;">Consolidado</h3>
<table class="table table-condensed table-bordered">
	<thead>
		<tr>
			<th>Código</th>
			<th>Nome</th>
			<?php foreach($columns as $column): ?>
				<th><?php echo $column;?></th>
			<?php endforeach;?>
			<th>Total</th>	
		</tr>
	</thead>
	<tbody>
		<?php $amount = array();?>
		<?php foreach($consolidation as $key=>$item):?>
			<?php $sum = 0;?>
			<tr>
				<td valign="middle" style="white-space: nowrap;"><?php echo $key;?></td>		
				<td align="left"><?php echo $descriptions[$key]['name'];?></td>				
				<?php foreach($columns as $column): ?>
					<?php if(array_key_exists($column, $item)) {?>
						<td align="center" valign="middle"><?php echo $item[$column];?></td>
						<?php $sum += $item[$column];?>
					<?php }else {?>
						<td align="center" valign="middle"> - </td>
					<?php }?>
				<?php endforeach;?>
				<?php $amount[$key] = $sum;?>
				<td align="center" valign="middle"><?php echo $sum;?></td>		
			</tr>
		<?php endforeach;?>
	</tbody>
</table>

<div class="page-break"></div>

<!-- Descrição dos itens -->

<h3 style="text-align:left; padding-bottom:10px;">Termo de Referência</h3>
<table class="table table-condensed table-bordered">
	<thead>
		<tr>
			<th style="white-space: nowrap;">Código</th>
			<th>Descrição/Especificação</th>
			<th>Total</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($consolidation as $key=>$item):?>
			<tr>
				<td style="white-space: nowrap;"><?php echo $key;?></td>		
				<td align="left">
					<b>Descrição</b>
					<br>
					<div class="justify">
					<?php echo strip_tags($descriptions[$key]['description']);?>
					</div>
					<br>
					<b>Especificações complementares:</b>
					<br>
					<div class="justify">
					<?php echo strip_tags($descriptions[$key]['specification']);?>
					</div>
				</td>
				<td align="center"><?php echo $amount[$key];?></td>				
			</tr>
		<?php endforeach;?>
	</tbody>
</table>
