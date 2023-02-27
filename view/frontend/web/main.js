// 2016-04-01
define(['jquery', 'Dfe_Phone/lib/js/main'], function($) {return (
	/**
	 * @param {Object} cfg
	 * @param {String[]} cfg.countries
	 * @param {String} cfg.telephone
	 * @param {String} cfg.utils
	 * @returns void
	 * http://stackoverflow.com/a/6460748
	 * https://code.google.com/p/jsdoc-toolkit/wiki/TagParam
	 */
	function(cfg) {
		/**
		 * 2016-04-01
		 * https://github.com/magento/magento2/blob/ce68a6d/app/code/Magento/Customer/view/frontend/templates/address/edit.phtml#L17
		 * @type {jQuery} HTMLFormElement
		 */
		var $form = $('.form-address-edit');
		/**
		 * 2016-04-01
		 * https://github.com/magento/magento2/blob/ce68a6d/app/code/Magento/Customer/view/frontend/templates/address/edit.phtml#L30-L35
		 * How is the «Phone Number» input implemented
		 * in a customer account's «Add New Address» form? https://mage2.pro/t/1048
		 * @type {jQuery} HTMLDivElement
		 */
		var $telephoneContainer = $('.telephone', $form);
		/** @type {jQuery} HTMLInputElement */
		var $telephoneInput = $('input', $telephoneContainer);
		if (!cfg.telephone) {
			// 2016-04-01 Недостаточно просто скрыть поле: надо его удалить, чтобы форма не отсылала его на сервер.
			$telephoneContainer.remove();
		}
		else {
			// 2016-04-01
			// https://github.com/magento/magento2/blob/6ea7d2d/app/code/Magento/Config/Model/Config/Source/Nooptreq.php#L16-L18
			/** @type {Boolean} */ var isRequired = 'req' === cfg.telephone;
			$telephoneContainer.toggleClass('required', isRequired);
			if (!isRequired) {
				$telephoneInput.removeAttr('aria-required'); // 2016-04-04
			}
		}
		/*$telephoneInput.mask('(000) 000-0000', {
			placeholder: '+7 (___) ___-____'
			,selectOnFocus: true
		});*/
		$telephoneInput.intlTelInput({
			geoIpLookup: function(cb) {
				// 2017-09-07
				// «Note that the callback must still be called in the event of an error,
				// hence the use of always in this example.
				// @todo Store the result in a cookie to avoid repeat lookups!»
				$.get('//ipinfo.io', function() {}, 'jsonp').always(function(r) {cb(r && r.country ? r.country : '');});
			}
			,initialCountry: 'auto'
			,nationalMode: false
			,onlyCountries: cfg.countries
			,preferredCountries: []
			,separateDialCode: false
		});
		$.fn.intlTelInput.loadUtils(cfg.utils);
	});
});