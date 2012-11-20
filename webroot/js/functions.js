$(document).ready(function() {
	
	$('#ItemItemGroupId').change(function(){
		var item_group_id = $(this).val();
		//Variável usada para dizer se carrega todas as classes ou apenas as cadastradas na tabela de itens
		var complete = $('#ItemComplete').val();
		
		if(item_group_id == ''){
			$('#ItemItemClassId').html('<option value="">Selecione um grupo</option>');
			return false;
		}
		
		var url = forUrl('/item_classes/get_item_classes');
		$.ajax({
			type: 'POST',
			dataType: 'JSON',
		    data: {'item_group_id':item_group_id, 'complete':complete},
		    url:url,
		    success: function(result){
		    	var options = "";    		
	    		$.each(result, function(key, val) {
	    			options += '<option value="' + key + '">' + val + '</option>';
	    		});
	    		
	    		$('#ItemItemClassId').html(options);
		    }
		})
	});
	
	$('#ItemItemName').autocomplete({
        source: function( request, response ) {
        	
        	var url = forUrl('/items/autocomplete');
        	noLoading = true;
        	
            $.ajax({
            	type: 'POST',
                url: url,
                dataType: "json",
                data: {
                    item_class_id: $('#ItemItemClassId').val(),
                    item_name: request.term
                },
                success: function(data) {
                	response(data);
                }
            });
        },
        minLength: 2
    });
	
	$('#filter-items').click(function(){	
		
		var action = $('#url').val();
		var url = forUrl(action);
		
		var item_class_id = $('#ItemItemClassId').val();
		var item_name = $('#ItemItemName').val();
		
		$('#items').load(
			url, 
			{'item_class_id': item_class_id, 'item_name': item_name}
		);		
	});
	
});

var noLoading = false;

forUrl = function(url) {
    return $('base').attr('href')+url.substr(1);
}