<?php 
$this->Html->addCrumb('Gerência', '/manager/');
$this->Html->addCrumb('Permissões', '/manager/permissions');
?>

<?php if(empty($permissions)) {?>
    <h3><?php echo __('Não há módulos');?></h3>
<?php }else {?>
    <div class="box-content">
        <div>
            <table class="table table-bordered table-hover">
                <h4>Habilitar todos</h4>
                <thead>
                    <th>Grupo</th>
                    <th>Habilitar/Desabilitar</th>
                </thead>
                <tbody>
                    <?php foreach($groups as $id=>$group): ?>
                        <tr>
                            <td><?php echo $group; ?></td>
                            <td>
                            <?php
                                echo $this->Form->checkbox('check', array(
                                        'class'=>'change-permission-all-modules',
                                        'value'=>$id,                                        
                                        'checked'=>$checked[$id],
                                        'id'=>$id
                                    )
                                );
                            ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>            
        </div>
        <div>
            <table id="table" class="table table-bordered table-condensed table-hover">
                <thead>
                    <tr>
                        <th><?php echo 'Módulo'; ?></th>
                        <?php foreach($groups as $group):?>
                            <th><?php echo $group; ?></th>
                        <?php endforeach;?>
                    </tr>
                </thead>	
                <tbody>
                        <?php foreach($permissions as $key=>$value):?>
                            <tr>
                                <td><?php echo $key;?></td>
                                <?php foreach($value as $permission):?>
                                    <td>
                                         <?php
                                            echo $this->Form->checkbox('check', array(
                                                    'checked' => ($permission['permission'] == 1),
                                                    'class' => 'change-status group_'.$permission['group_id'],
                                                    'value' => $permission['id'],
                                                    'data-group'=>$permission['group_id']
                                                )
                                            );
                                            ?>
                                    </td> 
                                <?php endforeach; ?>
                            </tr>
                        <? endforeach; ?>
                </tbody>	
            </table>
        </div>
    </div>    
<?php } ?>

<script>
        
    $('.change-status').change(function(){
    
        var permission = 0;
        var id = $(this).val(); 
        var url = forUrl('/manager/changePermission');        
        var element = $(this);
       
        if($(this).is(':checked')) {
            permission = '1'; //módulo ativo
        }
       
        $.ajax({
            type: 'POST',
            dataType: 'JSON',
            data: {id: id, permission:permission},
            url: url,
            success: function(result) {
                if(!result['result']) {
                    alert('Não foi possível alterar o status do item');
                }else {
                    var id = $('#'+element.data('group')).val();
                    var checked = $('input[data-group="'+id+'"]:checked').length;
                    var amount = $('input[data-group="'+id+'"]').length;
                    
                    $('#'+id).attr('checked', checked == amount);
                }
            }           
        });       
    });

    $('.change-permission-all-modules').change(function(){
        
        var permission = 0;
        var group_id = $(this).val();
        var url = forUrl('/manager/changePermissionAllModules');
        
        if($(this).is(':checked')) {
            permission = 1; //módulo ativo
        }
        
        $.ajax({
            type: 'POST',
            dataType: 'JSON',
            data: {group_id: group_id, permission:permission},
            url: url,
            success: function(result) {
                if(!result['result']) {
                    alert('Não foi possível alterar o status do item');
                }else {
                    var value = false;

                    if(permission == 1) {
                        var value = true;
                    }                      
                    
                    $('.group_'+group_id).each(function() {
                        $(this).attr('checked', value);
                    });
                }
            }           
        });
    });
</script>