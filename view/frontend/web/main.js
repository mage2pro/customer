// 2016-04-01
define(['jquery', 'Df_Phone/lib/js/main'], function($) {return (
	/**
	 * @param {Object} config
	 * @param {String[]} config.countries
	 * @param {String} config.telephone
	 * @param {String} config.utils
	 * @returns void
	 * http://stackoverflow.com/a/6460748
	 * https://code.google.com/p/jsdoc-toolkit/wiki/TagParam
	 */
	function(config) {
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
		if (!config.telephone) {
			// 2016-04-01
			// Недостаточно просто скрыть поле: надо его удалить, чтобы форма не отсылала его на сервер.
			$telephoneContainer.remove();
		}
		else {
			/** @type {Boolean} */
			// 2016-04-01
			// https://github.com/magento/magento2/blob/6ea7d2d/app/code/Magento/Config/Model/Config/Source/Nooptreq.php#L16-L18
			var isRequired = 'req' === config.telephone;
			$telephoneContainer.toggleClass('required', isRequired);
			if (!isRequired) {
				// 2016-04-04
				$telephoneInput.removeAttr('aria-required');
			}
		}
		/*$telephoneInput.mask('(000) 000-0000', {
			placeholder: '+7 (___) ___-____'
			,selectOnFocus: true
		});*/
		$telephoneInput.intlTelInput({
			geoIpLookup: function(callback) {
				$.get('http://ipinfo.io', function() {}, "jsonp").always(function(resp) {
					var countryCode = (resp && resp.country) ? resp.country : '';
					callback(countryCode);
				});
			}
			,initialCountry: 'auto'
			,nationalMode: false
			,onlyCountries: config.countries
			,preferredCountries: []
			,separateDialCode: false
			,utilsScript: config.utils
		});
	});
});