/*
 *  validate Payment Registration
 */
function validate() {
    var fname = document.getElementById("fname").value;
    var lname = document.getElementById("lname").value;
    var creditCardType = document.getElementById("creditCardType").value;
    var card_number = document.getElementById("card_number").value;
    var expDateMonth = document.getElementById("expDateMonth").value;
    var expDateYear = document.getElementById("expDateYear").value;
    var cvv = document.getElementById("cvv").value;

    var iSpecial = "!`@#$%^&*=[]\\\';,./{}|\":<>?~_";
    var iNum = "123456789";
    var iChar = "!`@#$%^&*=[]\\\';,./{}|\":<>?~_";

    //alert("aa="+cvv.trim());

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

    if (creditCardType == "" || creditCardType == -1) {
        document.getElementById('creditCardType_avail').style.display = 'block';
        document.getElementById("creditCardType").focus();
        return false;
    } else {
        document.getElementById('creditCardType_avail').style.display = 'none';
    }
    if (card_number == "") {
        document.getElementById('card_number_avail').style.display = 'block';
        document.getElementById("card_number").focus();
        return false;
    } else {
        document.getElementById('card_number_avail').style.display = 'none';
    }

    var iChar = "!`@#$%^&*=[]\\\';,./{}|\":<>?~_";

    for (var i = 0; i < card_number.length; i++) {
        if (iChar.indexOf(card_number.charAt(i)) != -1) {
            document.getElementById('card_number_valid').style.display = 'block';
            document.getElementById("card_number").focus();
            return false;
        } else {
            document.getElementById('card_number_valid').style.display = 'none';
        }

    }

    if (isNaN(card_number)) {
        document.getElementById('card_number_valid').style.display = 'block';
        document.getElementById("card_number").focus();
        return false;
    } else {
        document.getElementById('card_number_valid').style.display = 'none';
    }


    var len = card_number.length;
    if (len != 16) {
        document.getElementById('card_number_len').style.display = 'block';
        document.getElementById("card_number").focus();
        return false;
    } else {
        document.getElementById('card_number_len').style.display = 'none';
    }

    if (expDateMonth == "" || expDateMonth == -1) {
        document.getElementById('expDateMonth_avail').style.display = 'block';
        document.getElementById("expDateMonth").focus();
        return false;
    } else {
        document.getElementById('expDateMonth_avail').style.display = 'none';
    }
    if (expDateYear == "" || expDateYear == -1) {
        document.getElementById('expDateMonth_avail').style.display = 'block';
        document.getElementById("expDateYear").focus();
        return false;
    } else {
        document.getElementById('expDateMonth_avail').style.display = 'none';
    }
    if (cvv == "") {
        document.getElementById('cvv_avail').style.display = 'block';
        document.getElementById("cvv").focus();
        return false;
    } else {
        document.getElementById('cvv_avail').style.display = 'none';
    }

    if (isNaN(cvv)) {
        document.getElementById('cvv_valid').style.display = 'block';
        document.getElementById("cvv").focus();
        return false;
    } else {
        document.getElementById('cvv_valid').style.display = 'none';
    }

    var len = cvv.length;
    if (len != 3) {
        document.getElementById('cvv_len').style.display = 'block';
        document.getElementById("cvv").focus();
        return false;
    } else {
        document.getElementById('cvv_len').style.display = 'none';
    }
}