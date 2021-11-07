<?php
namespace Dfe\Customer\Plugin\Customer\Model\Address;
use Dfe\Customer\Settings\Address as SA;
use Magento\Customer\Model\Address\AbstractAddress as Sb;
class AbstractAddress {
	/**
	 * 2016-04-04 Цель плагина — изменение валидации телефона: https://mage2.pro/t/1133
	 * @see \Magento\Customer\Model\Address\AbstractAddress::validate()
	 * @param Sb $sb
	 * @param bool|string[] $r
	 * @return bool|string[]
	 */
	function afterValidate(Sb $sb, $r) {return
		SA::s()->isTelephoneRequired(df_address_store($sb)) || !is_array($r)
		? $r
		: (df_clean($r, [__('Please enter the phone number.')]) ?: true)
	;}
}