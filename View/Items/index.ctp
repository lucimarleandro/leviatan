<?php $this->Html->addCrumb('Home', array('controller'=>'items', 'action'=>'home')); ?>
<?php $this->Html->addCrumb('Itens', array('controller'=>'items', 'action'=>'index')); ?>

<?php if(!$ajax) {?>
<div class="box">
    <?php $params = isset($this->request->params['pass'][0]) ? $this->request->params['pass'][0] : 1;?>
    <?php echo $this->Form->input('params', array('type'=>'hidden', 'id'=>'params', 'value'=>$params));?>
    <?php echo $this->element('box_search', array('allItems'=>array('controller'=>'items', 'action'=>'index', $params)));?>
    <?php echo $this->Form->input('url', array('type'=>'hidden', 'id'=>'url', 'value'=>'/items/index/'.$params));?>

    <div id="items">
        <?php echo $this->element('ajax/items/index');?>
    </div>
</div>
<?php }else {
    echo $this->element('ajax/items/index');
}?>

<script>

$('.approve').die('click');
$('.approve').live('click', function() {
    
    var element = $(this);
    var url = forUrl('/items/changeStatus');
    var item_id = element.data('value');
    var status_id = 1;

    $.ajax({
        type: 'POST',
        dataType: 'JSON',
        url: url,
        data: {
            status_id: status_id,
            item_id: item_id
        },
        success: function(result){            
            if(!result) {
                alert('Não foi possível alterar o status do item');
            }else {
                var check = $('<input>').attr('type', 'checkbox').attr('class', 'changeStatus').attr('checked', 'checked').attr('value', item_id); 
                element.parents('tr').children(':first').append(check);     
                element.parents('tr').fadeOut();             
            }
        }
    });
});

$('.changeStatus').die('click');
$('.changeStatus').live('click', function(){
	
    var element = $(this);
    var url = forUrl('/items/changeStatus');
    var item_id = element.val();
    var status_id = '2'; //Item inativo
    var name = 'INATIVO';
    
    if($(this).is(':checked')) {
        status_id = '1'; //Item ativo        
        name = 'ATIVO';
    }
    
    $.ajax({
        type: 'POST',
        dataType: 'JSON',
        url: url,
        data: {
            status_id: status_id,
            item_id: item_id
        },
        success: function(result){
            if(!result['return']) {
                $("#alert-message").addClass('alert alert-error').html(result['message']);
                element.attr('checked', true);
                return;
            }
            if(result['message']) {
                $("#alert-message").addClass('alert alert-info').html(result['message']);
            }
            
            var params = $('#params').val();
            var page = $('#page').val();
            var url = forUrl('/items/index/' + params + '/' + 'page:'+page);
            $.ajax({
                type: 'POST',
                url: url,
                success: function(result) {
                    $('#items').html(result);
                }
            });
        }
    });
});

$('#ItemItemGroupId').change(function(){
    var item_group_id = $(this).val();

    if(item_group_id == ''){
        $('#ItemItemClassId').html('<option value="">Selecione um grupo</option>');
        return false;
    }

    var url = forUrl('/item_classes/get_item_classes_by_sectors/'+true);
    $.ajax({
        type: 'POST',
        dataType: 'JSON',
        data: {'item_group_id':item_group_id},
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