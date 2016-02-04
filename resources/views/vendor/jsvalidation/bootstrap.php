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

        // Validate date-field inputs
        $(document).on('change', '.date-field', function () {
            dateMonth = $('select[name="date_month"]').val();
            dateYear = $('input[name="date_year"]').val();
            numOfDays = 32 - new Date(dateYear, dateMonth-1, 32).getDate();

            $('input[name="date_day"]').rules('remove');
            $('input[name="date_day"]').rules('add', {
                required: true,
                rangelength: [1, 2],
                max: numOfDays,
                messages: {
                    required: "Day is required.",
                    rangelength: "Day must be 1 or 2 digits.",
                    max: "Day must be between 1 to " + numOfDays + "."
                }
            });
            $('input[name="date_day"]').valid();
        });

        // Validate duration_hour input
        $(document).on('change', 'input[name="duration_hour"]', function () {
            durationHour = $('input[name="duration_hour"]').val();

            $('input[name="duration_minute"]').rules('remove');
            if(durationHour == 0) {
                $('input[name="duration_minute"]').rules('add', {
                    required: true,
                    rangelength: [1, 2],
                    min: 30,
                    max: 59,
                    messages: {
                        required: "Minute is required.",
                        rangelength: "Minute must be 1 or 2 digits.",
                        min: "Minute must be between 30 to 59.",
                        max: "Minute must be between 30 to 59."
                    }
                });
            } else if(durationHour > 0) {
                $('input[name="duration_minute"]').rules('add', {
                    required: true,
                    rangelength: [1, 2],
                    min: 0,
                    max: 59,
                    messages: {
                        required: "Minute is required.",
                        rangelength: "Minute must be 1 or 2 digits.",
                        min: "Minute must be between 0 to 59.",
                        max: "Minute must be between 0 to 59."
                    }
                });
            }
            $('input[name="duration_minute"]').valid();
        });

        // Validate duration_minute input
        $(document).on('change', 'input[name="duration_minute"]', function () {
            durationMinute = $('input[name="duration_minute"]').val();

            $('input[name="duration_hour"]').rules('remove');
            if(durationMinute == 0) {
                $('input[name="duration_hour"]').rules('add', {
                    required: true,
                    rangelength: [1, 2],
                    min: 1,
                    max: 10,
                    messages: {
                        required: "Hour is required.",
                        rangelength: "Minute must be 1 or 2 digits.",
                        min: "Hour must be between 1 to 10.",
                        max: "Hour must be between 1 to 10."
                    }
                });
            } else if(durationMinute > 0) {
                $('input[name="duration_hour"]').rules('add', {
                    required: true,
                    rangelength: [1, 2],
                    min: 0,
                    max: 10,
                    messages: {
                        required: "Hour is required.",
                        rangelength: "Minute must be 1 or 2 digits.",
                        min: "Hour must be between 0 to 10.",
                        max: "Hour must be between 0 to 10."
                    }
                });
            }
            $('input[name="duration_hour"]').valid();
        });
    })
</script>
