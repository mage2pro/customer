<?php
namespace Dfe\Customer\Plugin\Customer\Model\ResourceModel;
use Dfe\Customer\Settings\Address as SA;
use Magento\Customer\Api\Data\AddressInterface as AI;
use Magento\Customer\Model\Address;
use Magento\Customer\Model\Customer;
use Magento\Customer\Model\Data\Address as CDA;
use Magento\Customer\Model\ResourceModel\AddressRepository as Sb;
use Magento\Framework\Exception\InputException;
use Magento\Store\Model\Store;
class AddressRepository {
	/**
	 * 2016-04-04 Цель плагина — изменение валидации телефона. https://mage2.pro/t/1133
	 * @see \Magento\Customer\Model\ResourceModel\AddressRepository::save()
	 * @param Sb $sb
	 * @param \Closure $f
	 * @param AI|CDA $a
	 * @return AI
	 * @throws InputException
	 */
	function aroundSave(Sb $sb, \Closure $f, AI $a) {
		$c = df_customer($a->getCustomerId()); /** @var Customer $c */
		$store = $c->getStore(); /** @var Store $store */
		/** @var AI $r */
		if (SA::s()->isTelephoneRequired($store)) {
			$r = $f($a);
		}
		else {
			$aM = null; /** @var Address $aM */
			if ($a->getId()) {
				$aM = df_address_registry()->retrieve($a->getId());
			}
			if ($aM) {
				$aM->updateData($a);
			}
			else {
				$aM = df_new_om(Address::class);
				$aM->updateData($a);
				$aM->setCustomer($c);
			}
			$e = $this->_validate($aM); /** @var InputException $e */
			if ($e->wasErrorAdded()) {
				throw $e;
			}
			$aM->save();
			# Clean up the customer registry since the Address save has side effect on customer:
			# \Magento\Customer\Model\ResourceModel\Address::_afterSave
			df_customer_registry()->remove($a->getCustomerId());
			df_address_registry()->push($aM);
			$c->getAddressesCollection()->clear();
			$r = $aM->getDataModel();
		}
		return $r;
	}

	/**
	 * 2016-04-05
	 * @see \Magento\Customer\Model\ResourceModel\AddressRepository::_validate()
	 * https://github.com/magento/magento2/blob/ab051bf/app/code/Magento/Customer/Model/ResourceModel/AddressRepository.php#L243-L305
	 * @param Address $a
	 * @return InputException
	 */
	private function _validate(Address $a) {
		$r = new InputException(); /** @var InputException $r */
		if (!$a->getShouldIgnoreValidation()) {
			$fields = ['firstname', 'lastname', 'street', 'city', 'country_id']; /** @var string[] $fields */
			# 2016-04-05 Валидацию телефона не проводим, потому что сюда мы попадаем только когда телефон необязателен.
			if (!in_array($a->getCountryId(), df_directory()->getCountriesWithOptionalZip())) {
				$fields[]= 'postcode';
			}
			if (df_directory()->isRegionRequired($a->getCountryId())) {
				$fields[]= 'region' . ($a->getCountryModel()->getRegionCollection()->count() ? '_id' : '');
			}
			array_map(function($field) use($a, $r) {
				if (!\Zend_Validate::is($a->getDataUsingMethod($field), 'NotEmpty')) {
					$r->addError(__(InputException::REQUIRED_FIELD, ['fieldName' => $field]));
				}
			}, $fields);
		}
		return $r;
	}
}