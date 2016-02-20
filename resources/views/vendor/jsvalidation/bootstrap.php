<script>
    jQuery(document).ready(function(){

        $("<?php echo $validator['selector']; ?>").validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block error-help-block', // default input error message class
            ignore: ':hidden:not([class~=selectized]),:hidden > .selectized, .selectize-control .selectize-input input',

            errorPlacement: function(error, element) {
                if(element.parents('div.has-error').length) {
                    if (element.parents('div.btn-group').length || element.hasClass("selectized")) {
                        element.parents('div.has-error').append(error);
                    } else if (element.parent('.input-group').length ||
                        element.prop('type') === 'checkbox' || element.prop('type') === 'radio') {
                        error.insertAfter(element.parent());
                        // else just place the validation message immediately after the input
                    } else {
                        error.insertAfter(element);
                    }
                } else if(element.parents('td.has-error').length) {
                    error.insertAfter(element);
                }
            },
            highlight: function(element) { // highlight error inputs
                if($(element).parents('div.inline-field').length) {
                    $(element).parent('div').removeClass('has-success').addClass('has-error');
                } else if($(element).parents('.fixed-table-body').length) {
                    $(element).parent('td').removeClass('has-success').addClass('has-error');
                } else {
                    $(element).closest('.form-group').removeClass('has-success').addClass('has-error'); // add the Bootstrap error class to the control group
                }
            },

            <?php if (isset($validator['ignore']) && is_string($validator['ignore'])): ?>

            ignore: "<?php echo $validator['ignore']; ?>",
            <?php endif; ?>


            // Uncomment this to mark as validated non required fields
             unhighlight: function(element) { // revert the change done by highlight
                 if($(element).parents('div.inline-field').length) {
                     $(element).parent('div').removeClass('has-error').addClass('has-success');
                 } else if($(element).parents('.fixed-table-body').length) {
                     $(element).parent('td').removeClass('has-error').addClass('has-success');
                 } else {
                     $(element).closest('.form-group').removeClass('has-error').addClass('has-success');
                 }
             },

            success: function(element) {
                if($(element).parents('div.inline-field').length) {
                    $(element).parent('div').removeClass('has-error').addClass('has-success');
                } else if($(element).parents('.fixed-table-body').length) {
                    $(element).parent('td').removeClass('has-error').addClass('has-success');
                } else {
                    $(element).closest('.form-group').removeClass('has-error').addClass('has-success'); // remove the Boostrap error class from the control group
                }
            },

            focusInvalid: false, // do not focus the last invalid input
            <?php if (Config::get('jsvalidation.focus_on_error')): ?>
            invalidHandler: function(form, validator) {

                if (!validator.numberOfInvalids())
                    return;

                $('html, body').animate({
                    scrollTop: $(validator.errorList[0].element).offset().top
                }, <?php echo Config::get('jsvalidation.duration_animate') ?>);
                $(validator.errorList[0].element).focus();

            },
            <?php endif; ?>

            <?php
            // Quick hack to validation rules for inputs that takes in array
            if(isset($validator['rules']['centres'])) {
                $validator['rules']['centres[]'] = $validator['rules']['centres'];
                unset($validator['rules']['centres']);
            }
            if(isset($validator['rules']['languages'])) {
                $validator['rules']['languages[]'] = $validator['rules']['languages'];
                unset($validator['rules']['languages']);
            }
            ?>

            rules: <?php echo json_encode($validator['rules']); ?>
        });

        // Validate selectize.js inputs
        $(document).on('change', '.selectized', function () {
            $(this).valid();
        });

        // Validate .btn-group radio boxes
        $(document).on('change', '.btn-group .btn input', function () {
            $(this).valid();
        });

        // Sets a custom email pattern for the built-in email validation rule.
        $.validator.methods.email = function( value, element ) {
            return this.optional( element ) || /^([a-zA-Z0-9_.+-])+@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,6})+$/.test( value );
        }
    })
</script>
