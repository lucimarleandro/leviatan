<?php 
$this->Html->addCrumb('Home', array('controller'=>'items', 'action'=>'home')); 
$this->Html->addCrumb('Itens', array('controller'=>'items', 'action'=>'index'));
$this->Html->addCrumb('Adicionar', array('controller'=>'items', 'action'=>'add')); 

echo $this->Html->link(
    $this->Html->image('back.png'),
    array('controller'=>'items', 'action'=>'index'),
    array('escape'=>false)		
);
?>
<div class="well">
    <?php echo $this->Form->create('Item', array('type'=>'file', 'class'=>'form-horizontal')); ?>
        <fieldset>
            <legend>Adicionar item</legend>
            <div class="control-group required">
                <label class="control-label" for="grupo do item">Grupo</label>
                <div class="controls">
                    <?php 
                    echo $this->Form->input('item_group_id', 
                        array(
                            'label'=>false, 
                            'class'=>'span6',
                            'options'=>$groups,
                            'id'=>'item-group-id'
                        )
                    );
                    ?>
                </div>
            </div>
            <div class="control-group required">
                <label class="control-label" for="Classe do item">Classe</label>
                <div class="controls">
                    <?php 
                    echo $this->Form->input('item_class_id', 
                        array(
                            'label'=>false, 
                            'class'=>'span6',
                            'options'=>array(''=>'Selecione um grupo')
                        )
                    );
                    ?>
                </div>
            </div>
            <div class="control-group required">
                <label class="control-label" for="PNGC">PNGC</label>
                <div class="controls">
                    <?php 
                    echo $this->Form->input('pngc_code_id', 
                        array(
                            'label'=>false, 
                            'class'=>'span6',
                        )
                    );
                    ?>
                </div>
            </div>
            <div class="control-group required">
                    <label class="control-label" for="nome do item">Nome</label>
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
            <div class="control-group required">
                    <label class="control-label" for="nome do item">Descrição</label>
                    <div class="controls">
                            <?php 
                            echo $this->Tinymce->input('Item.description', 
                                    array(
                                        'label'=>false,
                                        'class'=>'span6',
                                        'rows'=>10
                                    ),array(
                                        'language'=>'pt',
                                        'onchange_callback'=>'function(editor) {
                                                tinyMCE.triggerSave();
                                                $("#" + editor.id).valid();
                                        }'
                                    ),
                                    'basic'
                            );
                            ?>
                    </div>
            </div>
            <div class="control-group required">
                <label class="control-label" for="nome do item">Especificação</label>
                <div class="controls">
                    <?php 
                    echo $this->Tinymce->input('Item.specification', 
                        array(
                            'label'=>false,
                            'class'=>'span6',
                            'rows'=>10
                        ),array(
                            'language'=>'pt',
                            'onchange_callback'=>'function(editor) {
                                tinyMCE.triggerSave();
                                $("#" + editor.id).valid();
                            }'
                        ),
                        'basic'
                    );
                    ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="nome do item">Imagem</label>
                <div class="controls">
                    <?php 
                    echo $this->Form->file('image', 
                        array(
                            'label'=>false, 
                        )
                    );
                    ?>
                </div>
            </div>			
            <div class="form-actions">
                <?php echo $this->Form->button('Enviar', array('id'=>'submit-ite','class'=>'btn btn-primary', 'type'=>'submit'));?>
                <?php echo $this->Html->link('Cancelar', array('controller'=>'items', 'action'=>'index'), array('class'=>'btn'));?>
            </div>
        </fieldset>
    <?php echo $this->Form->end(); ?>
</div>
<script>
$('#ItemAddForm').validate({
    ignore: "",
    rules: {
        'data[Item][item_group_id]': {
            required: true
        },
        'data[Item][item_class_id]': {
            required: true
        },
        'data[Item][pngc_code_id]': {
            required: true
        },
        'data[Item][name]': {
            required: true
        },
        'data[Item][description]': {
            required: true
        },
        'data[Item][specification]': {
            required: true
        }
    },
    messages: {
        'data[Item][item_group_id]': {
            required: 'Campo obrigatório'
        },
        'data[Item][item_class_id]': {
            required: 'Campo obrigatório'
        },
        'data[Item][pngc_code_id]': {
            required: 'Campo obrigatório'
        },
        'data[Item][name]': {
            required: 'Campo obrigatório'
        },
        'data[Item][description]': {
            required: 'Campo obrigatório'
        },
        'data[Item][specification]': {
                required: 'Campo obrigatório'			
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

$('#item-group-id').change(function(){
    var item_group_id = $(this).val();
    //Variável usada para dizer se carrega todas as classes ou apenas as cadastradas na tabela de itens
    var complete = $('#ItemComplete').val();

    if(item_group_id == ''){
        $('#ItemItemClassId').html('<option value="">Selecione um grupo</option>');
        return false;
    }

    var url = forUrl('/item_classes/get_item_classes_by_sectors');
    $.ajax({
        type: 'POST',
        dataType: 'JSON',
        data: {'item_group_id':item_group_id, 'complete':complete},
        url:url,
        success: function(result){
            var options = "";    		
            $.each(result, function(key, val) {                
                 if(key == '') {
                    options = '<option value="' + key + '">' + val + '</option>' + options;
                }else {
                    options += '<option value="' + key + '">' + val + '</option>';
                }
            });

            $('#ItemItemClassId').html(options);
        }
    })
});
</script>