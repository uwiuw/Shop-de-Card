$(document).ready(function() {
    // use this to reset a single form
    $(".alert").click(function() {
        alert('test');
    });

    $("#searchform").submit(function() {
        alert('test');
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