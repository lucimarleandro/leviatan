<div>
	<table width="100%" style="margin-top: 40px;">
		<tr>
			<td align="left">Memo <?php echo $data[0]['Solicitation']['memo_number'];?></td>
			<td align="right"><?php echo $this->Utils->full_date($data[0]['Solicitation']['created']);?></td>
		</tr>
	</table>
	
	<p>
	DA: <?php echo $data[0]['Sector']['name'];?>
	<br>		
	PARA: Núcleo de Engenharia Clínica
	</p>
	
	<!-- descrição da solicitação-->
	<div style="text-align: justify; margin-top: 50px;">
	 	<?php echo $data[0]['Solicitation']['description'];?>
	</div>
	
	<p align="center" style="margin-top: 60px;">Atenciosamente,</p>
	<!-- solicitante-->
	<p align="center" style="margin-top: 30px;"><?php echo $data[0]['Employee']['name'].' '.$data[0]['Employee']['surname'];?></p>
</div>

<!-- Pula página -->
<div class="page-break"></div>
<!-- Listagem dos itens-->

<?php //echo $this->element('pdf/header');?>
<p style="margin-top: 70px;">
Unidade: <?php echo $data[0]['Unity']['name'];?>
<br>
Setor: <?php echo $data[0]['Sector']['name'];?>
<br>
Nº do memorando: <?php echo $data[0]['Solicitation']['memo_number'];?>
</p>

<table class="table table-bordered table-condensed">
	<thead>
		<tr>
			<th>Código</th>
			<th>Item</th>
			<th>Quantidade</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($data as $value):?>
		<tr>
			<td align="center" style="white-space: nowrap;"><?php echo $value['Item']['keycode'];?></td>
			<td><?php echo $value['Item']['name'];?></td>
			<td align="center" valign="middle"><?php echo $value['SolicitationItem']['quantity'];?></td>
		</tr>
		<?php endforeach;?>
	</tbody>
</table>
