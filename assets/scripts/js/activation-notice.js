/**
 * Global variables used:
 * - ajaxurl
 */
(function ($) {

	var ajax = {};

	function init() {
		window.addEventListener('load', function (e) {
			setTimeout(setupActivationNoticeDismissal, 1000);
			setTimeout(setupBfcmNoticeDismissal, 1000);
		});
	}

	function setupActivationNoticeDismissal() {
		var panel = document.querySelector('.themename-activation-notice.is-dismissible');
		if (!panel) return;
		panel.querySelector('.notice-dismiss').addEventListener('click', ajax.saveActivationDismissal);
	}

	ajax.saveActivationDismissal = function (e) {
		$.ajax({
			url: ajaxurl,
			type: 'post',
			data: {
				action: 'themename_activation_notice_dismissal',
				nonce: themenameOpts.activationNotice.dismissalNonce,
				dismiss: 1
			}
		}).always(function (r) {
			if (r.success) console.log(r.data);
		});
	};

	function setupBfcmNoticeDismissal() {
		var panel = document.querySelector('.themename-bfcm-notice.is-dismissible');
		if (!panel) return;
		panel.querySelector('.notice-dismiss').addEventListener('click', ajax.saveBfcmDismissal);
	}

	ajax.saveBfcmDismissal = function (e) {
		$.ajax({
			url: ajaxurl,
			type: 'post',
			data: {
				action: 'themename_bfcm_notice_dismissal',
				nonce: themenameOpts.bfcmNotice.dismissalNonce,
				dismiss: 1
			}
		}).always(function (r) {
			if (r.success) console.log(r.data);
		});
	};

	init();

})(jQuery);
