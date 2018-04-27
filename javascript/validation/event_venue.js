function validate() {
    var email = document.getElementById("email").value;
    var name = document.getElementById("name").value;
    var address = document.getElementById("address").value;
    var name = document.getElementById("name").value;
    var city = document.getElementById("city").value;
    var state = document.getElementById("state").value;
    var zipcode = document.getElementById("zipcode").value;
    var venue = document.getElementsByName("venue[]");
    var description = document.getElementById("description").value;
    var flag = 0;
    var len = venue.length;

    for (var i = 0; i < len; i++) {
        if (venue[i].checked)
            flag = 1;
    }

    if (name == "") {
        document.getElementById('name_avail').style.display = 'block';
        document.getElementById("name").focus();
        return false;
    } else {
        document.getElementById('name_avail').style.display = 'none';
    }
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

    var phone = /^\+{0,1}[0-9 \(\)\.\-]+$/;
    if (phone_no.value != '') {
        if (!phone.test(phone_no.value)) {
            document.getElementById('phone_no_valid').style.display = 'block';
            document.getElementById("phone_no").focus();
            return false;
        } else {
            document.getElementById('phone_no_valid').style.display = 'none';
        }
    }
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

    if (flag == 0) {
        document.getElementById('venue_avail').style.display = 'block';
        //document.getElementById("venue").focus();
        return false;
    } else {
        document.getElementById('venue_avail').style.display = 'none';
    }

    if (description == "") {
        document.getElementById('description_avail').style.display = 'block';
        document.getElementById("description").focus();
        return false;
    } else {
        document.getElementById('description_avail').style.display = 'none';
    }

    if (description.length > 200) {
        document.getElementById('description_valid').style.display = 'block';
        document.getElementById("description").focus();
        return false;
    } else {
        document.getElementById('description_valid').style.display = 'none';
    }
}