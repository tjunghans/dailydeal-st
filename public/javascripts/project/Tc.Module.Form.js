(function ($) {
    "use strict";
    /**
     * Form Terrific Module
     * @author Thomas Junghans
     */
    Tc.Module.Form = Tc.Module.extend({

        init: function ($ctx, sandbox, modId) {
            // call base constructor
            this._super($ctx, sandbox, modId);
        },

        beforeBinding: function (callback) {
            var that = this;

            that.$form = $('form', that.$ctx);

            var submitInProgress = false,
                voucherInputFieldPrefix = 'add',
                voucherInputFieldSuffix = '[]',
                $additionalVoucherInput = null,
                counter = 0;


            var submitHandler = function (e) {
                e.preventDefault();
                var that = this;

                if (submitInProgress === true) {
                    return false;
                } else {
                    submitInProgress = true;
                    $('button[type="submit"]', that.$ctx).addClass('disabled');
                    $('img.ajaxLoader', that.$ctx).addClass('ajaxLoaderProgress');

                    // Reset captcha
                    $('#recaptcha_widget_div').closest('div.control-group').removeClass('error');
                }

                $.ajax({
                    'type' : that.$form.attr('method'),
                    'url' : that.$form.attr('action'),
                    'data' : that.$form.serialize(),
                    'cache' : false,
                    'dataType' : 'json',
                    'success' : function (data) {
                        if (data.responseType === 'error' && data.invalidElements) {
                            for (var i = 0, len = data.invalidElements.length; i < len; i++) {
                                $('input,textarea').filter('[name="' + data.invalidElements[i] + '"]').closest('div.control-group').addClass('error');
                            }
                        } else if (data.responseType === 'error' && data.invalidCaptcha) {
                            $('#recaptcha_widget_div').closest('div.control-group').addClass('error');
                        } else if (data.responseType === 'error') {
                            alert(data.responseText);
                        } else {
                            location.href = '/confirmation.php';
                        }
                    },
                    'complete' : function () {
                        submitInProgress = false;
                        $('button[type="submit"]', that.$ctx).removeClass('disabled');
                        $('img.ajaxLoader', that.$ctx).removeClass('ajaxLoaderProgress');
                    }
                });
            };

            that.$ctx.on('submit', 'form', $.proxy(submitHandler, this));

            that.$ctx.on('keyup', 'div.error input, div.error textarea', function (e) {
  
                var $this = $(this),
                    elemName = $this.attr('name');

                // Ignore the captcha input
                if ($this.is('#recaptcha_response_field')) {
                    return true;
                }

                $.ajax({
                    'type' : that.$form.attr('method'),
                    'url' : that.$form.attr('action'),
                    'data' : 'sendform=false&' + that.$form.serialize(),
                    'cache' : false,
                    'dataType' : 'json',
                    'success' : function (data) {
                        if (data.responseType === 'error' && data.invalidElements) {
                            if ($.inArray(elemName, data.invalidElements) === -1) {
                                $this.closest('div.error').removeClass('error');
                            }
                        } 
                    }
                });

            });



            var buildNewInputId = function (index, attr) {
                var newId = attr + counter;
                $('label', $additionalVoucherInput).attr('for', newId);
                return newId;
            };

            var buildNewInputName = function (index, attr) {
                if (attr.indexOf(voucherInputFieldPrefix) === 0) {
                    return attr;
                } else {
                    return voucherInputFieldPrefix + attr + voucherInputFieldSuffix;
                }
            };


            that.$ctx.on('click', 'button.addVouchernumberInput', function (e) {
                e.preventDefault();

                var $controlGroup = $(this).closest('div.control-group');
                counter = $('div.additionalVoucherInput').length + 1;

                $additionalVoucherInput = $controlGroup.clone().hide().insertAfter($controlGroup).addClass('additionalVoucherInput').fadeIn();
                $additionalVoucherInput.find('label').text('Gutscheinnummer ' + (counter + 1));

                var $newVoucherInputField = $('input:text', $additionalVoucherInput);

                // Update cloned attribute values
                $newVoucherInputField.attr('id', $.proxy(buildNewInputId, this));

                // The name field is an array so brackets are added
                // To distinguish from original voucher input the prefix 'add' is added;
                $newVoucherInputField.attr('name', $.proxy(buildNewInputName, this));

                // Clear the input value
                $newVoucherInputField.val('');

                // Remove original button
                $(this).remove();
            });

            callback();
        }

    });
}(Tc.$));