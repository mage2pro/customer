<?php
namespace Dfe\Customer\Plugin\Customer\Model\Address;
use Dfe\Customer\Settings\Address as SA;
use Magento\Customer\Model\Address\AbstractAddress as Sb;
use Magento\Framework\Phrase;
class AbstractAddress {
	/**
	 * 2016-04-04
	 * Цель плагина — изменение валидации телефона.
	 * https://mage2.pro/t/1133
	 * @see \Magento\Customer\Model\Address\AbstractAddress::validate()
	 * @param Sb $sb
	 * @param bool|string[] $result
	 * @return bool|string[]
	 */
	public function afterValidate(Sb $sb, $result) {return
		SA::s()->isTelephoneRequired(df_address_store($sb)) || !is_array($result)
		? $result
		: (df_clean($result, [__('Please enter the phone number.')]) ?: true)
	;}
}