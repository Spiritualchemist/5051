function Special(e) {
    var unicode = e.charCode ? e.charCode : e.keyCode
    if (unicode == 32 || unicode == 46) {
        return false
    }
}
function Alpha_Char(e) {
    var unicode = e.charCode ? e.charCode : e.keyCode

    if (unicode != 8 || unicode != 127) {
        if ((unicode > 64 && unicode < 91 ) || (unicode > 96 && unicode < 123 )) {
            return true;
        }
        else {
            return false;
        }
    }
}

function validate() {
    var user_type       = document.getElementById("user_type").value;
    var fname           = document.getElementById("fname").value;
    var lname           = document.getElementById("lname").value;
    var email           = document.getElementById("email").value;
    var password        = document.getElementById("password").value;
    var conf_password   = document.getElementById("conf_password").value;

    if (user_type == "") {
        document.getElementById('user_type_avail').style.display = 'block';
        document.getElementById("user_type").focus();
        return false;
    } else {
        document.getElementById('user_type_avail').style.display = 'none';
    }

    if (fname == "") {
        document.getElementById('fname_avail').style.display = 'block';
        document.getElementById("fname").focus();
        return false;
    } else {
        document.getElementById('fname_avail').style.display = 'none';
    }

    if (lname == "") {
        document.getElementById('lname_avail').style.display = 'block';
        document.getElementById("lname").focus();
        return false;
    } else {
        document.getElementById('lname_avail').style.display = 'none';
    }

    /*	var iChars = "!`@#$%^&*()+=-[]\\\';,./{}|\":<>?~_";

     for (var i = 0; i < fname.length; i++)
     {
     if (iChars.indexOf(fname.charAt(i)) != -1)
     {      document.getElementById('fname_valid').style.display = 'block';
     document.getElementById("fname").focus();
     return false;
     }else{
     document.getElementById('fname_valid').style.display = 'none';
     }

     }

     for (var i = 0; i < lname.length; i++)
     {
     if (iChars.indexOf(lname.charAt(i)) != -1  )
     {      document.getElementById('lname_valid').style.display = 'block';
     document.getElementById("lname").focus();
     return false;
     }else{
     document.getElementById('lname_valid').style.display = 'none';
     }

     }*/

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

    if (password == "") {
        document.getElementById('password_avail').style.display = 'block';
        document.getElementById("password").focus();
        return false;
    } else {
        document.getElementById('password_avail').style.display = 'none';
    }

    var len = password.length;
    if ((len < 5) || (len > 20)) {
        document.getElementById('password_len').style.display = 'block';
        document.getElementById("password").focus();
        return false;
    } else {
        document.getElementById('password_len').style.display = 'none';
    }

    if (conf_password == "") {
        document.getElementById('conf_password_avail').style.display = 'block';
        document.getElementById("conf_password").focus();
        return false;
    } else {
        document.getElementById('conf_password_avail').style.display = 'none';
    }

    if (conf_password != password) {
        document.getElementById('password_match').style.display = 'block';
        document.getElementById("conf_password").focus();
        return false;
    } else {
        document.getElementById('password_match').style.display = 'none';
    }
}