// 2016-04-01
define([
	'jquery'
], function($) {return (
	/**
	 * @param {Object} config
	 * @param {String} config.telephone
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
		var $telephone = $('.telephone', $form);
		!config.telephone
			// 2016-04-01
			// Недостаточно просто скрыть поле: надо его удалить,
			// чтобы форма не отсылала его на сервер.
			? $telephone.remove()
			// 2016-04-01
			// https://github.com/magento/magento2/blob/6ea7d2d/app/code/Magento/Config/Model/Config/Source/Nooptreq.php#L16-L18
			: $telephone.toggleClass('required', 'req' === config.telephone)
		;
	});
});