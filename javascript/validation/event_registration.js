$(document).ready(function () {
    var $ = jQuery.noConflict();

    //function validate() {
    $('#btnEventSubmit').live('click', function(){
        var address = document.getElementById("address").value;
        var city = document.getElementById("city").value;
        var state = document.getElementById("state").value;
        var zipcode = document.getElementById("zipcode").value;
        var date = document.getElementById("date").value;
        var time = document.getElementById("time").value;
        var venue = document.getElementById("venue").value;
        var artist = document.getElementById("artist").value;
		var genre = document.getElementById("genre").value;       
        var price = document.getElementById("price").value;
        var phone_no = document.getElementById("phone_no").value;
        if (address == "") {
            document.getElementById('address_avail').style.display = 'block';
            document.getElementById("address").focus();
            return false;
        } else {
            document.getElementById('address_avail').style.display = 'none';
        }
        if (address.length > 100) {
            document.getElementById('address_valid').style.display = 'block';
            document.getElementById("address").focus();
            return false;
        } else {
            document.getElementById('address_valid').style.display = 'none';
        }
        if (city == "") {
            document.getElementById('city_avail').style.display = 'block';
            document.getElementById("city").focus();
            return false;
        } else {
            document.getElementById('city_avail').style.display = 'none';
        }
        if (state == "") {
            document.getElementById('state_avail').style.display = 'block';
            document.getElementById("state").focus();
            return false;
        } else {
            document.getElementById('state_avail').style.display = 'none';
        }
        var iChars = "!`@#$%^&*()+=-[]\\\';,./{}|\":<>?~_";
        for (var i = 0; i < city.length; i++) {
            if (iChars.indexOf(city.charAt(i)) != -1) {
                document.getElementById('city_valid').style.display = 'block';
                document.getElementById("city").focus();
                return false;
            } else {
                document.getElementById('city_valid').style.display = 'none';
            }
        }
        for (var i = 0; i < state.length; i++) {
            if (iChars.indexOf(state.charAt(i)) != -1) {
                document.getElementById('state_valid').style.display = 'block';
                document.getElementById("state").focus();
                return false;
            } else {
                document.getElementById('state_valid').style.display = 'none';
            }
        }
        if (zipcode == "") {
            document.getElementById('zipcode_avail').style.display = 'block';
            document.getElementById("zipcode").focus();
            return false;
        } else {
            document.getElementById('zipcode_avail').style.display = 'none';
        }
        if (isNaN(zipcode)) {
            document.getElementById('zipcode_valid').style.display = 'block';
            document.getElementById("zipcode").focus();
            return false;
        } else {
            document.getElementById('zipcode_valid').style.display = 'none';
        }
        if (zipcode.length > 5 || zipcode.length < 5) {
            document.getElementById('zipcode_valid').style.display = 'block';
            document.getElementById("zipcode").focus();
            return false;
        } else {
            document.getElementById('zipcode_valid').style.display = 'none';
        }
        if (zipcode == 00000) {
            document.getElementById('zipcode_valid').style.display = 'block';
            document.getElementById("zipcode").focus();
            return false;
        } else {
            document.getElementById('zipcode_valid').style.display = 'none';
        }
        if (date == "") {
            document.getElementById('date_avail').style.display = 'block';
            document.getElementById("date").focus();
            return false;
        } else {
            document.getElementById('date_avail').style.display = 'none';
        }
        if (time == "") {
            document.getElementById('time_avail').style.display = 'block';
            document.getElementById("time").focus();
            return false;
        } else {
            document.getElementById('time_avail').style.display = 'none';
        }
        var category = document.getElementById("category").value;
        if (category == "") {
            document.getElementById('category_avail').style.display = 'block';
            document.getElementById("category").focus();
            return false;
        } else {
            document.getElementById('category_avail').style.display = 'none';
        }
        if (venue == "") {
            document.getElementById('venue_avail').style.display = 'block';
            document.getElementById("venue").focus();
            return false;
        } else {
            document.getElementById('venue_avail').style.display = 'none';
        }
        var scategory = document.getElementById("scategory").value;
        if (scategory == "") {
            document.getElementById('scategory_avail').style.display = 'block';
            document.getElementById("scategory").focus();
            return false;
        } else {
            document.getElementById('scategory_avail').style.display = 'none';
        }
        if (artist == "") {
            document.getElementById('artist_avail').style.display = 'block';
            document.getElementById("artist").focus();
            return false;
        } else {
            document.getElementById('artist_avail').style.display = 'none';
        }
        if (genre == "") {
            document.getElementById('genre_avail').style.display = 'block';
            document.getElementById("genre").focus();
            return false;
        } else {
            document.getElementById('genre_avail').style.display = 'none';
        }
        
        /*if(price=="")		{			document.getElementById('price_avail').style.display = 'block';			document.getElementById("price").focus();			return false;		}else{			document.getElementById('price_avail').style.display = 'none';        		   }*/
        var iChar = "!`@#$%^&*=[]\\\';,./{}|\":<>?~_";
        for (var i = 0; i < phone_no.length; i++) {
            if (iChar.indexOf(phone_no.charAt(i)) != -1) {
                document.getElementById('phone_no_valid').style.display = 'block';
                document.getElementById("phone_no").focus();
                return false;
            } else {
                document.getElementById('phone_no_valid').style.display = 'none';
            }
        }
    });

    $(".add-to-calendar").live("click", function () {
        var self = $(this);
        var intRegnId = self.attr("rel");
        var url = base_url + 'client/addEvent';
        if (confirm('Would you like to add event to calendar?')) {
            $.ajax({
                type: 'GET',
                url: url,
                dataType: "json",
                data: {"intRegnId": intRegnId},
                cache: false,
                success: function (responseData) {
                    if (responseData) {
                        self.closest('.form').html('');
                    }
                }
            });
        }

        /*$.fn.jmodal({
         title: 'Add Event',
         content: 'Would you like to add event to calendar?',
         buttonText: { ok: 'Yes', cancel: 'No' },
         cancelEvent: function (obj, args) {
         $.fn.hideJmodalInstantly();
         },
         okEvent: function (obj, args) {
         $.fn.hideJmodalInstantly();
         $.ajax({
         type: 'GET',
         url: url,
         dataType: "json",
         data: {"intRegnId": intRegnId},
         cache: false,
         success: function (responseData) {
         if (responseData) {
         self.closest('.form').html('');
         }
         }
         });
         }
         });*/
    });

    $(".view_map").live("click", function () {

        var s_address = $(this).attr('address');
        var s_city = $(this).attr('city');
        var s_state = $(this).attr('state');
        var zipcode = $(this).attr('zipcode');
        var s_event = $(this).attr('event');
        $.fancybox.resize();
        var url = base_url + 'client/viewMap';
        $.ajax({
            type: 'POST',
            url: url,
            data: {"s_address": s_address, 's_city': s_city, 's_state': s_state, 's_zipcode': zipcode, "s_event": s_event},
            dataType: "json",
            cache: false,
            success: function (s_callback) {
                try {
                    if (s_callback.s_status != 'success') {
                        throw( s_callback.data );
                    }

                    $.fancybox(s_callback.data, {
                        'width': 500,
                        'height': 300,
                        'overlayOpacity': '0.4',
                        'overlayColor': '#000',
                        'hideOnContentClick': false,
                        'autoScale': false,
                        'modal': false,
                        'transitionIn': 'elastic',
                        'transitionOut': 'elastic'
                    });

                } catch (s_error) {
                    alert(s_error);
                }
            }, error: function (error) {
                console.log(error);
            }
        });
    });

});