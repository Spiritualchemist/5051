$(document).ready(function(){

	// Session Timeout
	(function() {
		var i_timeout            = 1000 * 60 * 60 * 2; // 2 Hours
		var i_warning_difference = 1000 * 60 * 1;
		var dlg_session_timeout = '';

		var s_dlg_session_timeout =
			'<div title="Session Timeout" id="dlg-session-timeout">' +
			'<p>Your session is about to expire.</p>' +
			'</div>';

		function init() {

			// Create physical dialog box
			$('body').append( s_dlg_session_timeout );

			dlg_session_timeout = $('#dlg-session-timeout');
			dlg_session_timeout.dialog({
				width: 300,
				modal: true,
				autoOpen: false,
				buttons: {
					'Keep Me Logged In': function() {
						location.reload( true );
					}
				}
			});

			// Start the timers
			setTimeout( function() {
				dlg_session_timeout.dialog('open');
			}, i_timeout - i_warning_difference);

			setTimeout( function() {
				window.location = $('a:contains("Logout")').attr('href');
			}, i_timeout);
		};
		init();

	})();

	// Quick Entry Interface
	$('.btn_quick_entry').click(function() {
		var self            = $(this);
		var dlg_entry_notes = $('#dlg-entry-notes');
		var txtEntryNotes   = $('#txtEntryNotes').val();
		if( self.val() == 'Save With Note' &&  txtEntryNotes == '') {
			alert('Enter the notes.');
			return false;
		}

		dlg_entry_notes.dialog('close');
		$('#txtEntryNotes').val('');

		if(self.val()=='Save Without Note') {
			txtEntryNotes ='';
		}

		var id = $(".id-clicked").val();
		var Row = $('#'+id).closest('tr');
		var Params = {
			page: 'quick_entry',
			vehicle: Row.find('.txtVehicleKey').attr('rel'),
			date: Row.find('.txtDate').val(),
			odometer: Row.find('.txtOdometer').val(),
			gallons: Row.find('.txtGallons').val(),
			price: Row.find('.txtPrice').val(),
			state: Row.find('.slt_state').val(),
			note:txtEntryNotes
		};

		$.post('blank.php', Params, function( s_callback ) {
			try {
				if( s_callback !== 'Data saved.' ) {
					throw(s_callback);
				}

				Row.find('.txtOdometer').val('');
				Row.find('.txtGallons').val('');
				Row.find('.txtPrice').val('');
			} catch( s_error ) {
				alert(s_error);
			}
		});

		return false;
	});

	// Check for numeric value
	$('.numeric').blur(function() {
		var tempNumber = $(this).val();
		if (isNaN(tempNumber)) {
			alert('This needs to be a number.');
		}
	});

	// Live maintenance cost
	$('.maintenance_cost').change(function() {
		var totalQuantity = 0;
		$('.maintenance_cost').each(function() {
			var quantity = parseFloat(this.value);
			quantity = isNaN(quantity) ? 0 : quantity;
			totalQuantity += quantity;
		});
		$('#txtMaintenanceTotal').val(String(totalQuantity));
	});

	// Activate login panel on successful sign up
	if ($('.success:contains("Congratulations")').length > 0) {
		$('.signIn').slideToggle('slow');
	}

	// Clock picker
	if( $(".time").length > 0 ) {
		$(".time").timePicker({ military: true });
	}

	// Add date inputs
	$(".date").datepicker({ dateFormat: 'mm-dd-yy' });

	// Activate tabs
	$('#tab-list').tabs();

	// Don't style inputs of type image
	$('input[type=image]').addClass('dontStyleMe');

	// Check for required fields
	$('.required').after('<img class="exclamation" style="display: none;" src="shared/exclamation.png" />');
	$('.required').blur(function() {
		if ($(this).val() == "") {
			$(this).addClass('invalid');
			$('.required ~ img').hide();
			$('.invalid ~ img').show();
		}
		else {
			$(this).removeClass('invalid');
			$('.required ~ img').hide();
			$('.invalid ~ img').show();
		}
	});

	// Show history detail
	$('.imgExpandHistory').click(function() {
		$(this).next('div').slideToggle('fast');
	});

	// Verify a purposeful delete
	$('.btnRemove').click(function() {
		var answer = confirm('Are you sure?');
		if (answer) {
			// Go ahead
		}
		else {
			return false;
		}
	});

	// towFleet site; Show / Hide content for tabs
	$('.tab1').click(function() {
		$('.featureItem').hide();
		$('.desc1').show();
	});
	$('.tab2').click(function() {
		$('.featureItem').hide();
		$('.desc2').show();
	});
	$('.tab3').click(function() {
		$('.featureItem').hide();
		$('.desc3').show();
	});
	$('.tab4').click(function() {
		$('.featureItem').hide();
		$('.desc4').show();
	});
	$('.tab5').click(function() {
		$('.featureItem').hide();
		$('.desc5').show();
	});
	$('.tab6').click(function() {
		$('.featureItem').hide();
		$('.desc6').show();
	});

	// Show the Sign In box
	var trigger_login = $('.trigger-login').length;
	if ( trigger_login > 0 ) {
		$('.signIn').slideToggle('slow');
	}

	$('a:contains("Log In")').click(function() {
		$('.contact').hide();
		$('.signIn').slideToggle('slow');
		return false;
	});

	// Show Contact Form
	$('a:contains("Contact")').click(function() {
		$('.signIn').hide();
		$('.contact').slideToggle('slow');
		return false;
	});

	// Clear text box
	$('.clearMe').click(function() {
		$(this).val('');
	});

	// Check for already used username
	// $('#txtId').blur(function() {
	// 	var accountId = $('#txtId').val();
	// 	$.ajax({
	// 		type: "POST",
	// 		url: "site/check_for_existing_user.php",
	// 		data: "accountId=" + accountId,
	// 		success: function(msg) {
	// 			if (msg == 'ID Already Taken') {
	// 				$('#txtId').val(msg);
	// 				$('#txtId').addClass('invalid');
	// 			}
	// 		}
	// 	});
	// });

	// Hijack the Contact form with AJAX
	$('#btnSendMessage').click(function() {
		var name = $('#txtMailName').val();
		var email = $('#txtMailEmail').val();
		var message = $('#txtMailMessage').val();
		$('#emailMessage').html('<img src="shared/loader_dkbrown.gif" />');
		$.ajax({
			type: "POST",
			url: "site/send_email.php",
			data: "txtMailName=" + name + "&txtMailEmail=" + email + "&txtMailMessage=" + message,
			success: function(msg) {
				$('#emailMessage').text(msg);
				$('.contact').slideUp('slow');
			}
		})
		return false;
	});

	// Compare passwords
	$('#txtPassword2').blur(function() {
		var firstPass = $('#txtPassword1').val();
		var secondPass = $('#txtPassword2').val();
		if (firstPass != secondPass) {
			alert('Password does not match.');
		}
		else {
			// Move along - nothing to see here
		}
	});

	// Maintenance Costs Report
	$('#btn_maintenance').click(function() {
		var costBeginDate = $('#txtBeginCostDate').val();
		var costEndDate = $('#txtEndCostDate').val();
		var criteria = $('#sltMaintenance').val();
		$('#costResult').load('reports/maintenance_cost.php?begindate='+costBeginDate+'&enddate='+costEndDate+'&criteria='+criteria, function() {})
		return false;
	});

	// Downtime Report
	$('#btn_downtime').click(function() {
		var costBeginDate = $('#txtBeginDownTimeDate').val();
		var costEndDate = $('#txtEndDownTimeDate').val();
		var criteria = $('#sltDowntime').val();
		$('#downTimeResult').load('reports/downtime.php?begindate='+costBeginDate+'&enddate='+costEndDate+'&criteria='+criteria, function() {})
		return false;
	});

	// Mileage Report
	$('#btn_mileage').click(function() {
		var costBeginDate = $('#txtBeginMileageDate').val();
		var costEndDate = $('#txtEndMileageDate').val();
		var criteria = $('#sltMileage').val();
		$('#mileage_row').show();
		$('#mileageResult').load('reports/mileage.php?begindate='+costBeginDate+'&enddate='+costEndDate+'&criteria='+criteria, function() {})
		return false;
	});
});