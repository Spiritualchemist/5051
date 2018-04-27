$(document).ready(function () {
    var $ = jQuery.noConflict();
    ///code to show popup to get auto populate the event details
$(".viewEvent").live("click", function () {
    $.fancybox.resize();
    var self = $(this);
    var intEventId = self.closest("a").attr("id");
    var url = base_url + 'client/viewEventDetails';
    $.ajax({
        type: 'POST',
        url: url,
        data: {"intEventId": intEventId},
        dataType: "json",
        cache: false,
        success: function (responseData) {
            $.fancybox(responseData.html, {
                'width': 800,
                'height': 250,
                'overlayOpacity': '0.4',
                'overlayColor': '#000',
                'hideOnContentClick': false,
                'autoScale': false,
                'modal': false,
                'transitionIn': 'elastic',
                'transitionOut': 'elastic'
            });
        }, error: function (error) {
            console.log(error);
        }
    });
    // $('#fancybox-content').css('border-color','#6F2911');
});

///code to show popup to getautopopulate the payment details
$(".get-payment").live("click", function () {
    $.fancybox.resize();
    var self = $(this);
    var i_track = self.attr("rel");
    var s_type = self.attr("type");
    var url = base_url + 'album/get_payment_details';
    $.ajax({
        type: 'POST',
        url: url,
        data: {"i_track_id": i_track,"s_type": s_type},
        dataType: "json",
        cache: false,
        success: function (a_response) {
            $.fancybox(a_response.s_html, {
                'width': 800,
                'height': 250,
                'overlayOpacity': '0.4',
                'overlayColor': '#000',
                'hideOnContentClick': false,
                'autoScale': false,
                'modal': false,
                'transitionIn': 'elastic',
                'transitionOut': 'elastic',
                'showCloseButton': false,
                'enableEscapeButton': false,
                'hideOnOverlayClick': false
            });
        }, error: function (error) {
            console.log(error);
        }
    });
    $('#fancybox-content').css('border-color', '#6F2911');
});

$("#btnSubmit").live("click", function () {
    var i_track = $('form[name=frm_payment]').find('input[name=i_track_id]').val();
    var url = base_url + 'album/payment_process';
    $.ajax({
        type: 'GET',
        url: url,
        data: $('form[name=frm_payment]').serializeArray(),
        dataType: "json",
        cache: false,
        beforeSend: function () {
            $('.loading-response').show();
//            $('#response').addClass('loading');
            $('form[name=frm_payment]').addClass('loading');
        },
        complete: function () {
            $('.loading-response').hide();
//            $('#response').removeClass('loading');
            $('form[name=frm_payment]').removeClass('loading');
        },
        success: function (callback) {
            try {

                if (callback.s_status !== 'success') {
                    throw callback.data;
                }
                //$('form[name=manage_album]').find('#track_'+i_track).closest("a").attr("href", base_url+'album/manage_purchased_track');//track_
                //$('form[name=manage_album]').find('#track_'+i_track).closest(".download_div").text('Download Track');

                $('form[name=frm_payment]').find('.response').html('<p class="success">Transaction comppleted succesfully.</p>').delay(2000).slideUp('fast');
                setTimeout(function () {
                    $.fancybox.close();
                    window.location.href = base_url + 'album/manage_purchased_track';
                }, 2000);

            } catch (s_error) {
                $('form[name=frm_payment]').find('.response').html('<p class="error"> ' + s_error + '</p>').hide().slideDown('fast').delay(10000).slideUp('slow');
            }
        }, error: function (error) {
            console.log(error);
        }
    });
    return false;
});

$('#btnCancel').live('click', function () {
    $.fancybox.close();
});

///code to show popup to get auto populate the event details
$(".play-song").live("click", function () {
    $.fancybox.resize();
    var i_track_id = $(this).attr("rel");
    var url = base_url + 'album/show_player';
    $.ajax({
        type: 'POST',
        url: url,
        data: {"i_track_id": i_track_id},
        dataType: "json",
        cache: false,
        success: function (a_response) {
            $.fancybox(a_response.s_html, {
                'width': 500,
                'height': 400,
                'overlayOpacity': '0.4',
                'overlayColor': '#000',
                'hideOnContentClick': false,
                'autoScale': false,
                'modal': false,
                'transitionIn': 'elastic',
                'transitionOut': 'elastic'
//                'showCloseButton'    : false,
//                'enableEscapeButton' : false,
//                'hideOnOverlayClick' : false
            });
        }, error: function (error) {
            console.log(error);
        }
    });
    //$('#fancybox-content').css('border-color','#6F2911');
});

///code to show popup to get auto populate the event details
$(".play-full-song").live("click", function () {
    $.fancybox.resize();
    var i_track_id = $(this).attr("rel");
    var url = base_url + 'album/show_player_full_song';
    $.ajax({
        type: 'POST',
        url: url,
        data: {"i_track_id": i_track_id},
        dataType: "json",
        cache: false,
        success: function (a_response) {
            $.fancybox(a_response.s_html, {
                'width': 500,
                'height': 400,
                'overlayOpacity': '0.4',
                'overlayColor': '#000',
                'hideOnContentClick': false,
                'autoScale': false,
                'modal': false,
                'transitionIn': 'elastic',
                'transitionOut': 'elastic'
//                'showCloseButton'    : false,
//                'enableEscapeButton' : false,
//                'hideOnOverlayClick' : false
            });
        }, error: function (error) {
            console.log(error);
        }
    });
    //$('#fancybox-content').css('border-color','#6F2911');
});
});