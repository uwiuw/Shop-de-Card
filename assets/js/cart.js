$(document).ready(function() { 
    /*place jQuery actions here*/
    var link = "/cherub/index.php/";
    var $dialog = $('<div></div>').dialog({
        title: 'Thank you',
        autoOpen: false
    });

    // to delete item shopping cart
    $(".del_item").click(function(){
        var id = $(this).find('input[name=rowid\\[\\]]').val();
        var prod_id = $(this).find('input[name=id]').val();
        $.post(link + "webshop/delete_item",{
            rowid:id,
            ajax: '1'
        },
        function(data){
            //alert(data);
            if(data == 'true'){
                $("#item-"+prod_id).remove();
                $.get(link + "webshop/total", function(total_cart){
                    $("#total_cart").replaceWith(total_cart);
                });
            }else{
                alert("Product does not exist");
            }
        });
        return false;
    });
    // Update total shopping cart

    

    // buy / add to shopping cart
    $(".product_buy").click(function() {
        // Get the product ID and the quantity
        var id = $(this).find('input[name=product_id]').val();
        var qty = $(this).find('input[name=quantity]').val();
        $.post(link + "webshop/add_cart_item/", {
            product_id: id,
            quantity: qty,
            ajax: '1'
        },
        function(data){
            
            if(data == 'true'){
                var link_cart = '<a href="'+link+'webshop/cart">Here</a>'
                $.get(link + "webshop/total", function(total_cart){
                    $(".total_price").text('$ '+total_cart);
                    $dialog.dialog('open').html('You buy this item and your total cart is<div class="price"> $'+total_cart+'</div> \n\
                    You Can check your shopping cart '+link_cart);
                });
            }else{
                alert("Product does not exist");
            }
    		
        });

        return false;
    });
	
    // to update shopping cart without reload page
    function jsUpdateCart(){
        var parameter_string = '';
        allNodes = $(".process");
        for(i = 0; i < allNodes.length; i++) {
            var tempid = allNodes[i].id;
            var temp = new Array;
            temp = tempid.split("_");
            var real_id = temp[2];
            var real_value = allNodes[i].value;
            parameter_string += real_id +':'+real_value+',';
        }

        var params = 'ids='+parameter_string;

        $.ajax({
            type: "POST",
            url: "index.php/webshop/ajax_cart",
            data: params,
            success: function( r ) {
                $('#ajax_msg').html( r );
                location.reload( true );
            }
        });
  
    }
    // to empty the shopping cart
    $(".empty").live("click", function(){
        $.get(link + "webshop/empty_cart", function(){
            $.get(link + "webshop/show_cart", function(cart){
                $("#cart_content").html(cart);
            });
        });
		
        return false;
    });


	
	
});
