(function (window, $) {

    // USE STRICT
    "use strict";

    //$('ul#wpsd_donate_amount li:first-child').addClass('active');

    $('ul#wpsd_donate_amount li.amount').click(function () {
        $('ul#wpsd_donate_amount li').removeClass('active')
        $(this).addClass('active');
        var wpsdRadioVal = $(this).data("amount");
        if (wpsdRadioVal !== undefined) {
            $("#wpsd_donate_other_amount").val(wpsdRadioVal);
        }
    });
    //client_p = init_payment();
    var form = document.getElementById('wpsd-donation-form-id');
    var stripe = Stripe(wpsdAdminScriptObj.stripePKey);

    if (form != null) {

        form.addEventListener('submit', function (e) {

            e.preventDefault();
            var wpsdShowCheckout = true;
            var wpsdDonateAmount = 0;

            if ($("#wpsd_donate_other_amount").val() == '') {
                $('#card-errors').show('slow').addClass('error').html('Amount Missing');
                $("#wpsd_donate_other_amount").focus();
                return false;
            }

            if ($("#wpsd_donate_other_amount").val() !== '') {
                wpsdDonateAmount = $("#wpsd_donate_other_amount").val();
            }

            if (($("#wpsd_donation_for").val() == '') || ($("#wpsd_donation_for").val() == null)) {
                $('#card-errors').show('slow').addClass('error').html('Please Enter Donation For');
                $("#wpsd_donation_for").focus();
                return false;
            }

            if ($("#wpsd_donator_name").val() == '') {
                $('#card-errors').show('slow').addClass('error').html('Please Enter Name');
                $("#wpsd_donator_name").focus();
                return false;
            }

            if ($("#wpsd_donator_email").val() == '') {
                $('#card-errors').show('slow').addClass('error').html('Please Enter Email');
                $("#wpsd_donator_email").focus();
                return false;
            }

            if (!wpsd_validate_email($("#wpsd_donator_email").val())) {
                $('#card-errors').show('slow').addClass('error').html('Please Enter Valid Email');
                $("#wpsd_donator_email").focus();
                return false;
            }

            if ($("#wpsd_captcha_content").val() == '') {
                $('#card-errors').show('slow').addClass('error').html('Capcha Missing!');
                $("#wpsd_captcha_content").focus();
                return false;
            }

            if ($("#wpsd_captcha_content").val() != $("#wpsd_captcha_content_check").val()) {
                $('#card-errors').show('slow').addClass('error').html('Wrong Capcha Number!');
                $("#wpsd_captcha_content").focus();
                return false;
            }

            // Address Processing
            var address = [{
                'address_street': $('#wpsd_address_street').val(),
                'address_line2': $('#wpsd_address_line2').val(),
                'address_city': $('#wpsd_address_city').val(),
                'address_state': $('#wpsd_address_state').val(),
                'address_postal': $('#wpsd_address_postal').val(),
                'address_country': $('#wpsd_address_country').val()
            }];
            //var address = $.serialize(address);

            if (wpsdShowCheckout) {

                $("#wpsd-pageloader").fadeIn();

                $.ajax({
                    url: wpsdAdminScriptObj.ajaxurl,
                    type: "POST",
                    dataType: "JSON",
                    cache: false,
                    data: {
                        action: 'wpsd_donation',
                        name: $("#wpsd_donator_name").val(),
                        email: $("#wpsd_donator_email").val(),
                        amount: wpsdDonateAmount,
                        donation_for: $("#wpsd_donation_for").val(),
                        currency: wpsdAdminScriptObj.currency,
                        idempotency: wpsdAdminScriptObj.idempotency,
                        security: wpsdAdminScriptObj.security,
                        //stripeSdk: wpsdAdminScriptObj.stripe_sdk,
                        address: address
                    },
                    success: function (response) {
                        if (response.data.status === 'success') {
                            
                            var options = {
                                clientSecret: response.data.client_secret,
                                appearance: {
                                    theme: 'flat',
                                    variables: {
                                        colorText: '#32325d',
                                        fontFamily: 'Montserrat, sans-serif',
                                    },
                                }
                            };
                            var elements = stripe.elements(options);
                        
                            var card = elements.create('payment');
                            card.on('ready', function(event) {
                                $("#wpsd-pageloader").fadeOut();
                                $("#wpsd-donation-form-id").hide();
                                $("#wpsd-payment").show();
                            });
                            card.mount("#card-element");
                            
                    
                            card.addEventListener('change', ({ error }) => {
                                const displayError = document.getElementById('card-errors');
                                if (error) {
                                    displayError.textContent = error.message;
                                } else {
                                    displayError.textContent = '';
                                }
                            });
                            var r_url = new URL(wpsdAdminScriptObj.successUrl);
                            var pay_btn = document.getElementById('wps_pay_btn');
                            pay_btn.innerHTML += ' ' + wpsdDonateAmount + ' ' + wpsdAdminScriptObj.currency; 
                            pay_btn.addEventListener('click', function() {
                                handle_payment(elements, r_url.href, wpsdDonateAmount, address);
                            }, false);
                            
                            
                        }
                        if (response.data.status === 'error') {
                            $("#wpsd-pageloader").fadeOut();
                            $('#card-errors').show('slow').removeClass('success').addClass(response.data.status).html(response.data.message);
                        }
                    }
                });
            }
        });

    }

    $("#wpsd-donation-form-id input[type='radio']").on("click", function () {

        var wpsdRadioVal = $(this).val();
        if (wpsdRadioVal !== undefined) {
            $("#wpsd_donate_other_amount").val(wpsdRadioVal);
        }

    });

    $('#wpsd_donate_other_amount').on('keyup', function (e) {

        $("#wpsd-donation-form-id input[type='radio']").prop("checked", false);

        if (/^(\d+(\.\d{0,2})?)?$/.test($(this).val())) {
            $(this).data('prevValue', $(this).val());
        } else {
            $(this).val($(this).data('prevValue') || '');
        }
    });

    function wpsd_validate_email($email) {
        var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,6})?$/;
        return emailReg.test($email);
    }

    function afterPaymentSucceeded(result, email, amount, donateFor, name, currency, comments, address) {
        $.ajax({
            url: wpsdAdminScriptObj.ajaxurl,
            type: "POST",
            dataType: "JSON",
            data: {
                action: 'wpsd_donation_success',
                email: email,
                amount: amount,
                donation_for: donateFor,
                name: name,
                currency: currency,
                comments: comments,
                address: address,
                pay_result: result
            },
            success: function (response) {
                if (response.status === 'success') {
                    var url = new URL(wpsdAdminScriptObj.successUrl);
                    url.searchParams.set('donation', 'success');
                    window.location.href = url.href;
                }
                if (response.status === 'error') {
                    $("#wpsd-payment").hide();
                    $("#wpsd-donation-form-id").show();
                    $("#wpsd-pageloader").fadeOut();
                    $('#card-errors').show('slow').removeClass('success').addClass(response.status).html(response.message);
                }
            }
        });
    }

    function handle_payment(elements, return_url, wpsdDonateAmount, address) {
        $("#wpsd-pageloader").fadeIn();
        stripe.confirmPayment(
            {
                elements,
                confirmParams: {
                  return_url: return_url,
                },
                redirect: 'if_required',
            }
        ).then(function(result) {
            if (result.error) {
                $("#wpsd-pageloader").fadeOut();
                $('#card-errors').text(result.error.message);
            } else {
                if (result.paymentIntent.status === 'succeeded') {
                    afterPaymentSucceeded(result, 
                        $("#wpsd_donator_email").val(), 
                        wpsdDonateAmount, 
                        $("#wpsd_donation_for").val(), 
                        $("#wpsd_donator_name").val(), 
                        wpsdAdminScriptObj.currency, 
                        $("#wpsd-comments").val(), 
                        address);
                }
            }
        });
    }

    // searchable dropdown select
    $('div.wpsd-form-item-half-right select#wpsd_address_country').selectize({
        sortField: 'text'
    });

})(window, jQuery);