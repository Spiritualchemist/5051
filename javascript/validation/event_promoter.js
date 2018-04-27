function validate() {
    //alert(100);
    var email = document.getElementById("email").value;
    var name = document.getElementById("name").value;
    var phone_no = document.getElementById("phone_no");
    var city = document.getElementById("city").value;
    var state = document.getElementById("state").value;
    var zipcode = document.getElementById("zipcode").value;
    var promotion_type = document.getElementsByName("promotion_type[]");
    var description = document.getElementById("description").value;
    var affiliate = document.getElementById("affiliate").value;
    var flag = 0;
    var len = promotion_type.length;

    for (var i = 0; i < len; i++) {
        if (promotion_type[i].checked)
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
        document.getElementById('promotion_type_avail').style.display = 'block';
        //document.getElementById("promotion_type").focus();
        return false;
    } else {
        document.getElementById('promotion_type_avail').style.display = 'none';
    }

    if (description == "") {
        document.getElementById('description_avail').style.display = 'block';
        document.getElementById("description").focus();
        return false;
    } else {
        document.getElementById('description_avail').style.display = 'none';
    }

    if (description.length > 95) {
        document.getElementById('description_valid').style.display = 'block';
        document.getElementById("description").focus();
        return false;
    } else {
        document.getElementById('description_valid').style.display = 'none';
    }

    if (affiliate == "") {
        document.getElementById('affiliate_avail').style.display = 'block';
        document.getElementById("affiliate").focus();
        return false;
    } else {
        document.getElementById('affiliate_avail').style.display = 'none';
    }

    if (affiliate.length > 95) {
        document.getElementById('affiliate_valid').style.display = 'block';
        document.getElementById("affiliate").focus();
        return false;
    } else {
        document.getElementById('affiliate_valid').style.display = 'none';
    }
}