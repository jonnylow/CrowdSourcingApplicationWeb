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
                }
            },
            highlight: function(element) { // highlight error inputs
                $(element).closest('.form-group').removeClass('has-success').addClass('has-error'); // add the Bootstrap error class to the control group
            },

            <?php if (isset($validator['ignore']) && is_string($validator['ignore'])): ?>

            ignore: "<?php echo $validator['ignore']; ?>",
            <?php endif; ?>


            // Uncomment this to mark as validated non required fields
             unhighlight: function(element) { // revert the change done by highlight
             $(element).closest('.form-group').removeClass('has-error').addClass('has-success');
             },

            success: function(element) {
                $(element).closest('.form-group').removeClass('has-error').addClass('has-success'); // remove the Boostrap error class from the control group
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

            // Quick hack for validation rules required for inputs that
            <?php
            if(isset($validator['rules']['languages'])) {
                $validator['rules']['languages[]'] = $validator['rules']['languages'];
                unset($validator['rules']['languages']);
            }
            ?>

            rules: <?php echo json_encode($validator['rules']); ?>
        });

        // Validate selectize.js input
        $(document).on('change', '.selectized', function () {
            $(this).valid();
        });

        // Validate button-grouped radio boxes
        $(document).on('change', '.btn-group .btn input', function () {
            $(this).valid();
        });
    })
</script>
