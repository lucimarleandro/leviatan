<?php 
$this->Html->addCrumb('Gerência', '/manager/');
$this->Html->addCrumb('Unidade', '/unities/');
$this->Html->addCrumb('Editar', '/unities/edit/'.$this->request->data['Unity']['id']);

echo $this->Html->link(
	$this->Html->image('back'),
	array('controller'=>'unities', 'action'=>'index'),
	array('escape'=>false)		
);
?>

<div class="well">
	<?php echo $this->Form->create('Unity', array('class'=>'form-horizontal')); ?>
		<fieldset>
			<legend>Adicionar Unidade</legend>
			<div class="control-group required">
				<label class="control-label" for="Número do CNES">CNES</label>
				<div class="controls">
					<?php 
					echo $this->Form->input('cnes', 
						array(
							'label'=>false, 
							'class'=>'input',
						)
					);
					?>
				</div>
			</div>
			<div class="control-group required">
				<label class="control-label" for="Número do CNPJ">CNPJ</label>
				<div class="controls">
					<?php 
					echo $this->Form->input('cnpj', 
						array(
							'label'=>false, 
							'class'=>'input',
						)
					);
					?>
				</div>
			</div>			
			<div class="control-group required">
				<label class="control-label" for="Nome da unidade">Nome</label>
				<div class="controls">
					<?php 
					echo $this->Form->input('name', 
						array(
							'label'=>false, 
							'class'=>'span6',
						)
					);
					?>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="Nome fantasia">Nome fantasia</label>
				<div class="controls">
					<?php 
					echo $this->Form->input('trade_name', 
						array(
							'label'=>false, 
							'class'=>'span6',
						)
					);
					?>
				</div>
			</div>
			<div class="control-group required">
				<label class="control-label" for="Númedo do CEP">CEP</label>
				<div class="controls">
					<?php 
					echo $this->Form->input('cep', 
						array(
							'label'=>false, 
							'class'=>'input-small',
							'maxlength'=>8,
                            'value'=>$location['Address']['postal_code']
						)
					);
					echo $this->Form->button('pesquisar', array('type'=>'button', 'id'=>'search-cep'));
					?>
				</div>
			</div>
			<?php echo $this->Form->input('cod_response', array('type'=>'hidden', 'value'=>3));?>
			<?php echo $this->Form->input('state_hidden', array('type'=>'hidden', 'value'=>$location['State']['uf']));?>
			<div class="control-group required">
				<label class="control-label" for="Estado">Estado</label>
				<div class="controls">
					<?php 
					echo $this->Form->input('state', 
						array(
							'label'=>false, 
							'disabled'=>'disabled',
							'options'=>$states,
                            'value'=>$location['State']['uf']
						)
					);
					?>
				</div>
			</div>
			<div class="control-group required">
				<label class="control-label" for="Cidade">Cidade</label>
				<div class="controls">
					<?php 
					echo $this->Form->input('city', 
						array(
							'label'=>false, 
							'readonly'=>true,
                            'value'=>$location['City']['name']
						)
					);
					?>
				</div>
			</div>
			<div class="control-group required">
				<label class="control-label" for="Bairro">Bairro</label>
				<div class="controls">
					<?php 
					echo $this->Form->input('district', 
						array(
							'label'=>false, 
							'readonly'=>true,
                            'value'=>$location['District']['name']
						)
					);
					?>
				</div>
			</div>
			<div class="control-group required">
				<label class="control-label" for="Cidade">Endereço</label>
				<div class="controls">
					<?php 
					echo $this->Form->input('address', 
						array(
							'label'=>false, 
							'readonly'=>true,
							'class'=>'span6',
                            'value'=>$location['Address']['name']
						)
					);
					?>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="Número do unidade">Número</label>
				<div class="controls">
					<?php 
					echo $this->Form->input('number', 
						array(
							'label'=>false, 
							'class'=>'input-mini',
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
				<label class="control-label" for="FAX">Fax</label>
				<div class="controls">
					<?php 
					echo $this->Form->input('fax', 
						array(
							'label'=>false, 
							'class'=>'input',
						)
					);
					?>
				</div>
			</div>
			<div class="control-group required">
				<label class="control-label" for="Distrito sanitário">Distritio sanitário</label>
				<div class="controls">
					<?php 
					echo $this->Form->input('health_district_id', 
						array(
							'label'=>false, 
							'class'=>'input',
						)
					);
					?>
				</div>
			</div>
			<div class="control-group required">
				<label class="control-label" for="Tipo da unidade">Tipo da unidade</label>
				<div class="controls">
					<?php 
					echo $this->Form->input('unity_type_id', 
						array(
							'label'=>false, 
							'class'=>'input',
						)
					);
					?>
				</div>
			<div class="form-actions">
				<?php echo $this->Form->button('Enviar', array('class'=>'btn btn-primary', 'type'=>'submit'));?>
      			<?php echo $this->Html->link('Cancelar', array('controller'=>'unities', 'action'=>'index'), array('class'=>'btn'));?>
    		</div>
		</fieldset>
	<?php echo $this->Form->end(); ?>
</div>
<script>
$('#UnityPhone').mask('(99)9999-9999', {placeholder:" "}); //telefone
//-----------------
//Ajax verificação do CEP
$('#search-cep').click(function(e){
	e.preventDefault();

	if($('#UnityCep').val() < 8) {
		return false;
	}
	
	$('#UnityState').val('').attr('disabled', 'disabled');
	$('#UnityCity').attr('readonly', true).attr('value', '');
	$('#UnityDistrict').attr('readonly', true).attr('value', '');
	$('#UnityAddress').attr('readonly', true).attr('value', '');
	
	var cep = $("#UnityCep").val();
	quantity = cep.length;
	
	if(quantity == 8) {
		
		var url = forUrl('/unities/search_cep');

		$.ajax({
			type: 'POST',
			dataType: 'json',
			url: url,
			data: {'cep':cep},				
			success: function(result) {		
				$('#UnityCodResponse').val(result.response);
				if(result.response == 0) {						
					$('#UnityState').removeAttr('disabled');
					$('#UnityCity').attr('readonly', false);
					$('#UnityDistrict').attr('readonly', false);
					$('#UnityAddress').attr('readonly', false);
				}else {					
					$('#UnityStateHidden').val(result.state);
					$('#UnityState').val(result.state);
					$('#UnityCity').val(result.city);
					
					if(result.response == 1 || result.response == 3) {
						$('#UnityDistrict').val(result.district);
						$('#UnityAddress').val(result.address);
					}else if(result.response == 2) {
						$('#UnityDistrict').val(result.district);
						$('#UnityAddress').attr('readonly', false);
					}
											
				}
			}
		});			
	}
});

$('#UnityEditForm').validate({
	ignore: "",
	rules: {
		'data[Unity][cnes]': {
		    required: true
		},
		'data[Unity][cnpj]': {
		    required: true
		},
		'data[Unity][name]': {
		    required: true
		},
		'data[Unity][cep]': {
		    required: true
		},
		'data[Unity][state]': {
		    required: true
		},
		'data[Unity][city]': {
		    required: true
		},
		'data[Unity][district]': {
		    required: true
		},
		'data[Unity][address]': {
		    required: true
		},
		'data[Unity][phone]': {
		    required: true
		},
		'data[Unity][health_district_id]': {
		    required: true
		},
		'data[Unity][unity_type_id]': {
		    required: true
		}
	},
	messages: {
		'data[Unity][cnes]': {
		    required: "Campo obrigatório"
		},
		'data[Unity][cnpj]': {
		    required: "Campo obrigatório"
		},
		'data[Unity][name]': {
		    required: "Campo obrigatório"
		},
		'data[Unity][cep]': {
		    required: "Campo obrigatório"
		},
		'data[Unity][state]': {
		    required: "Campo obrigatório"
		},
		'data[Unity][city]': {
		    required: "Campo obrigatório"
		},
		'data[Unity][district]': {
		    required: "Campo obrigatório"
		},
		'data[Unity][address]': {
		    required: "Campo obrigatório"
		},
		'data[Unity][phone]': {
		    required: "Campo obrigatório"
		},
		'data[Unity][health_district_id]': {
		    required: "Campo obrigatório"
		},
		'data[Unity][unity_type_id]': {
		    required: "Campo obrigatório"
		}
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
</script>