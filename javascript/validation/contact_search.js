function selectall() {
    var ele = document.getElementsByName('chkmsg[]');
    var len = ele.length;
    if (document.getElementsByName('flag').value == 'set') {
        for (var i = 0; i < len; i++) {
            ele[i].checked = false;
        }
        document.getElementsByName('flag').value = '';
    }
    else {
        for (var i = 0; i < len; i++) {
            ele[i].checked = true;
        }
        document.getElementsByName('flag').value = 'set';
    }
}

function deleteAll() {
    var oChk = document.getElementsByName('chkmsg[]');
    var len = 0;

    for (i = 0; i < oChk.length; i++) {
        if (oChk[i].checked == true) {
            len = 1;
            break;
        }
    }


    if (len == 0) {
        alert('Please check at least one contact to delete it.');
    } else {
        if (confirm('Are you sure you want to delete this contact(s)?')) {
            var redirectPage = base_url + "client/delete_contact";

            document.user_contacts.action = redirectPage;
            document.user_contacts.submit();
        }
    }
}

function no_records() {
    document.user_contacts.action = base_url + "/client/manage_contact";
    document.user_contacts.submit();
}

$("#deleteContact").live("click", function () {
    var self = $(this);
    var intContactId = self.attr("rel");
    var url = base_url + 'client/delete_contact';

    $.fn.jmodal(
        {
            title: 'Remove Contact',
            content: 'Are you sure you want to delete this contact?',
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
                    data: {"intContactId": intContactId},
                    cache: false,
                    success: function (responseData) {
                        if (responseData) {
                            self.closest('.contact_content').html('');
                        }
                    }
                });
            }
        });

    /* var oChk = document.getElementsByName( 'chkmsg[]' );
     var len = 0;

     for( i = 0 ; i < oChk.length ; i++ )
     {
     if(oChk[i].checked==true)
     {
     len = 1;
     break;
     }
     }
     if(len==0)
     {
     $.fn.jmodal(
     {
     title: 'Remove Contact',
     content: 'Please check at least one contact to delete it.',
     buttonText: { ok: 'OK' },
     okEvent:function(obj, args) {
     $.fn.hideJmodalInstantly();
     }
     });
     }else
     {
     $.fn.jmodal(
     {
     title: 'Add Contact',
     content: 'Are you sure you want to delete this contact(s)?',
     buttonText: { ok: 'Yes', cancel: 'No' },
     cancelEvent:function(obj, args) {
     $.fn.hideJmodalInstantly();
     },
     okEvent: function(obj, args) {
     $.fn.hideJmodalInstantly();
     var redirectPage = base_url+"client/delete_contact";

     document.user_contacts.action = redirectPage;
     document.user_contacts.submit();
     }
     });
     }*/
});
/*$(document).ready(function()
 {
 $('#contactSearch').dataTable( {
 "sPaginationType": "full_numbers",
 "iDisplayLength": 10,
 "sSearch": "Search:",
 "oLanguage": {
 "sLengthMenu": 'Display <select>'+
 '<option value="10">10</option>'+
 '<option value="20">20</option>'+
 '<option value="30">30</option>'+
 '<option value="40">40</option>'+
 '<option value="50">50</option>'+
 '<option value="-1">All</option>'+
 '</select>'
 }
 } );
 $(".dataTables_info").hide();
 } );*/