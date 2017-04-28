/*
 * Use it like this:
 * <form class="need_validation">
		<input class="required"/>
		<input class="required" data="{validation:{minlength:5}}" />
		<input data="{validation:{required:true,minlength:5}}" />
		<input class="required digits" />
		<input class="number" />
		<input class="required email" />
	</form>
*/
$(function(){
    (function() {
        var js_element = document.createElement('script');
        js_element.type = 'text/javascript';
        js_element.src = "/media/js/jquery.validate.pack.js";
        (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(js_element);
        $(js_element).load(function(){
            $.metadata.setType('attr','data');
            $('form.need_validation').each(function(i,obj){
                $(obj).before('<div id="validation_form_msg_' + i + '" class="remind remind_error" style="display:none;"></div>').validate({
                    meta:'validation',
                    invalidHandler: function(e, validator) {
                        var errors = validator.numberOfInvalids();
                        if (errors) {
                            var message = 'You missed <strong>'  + errors + (errors == 1
                                ? '</strong> required field. It has'
                                : '</strong>  required fields. They have') + ' been highlighted below.';
                            $("#validation_form_msg_" + i).html(message);
                            $("#validation_form_msg_" + i).show();
                        } else {
                            $("#validation_form_msg" + i).hide();
                        }
                    }
                });
            });
        });
    })(); 
});
