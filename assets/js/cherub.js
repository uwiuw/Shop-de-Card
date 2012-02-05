
var link = "/cherub/index.php/";

// Forgot Password
$(function() {

    var $output = $('<div class="output"></div>').dialog({
        title: 'Mail Sent',
        autoOpen: false
    });


    $( "#dialog-confirm" ).dialog({
        resizable: false,
        autoOpen: false,
        height:220,
        modal: true,
        buttons: {
            "Delete": function() {

               
                var delete_link = $('input[name=id_delete]').val();
                var data = $(":checkbox:checked").map(function(i,n)
                {
                    return $(n).val();
                }).get();
                $.post(delete_link,{
                    'deleteCB[]': data
                },
                function(data){
                    $(".status_box").html(data);
                });
                $(":checked").each(function() {
                    $(this).parent().parent().remove()
                });
                $( this ).dialog( "close" );
            },
            Cancel: function() {
                $( this ).dialog( "close" );
            }
        }
    });

    $( "#forget_pass" ).dialog({
        autoOpen: false,
        height: 300,
        width: 350,
        modal: true,
        buttons: {
            "Send": function() {
                var bValid = true;
                $.post(link + "webshop/forgot_pass",{
                    email_req:$('#email_req').val()
                },
                function(data){
                    //alert(data);
                    $( "#forget_pass" ).dialog( "close" );
                    $output.dialog( "open" ).html(data);
                });
                return false;

            },
            Cancel: function() {
                $( this ).dialog( "close" );
            }
        }
    });

    $('.tablesorter tr')
    .filter(':has(:checkbox:checked)')
    .addClass('selected')
    .end()
    .click(function(event) {
        if (event.target.type !== 'checkbox') {
            $(':checkbox', this).trigger('click');
        }
    })
    .find(':checkbox')
    .click(function(event) {
        $(this).parents('tr:first').toggleClass('selected');
    });

    $("#selectAll").click(function()
    {
        var checked_status = this.checked;
        $('input[name="deleteCB[]"]').each(function()
        {
            this.checked = checked_status;
        });
    });
    
    $(".del_selected").click(function(){
        //alert($(this).attr("href"));
        $('input[name=id_delete]').val($(this).attr("href"));
        $( "#dialog-confirm" ).dialog("open");
        return false;
    });
});
function removeRow(trId){
    $('#' + trId).remove();
}
// Close dialog on buy
function closeDialog(){
    $('.popup').dialog('close');
}
$(document).ready(function() {
    /*place jQuery actions here*/

    var $dialog = $('<div class="popup"></div>').dialog({
        title: 'Item Added to Cart',
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

    // Forgot Password Popup

    $(".forgot_pass").click(function() {
        $( "#forgot_pass" ).dialog('open');
    });


    $('#thumbnails').simplethumbs({
        slideshow: '#imageview'
    });
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
                var link_cart = '<a href="'+link+'webshop/cart">Go To Cart <img src="/cherub/assets/images/smallcart.png" /></a>'
                $.get(link + "webshop/total", function(total_cart){
                    $(".total_price").text('$ '+total_cart);
                    $dialog.dialog('open').html(link_cart+' <br /><br /><div class="shopping_close"><a href="javascript:void(0)" onclick="closeDialog();">Keep Shopping</a></div>');
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




    (function($){
        $.fn.extend({
            limit: function(limit,element) {

                var interval, f;
                var self = $(this);

                $(this).focus(function(){
                    interval = window.setInterval(substring,100);
                });

                $(this).blur(function(){
                    clearInterval(interval);
                    substring();
                });

                substringFunction = "function substring(){ var val = $(self).val();var length = val.length;if(length > limit){$(self).val($(self).val().substring(0,limit));}";
                if(typeof element != 'undefined')
                    substringFunction += "if($(element).html() != limit-length){$(element).html((limit-length<=0)?'0':limit-length);}"

                substringFunction += "}";

                eval(substringFunction);



                substring();

            }
        });
    })(jQuery);
    

    $('.sign_up').each(function()
    {
        this.data = new Object(); //TODO don't overwrite previous data
        this.data.value = this.value;

        $(this).focus(function(){
            if (this.value == this.data.value)
                this.value = '';
        });
        $(this).blur(function(){
            if (this.value == '')
                this.value = this.data.value;
        });
    });

    $('#shortdesc').limit('140','#charsLeft');
});


