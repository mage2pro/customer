<?php
namespace Dfe\Customer\Plugin\Sales\Model\Order\Address;
use Dfe\Customer\Settings\Address as SA;
use Magento\Customer\Model\Customer;
use Magento\Sales\Model\Order\Address;
use Magento\Sales\Model\Order\Address\Validator as Sb;
use Magento\Store\Model\Store;
class Validator extends Sb {
	/** 2016-04-05 */
	public function __construct() {}

	/**
	 * 2016-04-05
	 * Цель плагина — изменение валидации телефона.
	 * @see \Magento\Sales\Model\Order\Address\Validator::validate()
	 * @param Sb $sb
	 * @param Address $address
	 * @return void
	 */
	public function beforeValidate(Sb $sb, Address $address) {
		if (!SA::s()->isTelephoneRequired(df_address_store($address))) {
			unset($sb->required['telephone']);
		}
		else {
			$sb->required['telephone'] = 'Phone Number';
		}
	}
}