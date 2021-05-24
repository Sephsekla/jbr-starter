import {
    magnificPopup
} from 'magnific-popup';

$ = jQuery;

const practiceConfirmation = `<div class="popup stay-in-touch listing-thankyou">
<div class="popup-body container-fluid form gform_confirmation_message">
<button title="Close (Esc)" type="button" class="mfp-close">×</button>
<h3>Thanks for Listing Your Practice!</h3>
<p>Once your information has been verified, your practice will appear in the results when patients search our site for a reproductive specialist.</p>
<button class="button manual-close">Close</button> 
</div>
</div>`;

export default function initPopups(){
	$(".popup-trigger").magnificPopup({ // Create an mfp instance for the image.
		type: 'inline',
		closeBtnInside: true,
		fixedContentPos: true
	});

	$(document).on('click','.manual-close',() => {
		$.magnificPopup.close();
	});


	$(document).on('gform_confirmation_loaded', function(event, formId){
		// code to be trigger when confirmation page is loaded

		console.log('submission');
		

		if(formId === 1){

		//jQuery("#gform_ajax_spinner_"+formId).remove();

		$.magnificPopup.open({
			items: {
			  src: practiceConfirmation,
			},
			type: 'inline',
			closeBtnInside: true,
			fixedContentPos: true
		  });

		}
	});
}