function Special(e) {
    var unicode = e.charCode ? e.charCode : e.keyCode
    if (unicode == 32 || unicode == 46) {
        return false
    }
}

function validate() {
    var new_password = document.getElementById("new_password").value;
    var password = document.getElementById("password").value;
    var conf_password = document.getElementById("conf_password").value;

    if (password == "") {
        document.getElementById('password_avail').style.display = 'block';
        document.getElementById("password").focus();
        return false;
    } else {
        document.getElementById('password_avail').style.display = 'none';
    }

    if (new_password == "") {
        document.getElementById('new_password_avail').style.display = 'block';
        document.getElementById("new_password").focus();
        return false;
    } else {
        document.getElementById('new_password_avail').style.display = 'none';
    }

    var len = new_password.length;
    if ((len < 5) || (len > 20)) {
        document.getElementById('new_password_len').style.display = 'block';
        document.getElementById("new_password").focus();
        return false;
    } else {
        document.getElementById('new_password_len').style.display = 'none';
    }

    if (conf_password == "") {
        document.getElementById('conf_password_avail').style.display = 'block';
        document.getElementById("conf_password").focus();
        return false;
    } else {
        document.getElementById('conf_password_avail').style.display = 'none';
    }

    if (conf_password != new_password) {
        document.getElementById('password_match').style.display = 'block';
        document.getElementById("conf_password").focus();
        return false;
    } else {
        document.getElementById('password_match').style.display = 'none';
    }
}