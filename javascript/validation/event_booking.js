function validate() {
    var email = document.getElementById("email").value;
    var city = document.getElementById("city").value;
    var state = document.getElementById("state").value;
    var zipcode = document.getElementById("zipcode").value;
    var date_from = document.getElementById("date_from").value;
    var date_to = document.getElementById("date_to").value;
    var category = document.getElementById("category").value;
    var genre = document.getElementById("genre").value;
    var artist = document.getElementById("artist").value;
    var active_year = document.getElementById("active_year").value;
    var price = document.getElementById("price").value;
    var description = document.getElementById("description").value;
    if (email == "") {
        document.getElementById('email_avail').style.display = 'block';
        document.getElementById("email").focus();
        return false;
    } else {
        document.getElementById('email_avail').style.display = 'none';
    }
    var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
    if (!emailPattern.test(email)) {
        document.getElementById('email_valid').style.display = 'block';
        document.getElementById("email").focus();
        return false;
    } else {
        document.getElementById('email_valid').style.display = 'none';
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
    if (zipcode.length != 5) {
        alert(zipcode.length);
        document.getElementById('zipcode_valid').style.display = 'block';
        document.getElementById("zipcode").focus();
        return false;
    } else {
        document.getElementById('zipcode_valid').style.display = 'none';
    }
    if (zipcode == 00000 || zipcode == 000000000) {
        document.getElementById('zipcode_valid').style.display = 'block';
        document.getElementById("zipcode").focus();
        return false;
    } else {
        document.getElementById('zipcode_valid').style.display = 'none';
    }
    if (date_from == "") {
        document.getElementById('date_from_avail').style.display = 'block';
        document.getElementById("date_from").focus();
        return false;
    } else {
        document.getElementById('date_from_avail').style.display = 'none';
    }
    if (date_to == "") {
        document.getElementById('date_to_avail').style.display = 'block';
        document.getElementById("date_to").focus();
        return false;
    } else {
        document.getElementById('date_to_avail').style.display = 'none';
    }
    if (date_to < date_from) {
        document.getElementById('date_to_valid').style.display = 'block';
        document.getElementById("date_to").focus();
        return false;
    } else {
        document.getElementById('date_to_valid').style.display = 'none';
    }
    if (category == "") {
        document.getElementById('category_avail').style.display = 'block';
        document.getElementById("category").focus();
        return false;
    } else {
        document.getElementById('category_avail').style.display = 'none';
    }
    if (genre == "") {
        document.getElementById('genre_avail').style.display = 'block';
        document.getElementById("genre").focus();
        return false;
    } else {
        document.getElementById('genre_avail').style.display = 'none';
    }
    if (artist == "") {
        document.getElementById('artist_avail').style.display = 'block';
        document.getElementById("artist").focus();
        return false;
    } else {
        document.getElementById('artist_avail').style.display = 'none';
    }
    if (active_year == "") {
        document.getElementById('active_year_avail').style.display = 'block';
        document.getElementById("active_year").focus();
        return false;
    } else {
        document.getElementById('active_year_avail').style.display = 'none';
    }
    if (description == "") {
        document.getElementById('description_avail').style.display = 'block';
        document.getElementById("description").focus();
        return false;
    } else {
        document.getElementById('description_avail').style.display = 'none';
    }
    if (description.length > 100) {
        document.getElementById('description_valid').style.display = 'block';
        document.getElementById("description").focus();
        return false;
    } else {
        document.getElementById('description_valid').style.display = 'none';
    }
}


$("#btnAdd").live("click", function () {

    var self = $(this);
    var intBookingId = self.attr("rel");
    var url = base_url + 'client/addContact';

    $.fn.jmodal({
		title: 'Add Contact', content: 'Would you like to add booking to contact list?', buttonText: { ok: 'Yes', cancel: 'No' }, cancelEvent: function (obj, args) {
        $.fn.hideJmodalInstantly();
    }, okEvent: function (obj, args) {
        $.fn.hideJmodalInstantly();
        $.ajax({
		type: 'GET', url: url, dataType: "json", data: {"intBookingId": intBookingId}, cache: false, success: function (responseData) {
            if (responseData) {
                self.closest('.form').html('');
            }
        }                    });
    }            });
});
