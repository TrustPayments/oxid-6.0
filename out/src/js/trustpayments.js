(function ($) {
    window.TrustPayments = {
        handler: null,
        methodConfigurationId: null,
        running: false,
        loaded: false,
        initCalls: 0,
        initMaxCalls: 10,

        initialized: function () {
            $('#TrustPayments-iframe-spinner').hide();
            $('#TrustPayments-iframe-container').show();
            $('#button-confirm').removeAttr('disabled');
            $('#button-confirm').click(function (event) {
            	event.preventDefault();
                TrustPayments.handler.validate();
                $('#button-confirm').attr('disabled', 'disabled');
                return false;
            });
            this.loaded = true;
            $('[name=TrustPayments-iframe-loaded').attr('value', 'true');
        },
        
        fallback: function() {
        	$('#TrustPayments-payment-information').toggle();
        	$('#button-confirm').removeAttr('disabled');
        },
        
        heightChanged: function () {
        	if(this.loaded && $('#TrustPayments-iframe-container > iframe').height() == 0) {
        		$('#TrustPayments-iframe-container').parent().parent().hide();
        	}
        },
        
        getAgbParameter: function() {
            var agb = $('#checkAgbTop');
            if(!agb.length) {
                agb = $('#checkAgbBottom');
            }
            if(agb.length && agb[0].checked) {
                return '&ord_agb=1';
            }
            return '';
        },

        submit: function () {
            if (TrustPayments.running) {
                return;
            }
            TrustPayments.running = true;
            var params = '&stoken=' + $('input[name=stoken]').val();
            params += '&sDeliveryAddressMD5=' + $('input[name=sDeliveryAddressMD5]').val();
            params += '&challenge=' + $('input[name=challenge]').val();
            params += this.getAgbParameter(),
            $.getJSON('index.php?cl=order&fnc=truConfirm' + params, '', function (data, status, jqXHR) {
                if (data.status) {
                    TrustPayments.handler.submit();
                }
                else {
                    TrustPayments.addError(data.message);
                    $('#button-confirm').removeAttr('disabled');
                }
                TrustPayments.running = false;
            }).fail((function(jqXHR, textStatus, errorThrown) {
                alert("Something went wrong: " + errorThrown);
            }));
        },

        validated: function (result) {
            if (result.success) {
                TrustPayments.submit();
            } else {
                if (result.errors) {
                    for (var i = 0; i < result.errors.length; i++) {
                        TrustPayments.addError(result.errors[i]);
                    }
                }
                $('#button-confirm').removeAttr('disabled');
            }
        },

        init: function (methodConfigurationId) {
        	this.initCalls++;
            if (typeof window.IframeCheckoutHandler === 'undefined') {
            	if(this.initCalls < this.initMaxCalls) {
	                setTimeout(function () {
	                    TrustPayments.init(methodConfigurationId);
	                }, 500);
            	} else {
            		this.fallback();
            	}
            } else {
                TrustPayments.methodConfigurationId = methodConfigurationId;
                TrustPayments.handler = window
                    .IframeCheckoutHandler(methodConfigurationId);
                TrustPayments.handler.setInitializeCallback(this.initialized);
                TrustPayments.handler.setValidationCallback(this.validated);
                TrustPayments.handler.setHeightChangeCallback(this.heightChanged);
                TrustPayments.handler.create('TrustPayments-iframe-container');
            }
        },

        addError: function (message) {
            $('#content').find('p.alert-danger').remove();
            $('#content').prepend($("<p class='alert alert-danger'>" + message + "</p>"));
            $('html, body').animate({
                scrollTop: $('#content').find('p.alert-danger').offset().top
            }, 200);
        }
    }
})(jQuery);