<?php 
$this->Html->addCrumb('Home', array('controller'=>'items', 'action'=>'home'));
$this->Html->addCrumb('Solicitações', array('controller'=>'solicitations', 'action'=>'index'));
$this->Html->addCrumb('Finalizar', array('controller'=>'cart_items', 'action'=>'index'));
?>
<div id="content-cart-item">
    <?php if(empty($items)) {?>
        <h3><?php echo __('Não há Itens');?></h3>
    <?php }else {?>
        <?php if(!$ajax) {?>
            <ul class="nav nav-tabs" id="myTab">
                    <li class="active"><a title="Descrição da solicitação" href="#text"><?php echo __('Descrição')?></a></li>
                    <li><a title="Itens da solicitação" href="#items"><?php echo __('Itens')?></a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active well" id="text">	
                    <div id="validation"></div>
                    <?php echo $this->Form->create('Solicitation', array('class'=>'form-horizontal')); ?>
                        <fieldset>
                            <div class="control-group required">
                                <label class="control-label" for="grupo do item">Nº do memorando</label>
                                <div class="controls">
                                    <?php 
                                    echo $this->Form->input('memo_number', 
                                        array(
                                            'label'=>false, 
                                            'class'=>'input-mini',
                                            'value'=>isset($temp['SolicitationTemporary']['memo_number']) ? $temp['SolicitationTemporary']['memo_number'] : ''
                                        )
                                    );
                                    ?>
                                </div>
                            </div>
                            <div class="control-group required">
                                <label class="control-label" for="Descrição da memorando">Descrição</label>
                                    <div class="controls">
                                        <?php 
                                        echo $this->Tinymce->input('Solicitation.description', 
                                            array(
                                                'label'=>false,
                                                'class'=>'span6',
                                                'rows'=>10,
                                                'value'=>isset($temp['SolicitationTemporary']['description']) ? $temp['SolicitationTemporary']['description'] : ''
                                            ),array(
                                                'language'=>'pt',
                                                'onchange_callback'=>'changeContent'
                                            ),
                                            'basic'
                                        );
                                        ?>
                                    </div>
                                </div>
                                <div class="control-group">
                                <label class="control-label" for="Anexo do memorando">Anexo</label>
                                    <div class="controls">
                                        <?php 
                                        echo $this->Tinymce->input('Solicitation.attachment', 
                                            array(
                                                'label'=>false,
                                                'class'=>'span6',
                                                'rows'=>10,
                                                'value'=>isset($temp['SolicitationTemporary']['attachment']) ? $temp['SolicitationTemporary']['attachment'] : ''
                                            ),array(
                                                'language'=>'pt',
                                                'onchange_callback'=>'changeContent'
                                            ),
                                            'basic'
                                        );
                                        ?>
                                    </div>
                                </div>
                            </fieldset>
                        <?php echo $this->Form->end();?>
                    </div>
                    <div class="tab-pane" id="items">
                        <?php echo $this->element('ajax/cart_items/index');?>
                    </div>		
                </div>
        <?php }else {	
            echo $this->element('ajax/cart_items/index');
        }
    }?>
</div>

<script>
    function changeContent(editor) {
        tinyMCE.triggerSave();
        $("#" + editor.id).valid();
        
        noLoading = true;
        var id = editor.id; 
        var url = forUrl('/solicitation_temporaries/add');
        var data = editor.getContent();
        var field = id.replace('Solicitation', '').toLowerCase();
        
        $.ajax({
            type: "POST",
            dataType: "JSON",
            data: {value:data, field:field},
            url: url,
            success: function(result) {                
                if(!result) {
                    $('#alert-message').html('<div id="flashMessage" class="alert alert-error">Não foi possível armazenar o conteúdo.</div>');
                }
            }
        });
    }
    //
    $('#SolicitationMemoNumber').change(function(e){
         
         noLoading = true;
         var url = forUrl('/solicitation_temporaries/add');
         var field = 'memo_number';
         var data = $(this).val();

         $.ajax({
            type: "POST",
            dataType: "JSON",
            data: {value:data, field:field},
            url: url,
            success: function(result) {
                if(!result) {
                    $('#alert-message').html('<div id="flashMessage" class="alert alert-error">Não foi possível armazenar o conteúdo.</div>');
                }
            }
        });         
    });
    
    //
    $('#SolicitationDescription').change(function(e){
        e.preventDefault();
        alert(tinyMCE.activeEditor.getContent());
    });
    
    //
    $('#myTab a').click(function (e) {
        e.preventDefault();
        $(this).tab('show');
    });
    
    //
    $('#SolicitationIndexForm').validate({
        ignore: "",
        rules: {
            'data[Solicitation][memo_number]': {
                required: true
            },
            'data[Solicitation][description]': {
                required: true
            }
        },
        messages: {
            'data[Solicitation][memo_number]': {
                required: 'Campo obrigatório'
            },
            'data[Solicitation][description]': {
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
</script>