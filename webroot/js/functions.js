$(document).ready(function() {
	
    $('#ItemItemName').autocomplete({
        source: function( request, response ) {
        	
            var url = forUrl('/items/autocomplete');
            noLoading = true;
        	
            $.ajax({
                type: 'POST',
                url: url,
                dataType: "json",
                data: {
                    item_group_id: $('#ItemItemGroupId').val(),
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
        
        var item_group_id = $('#ItemItemGroupId').val();
        var item_class_id = $('#ItemItemClassId').val();
        var item_name = $('#ItemItemName').val();

        $('#items').load(
            url, 
            {
            'item_group_id':item_group_id,
            'item_class_id': item_class_id, 
            'item_name': item_name
            }
        );		
    });       
});

var noLoading = false;

forUrl = function(url) {
    return $('base').attr('href')+url.substr(1);
}

/* Função que carrega script das abas */

