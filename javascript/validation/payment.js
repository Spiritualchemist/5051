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
    //var card_name  = document.getElementById("card_name").value;

//		var address  = document.getElementById("address").value;
//		var city  = document.getElementById("city").value;
//		var state  = document.getElementById("state").value;
//		var zip  = document.getElementById("zip").value;

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

//		if(address == "")
//		{
//			document.getElementById('address_avail').style.display = 'block';
//			document.getElementById("address").focus();
//			return false;
//		}else{
//			document.getElementById('address_avail').style.display = 'none';
//		   }
//
//		if(city == "")
//		{
//			document.getElementById('city_avail').style.display = 'block';
//			document.getElementById("city").focus();
//			return false;
//		}else{
//			document.getElementById('city_avail').style.display = 'none';
//		   }
//		if(state == "")
//		{
//			document.getElementById('state_avail').style.display = 'block';
//			document.getElementById("state").focus();
//			return false;
//		}else{
//			document.getElementById('state_avail').style.display = 'none';
//		   }
//
//		if(zip=="")
//		{
//			document.getElementById('zip_avail').style.display = 'block';
//			document.getElementById("zip").focus();
//			return false;
//		}else{
//			document.getElementById('zip_avail').style.display = 'none';
//		   }
//
//		if(isNaN(zip))
//		{
//			document.getElementById('zip_valid').style.display = 'block';
//			document.getElementById("zip").focus();
//			return false;
//		}else{
//			document.getElementById('zip_valid').style.display = 'none';
//		   }
//
//		if(zip.length ==5 || zip.length ==9)
//		{
//			document.getElementById('zip_valid').style.display = 'none';
//		}else{
//			document.getElementById('zip_valid').style.display = 'block';
//			document.getElementById("zip").focus();
//			return false;
//		   }
//
//
//		if(zip == 00000 || zip == 000000000)
//		{
//			document.getElementById('zip_valid').style.display = 'block';
//			document.getElementById("zip").focus();
//			return false;
//		}else{
//			document.getElementById('zip_valid').style.display = 'none';
//		   }
}

/*
 *     Cancel from the Page
 */
function cancel() {
    history.back();
}