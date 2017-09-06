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
	 * @param AI|CDA $address
	 * @return AI
	 * @throws InputException
	 */
	function aroundSave(Sb $sb, \Closure $f, AI $address) {
		$customer = df_customer($address->getCustomerId()); /** @var Customer $customer */
		$store = $customer->getStore(); /** @var Store $store */
		/** @var AI $result */
		if (SA::s()->isTelephoneRequired($store)) {
			$result = $f($address);
		}
		else {
			$addressM = null; /** @var Address $addressM */
			if ($address->getId()) {
				$addressM = df_address_registry()->retrieve($address->getId());
			}
			if ($addressM) {
				$addressM->updateData($address);
			}
			else {
				$addressM = df_new_om(Address::class);
				$addressM->updateData($address);
				$addressM->setCustomer($customer);
			}
			$e = $this->_validate($addressM); /** @var InputException $e */
			if ($e->wasErrorAdded()) {
				throw $e;
			}
			$addressM->save();
			// Clean up the customer registry since the Address save has side effect on customer:
			// \Magento\Customer\Model\ResourceModel\Address::_afterSave
			df_customer_registry()->remove($address->getCustomerId());
			df_address_registry()->push($addressM);
			$customer->getAddressesCollection()->clear();
			$result = $addressM->getDataModel();
		}
		return $result;
	}

	/**
	 * 2016-04-05
	 * @see \Magento\Customer\Model\ResourceModel\AddressRepository::_validate()
	 * https://github.com/magento/magento2/blob/ab051bf/app/code/Magento/Customer/Model/ResourceModel/AddressRepository.php#L243-L305
	 * @param Address $a
	 * @return InputException
	 */
	private function _validate(Address $a) {
		$result = new InputException(); /** @var InputException $result */
		if (!$a->getShouldIgnoreValidation()) {
			$fields = ['firstname', 'lastname', 'street', 'city', 'country_id']; /** @var string[] $fields */
			// 2016-04-05
			// Валидацию телефона не проводим,
			// потому что сюда мы попадаем только когда телефон необязателен.
			if (!in_array($a->getCountryId(), df_directory_h()->getCountriesWithOptionalZip())) {
				$fields[]= 'postcode';
			}
			if (df_directory_h()->isRegionRequired($a->getCountryId())) {
				$fields[]= 'region' . ($a->getCountryModel()->getRegionCollection()->count() ? '_id' : '');
			}
			array_map(function($field) use($a, $result) {
				if (!\Zend_Validate::is($a->getDataUsingMethod($field), 'NotEmpty')) {
					$result->addError(__(InputException::REQUIRED_FIELD, ['fieldName' => $field]));
				}
			}, $fields);
		}
		return $result;
	}
}