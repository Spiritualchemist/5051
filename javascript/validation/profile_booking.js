function Special(e) {
    var unicode = e.charCode ? e.charCode : e.keyCode
    if (unicode == 32 || unicode == 46) {
        return false
    }
}

function validate() {
    var profile_img = document.getElementById("profile_img").value;
    var artist_name = document.getElementById("artist_name").value;
    var origin_city = document.getElementById("origin_city").value;
    var origin_state = document.getElementById("origin_state").value;
//		var inspirer  = document.getElementById("inspirer").value;
//		var venues_attended  = document.getElementById("venues_attended").value;

    var address = document.getElementsByName("address[]");
    var city = document.getElementsByName("city[]");
    var state = document.getElementsByName("state[]");
    var zipcode = document.getElementsByName("zipcode[]");
    var date = document.getElementsByName("date[]");
    var time = document.getElementsByName("time[]");
    var genre = document.getElementsByName("genre[]");
    var venue = document.getElementsByName("venue[]");
    var price = document.getElementsByName("price[]");
    var phone_no = document.getElementsByName("phone_no[]");

    if (profile_img == "") {
        document.getElementById('profile_img_avail').style.display = 'block';
        document.getElementById("profile_img").focus();
        return false;
    } else {
        document.getElementById('profile_img_avail').style.display = 'none';
    }

    var image = /.(jpg|jpeg|png|gif|bmp)$/i;
    if (!image.test(profile_img)) {
        document.getElementById('profile_img_valid').style.display = 'block';
        document.getElementById("profile_img").focus();
        return false;
    } else {
        document.getElementById('profile_img_valid').style.display = 'none';
    }

    if (artist_name == "") {
        document.getElementById('artist_name_avail').style.display = 'block';
        document.getElementById("artist_name").focus();
        return false;
    } else {
        document.getElementById('artist_name_avail').style.display = 'none';
    }

    if (origin_city == "") {
        document.getElementById('origin_city_avail').style.display = 'block';
        document.getElementById("origin_city").focus();
        return false;
    } else {
        document.getElementById('origin_city_avail').style.display = 'none';
    }

    if (origin_state == "") {
        document.getElementById('origin_state_avail').style.display = 'block';
        document.getElementById("origin_state").focus();
        return false;
    } else {
        document.getElementById('origin_state_avail').style.display = 'none';
    }
    /*if(inspirer=="")
     {
     document.getElementById('inspirer_avail').style.display = 'block';
     document.getElementById("inspirer").focus();
     return false;
     }else{
     document.getElementById('inspirer_avail').style.display = 'none';
     }

     if(venues_attended=="")
     {
     document.getElementById('venues_attended_avail').style.display = 'block';
     document.getElementById("venues_attended").focus();
     return false;
     }else{
     document.getElementById('venues_attended_avail').style.display = 'none';
     }*/

    var len = address.length;
    var flag = 0;
    for (var i = 0, j = 1; i < len; i++, j++) {
        if (address[i].value == "") {
            document.getElementById('address_avail' + j).style.display = 'block';
            document.getElementById("address" + j).focus();
            //return false;
            flag = 1;
            break;
        } else {
            document.getElementById('address_avail' + j).style.display = 'none';
        }
        if ((address[i].value).length > 100) {
            document.getElementById('address_valid' + j).style.display = 'block';
            document.getElementById("address" + j).focus();
            //return false;
            flag = 1;
            break;
        } else {
            document.getElementById('address_valid' + j).style.display = 'none';
        }
        if (city[i].value == "") {
            document.getElementById('city_avail' + j).style.display = 'block';
            document.getElementById("city" + j).focus();
            //return false;
            flag = 1;
            break;
        } else {
            document.getElementById('city_avail' + j).style.display = 'none';
        }
        ///	[i].value

        if (state[i].value == "") {
            document.getElementById('state_avail' + j).style.display = 'block';
            document.getElementById("state" + j).focus();
            //return false;
            flag = 1;
            break;
        } else {
            document.getElementById('state_avail' + j).style.display = 'none';
        }
        if (zipcode[i].value == "") {
            document.getElementById('zipcode_avail' + j).style.display = 'block';
            document.getElementById("zipcode" + j).focus();
            //return false;
            flag = 1;
            break;
        } else {
            document.getElementById('zipcode_avail' + j).style.display = 'none';
        }

        if (isNaN(zipcode[i].value)) {
            document.getElementById('zipcode_valid' + j).style.display = 'block';
            document.getElementById("zipcode" + j).focus();
            //return false;
            flag = 1;
            break;
        } else {
            document.getElementById('zipcode_valid' + j).style.display = 'none';
        }


        if ((zipcode[i].value).length > 5 || (zipcode[i].value).length < 5) {
            document.getElementById('zipcode_valid' + j).style.display = 'block';
            document.getElementById("zipcode" + j).focus();
            //return false;
            flag = 1;
            break;
        } else {
            document.getElementById('zipcode_valid' + j).style.display = 'none';
        }

        if (zipcode[i].value == 00000) {
            document.getElementById('zipcode_valid' + j).style.display = 'block';
            document.getElementById("zipcode" + j).focus();
            //return false;
            flag = 1;
            break;
        } else {
            document.getElementById('zipcode_valid' + j).style.display = 'none';
        }

        if (date[i].value == "") {
            document.getElementById('date_avail' + j).style.display = 'block';
            document.getElementById("date" + j).focus();
            //return false;
            flag = 1;
            break;
        } else {
            document.getElementById('date_avail' + j).style.display = 'none';
        }
        if (time[i].value == "") {
            document.getElementById('time_avail' + j).style.display = 'block';
            document.getElementById("time" + j).focus();
            //return false;
            flag = 1;
            break;
        } else {
            document.getElementById('time_avail' + j).style.display = 'none';
        }
        if (genre[i].value == "") {
            document.getElementById('genre_avail' + j).style.display = 'block';
            document.getElementById("genre" + j).focus();
            //return false;
            flag = 1;
            break;
        } else {
            document.getElementById('genre_avail' + j).style.display = 'none';
        }
        if (venue[i].value == "") {
            document.getElementById('venue_avail' + j).style.display = 'block';
            document.getElementById("venue" + j).focus();
            //return false;
            flag = 1;
            break;
        } else {
            document.getElementById('venue_avail' + j).style.display = 'none';
        }
        var phone = /^\+{0,1}[0-9 \(\)\.\-]+$/;

        if (phone_no[i].value != '') {
            if (!phone.test(phone_no[i].value)) {
                document.getElementById('phone_no_valid' + j).style.display = 'block';
                document.getElementById("phone_no" + j).focus();
                //return false;
                flag = 1;
                break;

            } else {
                document.getElementById('phone_no_valid' + j).style.display = 'none';
                //alert(22);
            }
        }

    }

    for (var m = 1; m <= len; m++) {
        if (m != j) {
            document.getElementById("event_data" + m).style.display = 'none';
            //document.getElementById("show"+i).style.display = 'block';
            //document.getElementById("hide"+i).style.display = 'block';
            // bool = m;
            //break;
        } else {
            document.getElementById("event_data" + m).style.display = 'block';
            //document.getElementById("show"+str).style.display = 'none';
            //document.getElementById("hide"+i).style.display = 'block';
            bool = m;
            //break;
        }
    }

    if (flag == 1) {
        document.getElementById("event_data" + bool).style.display = 'block';
        return false;
    }

}
	