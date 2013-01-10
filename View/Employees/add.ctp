<?php 
$this->Html->addCrumb('Home', array('controller'=>'items', 'action'=>'home'));
$this->Html->addCrumb('Gerência', array('controller'=>'manager', 'action'=>'index'));
$this->Html->addCrumb('Funcionários', array('controller'=>'employees', 'action'=>'index'));
$this->Html->addCrumb('Adicionar', array('controller'=>'employees', 'action'=>'add'));

echo $this->Html->link(
	$this->Html->image('back.png'),
	array('controller'=>'employees', 'action'=>'index'),
	array('escape'=>false)		
);
?>
<div class="well">
	<?php echo $this->Form->create('Employee', array('class'=>'form-horizontal')); ?>
		<fieldset>
			<legend>Adicionar funcionário</legend>
			<div class="control-group required">
				<label class="control-label" for="Unidade">Unidade</label>
				<div class="controls">
					<?php 
					echo $this->Form->input('unity_id', 
						array(
							'label'=>false, 
							'class'=>'input',
							'options'=>$unities
						)
					);
					?>
				</div>
			</div>			
			<div class="control-group required">
				<label class="control-label" for="Setor">Setor</label>
				<div class="controls">
					<?php 
					echo $this->Form->input('sector_id', 
						array(
							'label'=>false, 
							'class'=>'input',
							'options'=>array(''=>'Selecione uma unidade')
						)
					);
					?>
				</div>
			</div>
			<div class="control-group required">
				<label class="control-label" for="Matrícula">Matrícula</label>
				<div class="controls">
					<?php 
					echo $this->Form->input('registration', 
						array(
							'label'=>false, 
							'class'=>'input-small',
							'maxlength'=>6
						)
					);
					?>
				</div>
			</div>
			<div class="control-group required">
				<label class="control-label" for="Nome">Nome</label>
				<div class="controls">
					<?php 
					echo $this->Form->input('name', 
						array(
							'label'=>false, 
							'class'=>'input-small',
						)
					);
					?>
				</div>
			</div>
			<div class="control-group required">
				<label class="control-label" for="surname">Sobrenome</label>
				<div class="controls">
					<?php 
					echo $this->Form->input('surname', 
						array(
							'label'=>false, 
							'class'=>'input',
						)
					);
					?>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="Data de nascimento">Data de nascimento</label>
				<div class="controls">
					<?php 
					echo $this->Form->input('birth_date', 
						array(
							'label'=>false, 
							'class'=>'input',
							'type'=>'text'
						)
					);
					?>
				</div>
			</div>
			<div class="control-group required">
				<label class="control-label" for="Email">Email</label>
				<div class="controls">
					<?php 
					echo $this->Form->input('email', 
						array(
							'label'=>false, 
							'class'=>'input',
						)
					);
					?>
				</div>
			</div>
			<div class="control-group required">
				<label class="control-label" for="Telefone">Telefone</label>
				<div class="controls">
					<?php 
					echo $this->Form->input('phone', 
						array(
							'label'=>false, 
							'class'=>'input',
						)
					);
					?>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="RG">RG</label>
				<div class="controls">
					<?php 
					echo $this->Form->input('rg', 
						array(
							'label'=>false, 
							'class'=>'input',
						)
					);
					?>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="CPF">CPF</label>
				<div class="controls">
					<?php 
					echo $this->Form->input('cpf', 
						array(
							'label'=>false, 
							'class'=>'input',
						)
					);
					?>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="Título">Título de Eleitor</label>
				<div class="controls">
					<?php 
					echo $this->Form->input('voter_card', 
						array(
							'label'=>false, 
							'class'=>'input',
						)
					);
					?>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="Carteira de Trabalho">Carteira de Trabalho</label>
				<div class="controls">
					<?php 
					echo $this->Form->input('ctps', 
						array(
							'label'=>false, 
							'class'=>'input',
						)
					);
					?>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="Reservista">Reservista</label>
				<div class="controls">
					<?php 
					echo $this->Form->input('reservist', 
						array(
							'label'=>false, 
							'class'=>'input',
						)
					);
					?>
				</div>
			</div>
			<h2>Dados Bancários</h2>
			<div class="control-group">
				<label class="control-label" for="Agência">Agência</label>
				<div class="controls">
					<?php 
					echo $this->Form->input('agency', 
						array(
							'label'=>false, 
							'class'=>'input',
						)
					);
					?>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="Conta">Conta</label>
				<div class="controls">
					<?php 
					echo $this->Form->input('account', 
						array(
							'label'=>false, 
							'class'=>'input',
						)
					);
					?>
				</div>
			</div>
			
			<div class="form-actions">
				<?php echo $this->Form->button('Enviar', array('class'=>'btn btn-primary', 'type'=>'submit'));?>
      			<?php echo $this->Html->link('Cancelar', array('controller'=>'employees', 'action'=>'index'), array('class'=>'btn'));?>
    		</div>
		</fieldset>
	<?php echo $this->Form->end(); ?>
