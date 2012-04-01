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

            var submitButtonHandler = function (e) {
                e.preventDefault();

                var that = this;

                $.ajax({
                    'type' : that.$form.attr('method'),
                    'url' : that.$form.attr('action'),
                    'data' : that.$form.serialize(),
                    'cache' : false,
                    'dataType' : 'json',
                    'success' : function (data) {
                        
                        if (data.responseType === 'error') {
                            for (var i = 0, len = data.invalidElements.length; i < len; i++) {
                                $('input,select,textarea').filter('[name="' + data.invalidElements[i] + '"]').closest('div.control-group').addClass('error');
                            }
                        } else {
                            location.href = '/confirmation.php';
                        }
                    }
                });
                
            };

            var submitHandler = function (e) {
                e.preventDefault();
            };

            that.$ctx.on('submit', 'form', submitHandler, this);
            that.$ctx.on('click', 'button[type="submit"]', $.proxy(submitButtonHandler, this));

            callback();
        }

    });
}(Tc.$));