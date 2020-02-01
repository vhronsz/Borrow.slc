
(function ($) {
    "use strict";


    /*==================================================================
    [ Focus Contact2 ]*/
    $('.input3').each(function(){
        $(this).on('blur', function(){
            if($(this).val().trim() != "") {
                $(this).addClass('has-val');
            }
            else {
                $(this).removeClass('has-val');
            }
        })    
    })
            

    /*==================================================================
    [ Chose Radio ]*/
    $("#radio2").on('change', function(){
        if ($(this).is(":checked")) {
            $('.input3-select').slideUp(300);
        }
    });

    $("#radio1").on('change', function(){
        if ($(this).is(":checked")) {
            $('.input3-select').slideDown(300);
        }
    });
    
    /*==================================================================
    [ Validate ]*/
    var name = $('.validate-input input[name="name"]');
    var email = $('.validate-input input[name="email"]');
    var message = $('.validate-input textarea[name="message"]');
    var phone = $('.validate-input input[name="phone"]');
    var itemTemp = $('.validate-input input[name="itemTemp"]');
    var startDate = $('.validate-input input[id="startDate"]');
    var endDate = $('.validate-input input[id="endDate"]');
    var today = new Date();
    var dd = String(today.getDate()).padStart(2, '0');
    var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
    var yyyy = today.getFullYear();
    today = yyyy + '-' + mm + '-' + dd;
    $('.validate-form').on('submit',function(){
        var check = true;

        if($(startDate).val() < today ){
            showValidate(startDate);
            check=false;
        }

        if($(endDate).val() < $(startDate).val() ){
            showValidate(endDate);
            check=false;
        }

        if($(itemTemp).val().trim() == 'Barang' || $(itemTemp).val().trim() == ''){
            showValidate(itemTemp);
            check=false;
        }

        if($(itemTemp).val().trim() == 'Barang' || $(itemTemp).val().trim() == ''){
            showValidate(itemTemp);
            check=false;
        }

        if($(name).val().trim() == ''){
            showValidate(name);
            check=false;
        }

        if($(phone).val().trim() == ''){
            showValidate(phone);
            check=false;
        }

        if($(email).val().trim().match(/^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{1,5}|[0-9]{1,3})(\]?)$/) == null) {
            showValidate(email);
            check=false;
        }

        if($(message).val().trim() == ''){
            showValidate(message);
            check=false;
        }

        return check;
    });

    var itemId = $('.validate-input input[name="itemId"]');
    var itemName = $('.validate-input input[name="itemName"]');
    var itemDescription = $('.validate-input textarea[name="itemDescription"]');
    $('.insert-validate-form').on('submit',function(){
        var check = true;

        if($(itemId).val().trim() == ''){
            showValidate(itemId);
            check=false;
        }

        if($(itemName).val().trim() == ''){
            showValidate(itemName);
            check=false;
        }

        if($(itemDescription).val().trim() == ''){
            showValidate(itemDescription);
            check=false;
        }

        return check;
    });

    var itemId = $('.validate-input input[name="itemId"]');
    var itemName = $('.validate-input input[name="itemName"]');
    var itemDescription = $('.validate-input textarea[name="itemDescription"]');
    var itemTemp = $('.validate-input input[name="itemTemp"]');
    $('.update-validate-form').on('submit',function(){
        var check = true;

        if($(itemTemp).val().trim() == 'Barang' || $(itemTemp).val().trim() == ''){
            showValidate(itemTemp);
            check=false;
        }

        if($(itemId).val().trim() == ''){
            showValidate(itemId);
            check=false;
        }

        if($(itemName).val().trim() == ''){
            showValidate(itemName);
            check=false;
        }

        if($(itemDescription).val().trim() == ''){
            showValidate(itemDescription);
            check=false;
        }

        return check;
    });

    var itemTemp = $('.validate-input input[name="itemTemp"]');
    $('.delete-validate-form').on('submit',function(){
        var check = true;

        if($(itemTemp).val().trim() == 'Barang' || $(itemTemp).val().trim() == ''){
            showValidate(itemTemp);
            check=false;
        }

        return check;
    });

    $('.validate-form .input3').each(function(){
        $(this).focus(function(){
           hideValidate(this);
       });
    });

    function showValidate(input) {
        var thisAlert = $(input).parent();

        $(thisAlert).addClass('alert-validate');
    }

    function hideValidate(input) {
        var thisAlert = $(input).parent();

        $(thisAlert).removeClass('alert-validate');
    }

})(jQuery);