</div>
<script>
$('#EmployeePhone').mask('(99)9999-9999', {placeholder:" "}); //telefone
$('#EmployeeBirthDate').mask('99/99/9999', {placeholder: " "});
					
$('#EmployeeAddForm').validate({
	ignore: "",
	rules: {
		'data[Employee][unity_id]': {
		    required: true
		},
		'data[Employee][unity_sector_id]': {
		    required: true
		},
		'data[Employee][registration]': {
		    required: true,
		    rangelength: [6,6]
		},
		'data[Employee][name]': {
		    required: true
		},
		'data[Employee][surname]': {
		    required: true
		},
		'data[Employee][email]': {
		    required: true,
		    email: true
		},
		'data[Employee][phone]': {
		    required: true
		},
	},
	messages: {
		'data[Employee][unity_id]': {
		    required: "Campo obrigatório"
		},
		'data[Employee][unity_sector_id]': {
		    required: "Campo obrigatório"
		},
		'data[Employee][registration]': {
		    required: "Campo obrigatório",
		    rangelength: "Matrícula deve ter 6 dígitos"
		},
		'data[Employee][name]': {
		    required: "Campo obrigatório"
		},
		'data[Employee][surname]': {
		    required: "Campo obrigatório"
		},
		'data[Employee][email]': {
		    required: "Campo obrigatório",
		   	email: "Email inválido"
		},
		'data[Employee][phone]': {
		    required: "Campo obrigatório"
		},
	},
	highlight: function(label) {
		$(label).closest('.control-group').addClass('error');
	},
	success: function(label) {
		label
		.text('OK!').addClass('valid')
		.closest('.control-group').addClass('success');
	},
	errorPlacement: function(label, element) {
		// position error label after generated textarea
		if (element.is("textarea")) {
			label.insertAfter(element.next());
		} else {
			label.insertAfter(element)
		}
	}
});

$("#EmployeeBirthDate").datepicker({
	yearRange: "1900:2012",
	changeMonth: true,
	changeYear: true,
	dateFormat: 'dd/mm/yy',
	dayNames: [
		'Domingo','Segunda','Terça','Quarta','Quinta','Sexta','Sábado','Domingo'
	],
	dayNamesMin: [
		'D','S','T','Q','Q','S','S','D'
	],
	dayNamesShort: [
		'Dom','Seg','Ter','Qua','Qui','Sex','Sáb','Dom'
	],
	monthNames: [
		'Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro',
		'Outubro','Novembro','Dezembro'
	],
	monthNamesShort: [
		'Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set',
		'Out','Nov','Dez'
	],
	nextText: 'Próximo',
	prevText: 'Anterior'

});

$('#EmployeeUnityId').change(function(){
	var unity_id = $(this).val();

	if(unity_id == '') {
		$('#EmployeeSectorId').html('<option value="">Selecione uma unidade</option>');
		return false;
	}
	
	$.ajax({
		type: 'POST',
		dataType: 'json',
		data:{unity_id: unity_id},
		url: forUrl('/sectors/get_sectors'),
		success: function(result) {
			var options = "";    		
    		$.each(result, function(key, val) {
    			options += '<option value="' + key + '">' + val + '</option>';
    		});
    		
    		$('#EmployeeSectorId').html(options);
		}
	});
});
</script>