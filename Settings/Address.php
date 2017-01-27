<?php
namespace Dfe\Customer\Settings;
use Dfe\Customer\Settings\Common as SC;
use Magento\Framework\App\ScopeInterface as S;
/** @method static Address s() */
final class Address extends \Df\Config\Settings {
	/**
	 * 2016-04-04
	 * «Mage2.PRO» → «Customer» → «Address» → «Telephone»
	 * @see \Magento\Config\Model\Config\Source\Nooptreq
	 * @param null|string|int|S $scope [optional]
	 * @return bool
	 */
	public function isTelephoneRequired($scope = null) {
		return !SC::s()->enable($scope) || 'req' === $this->telephone($scope);
	}

	/**
	 * 2016-04-01
	 * «Mage2.PRO» → «Customer» → «Address» → «Telephone»
	 * @see \Magento\Config\Model\Config\Source\Nooptreq
	 * @param null|string|int|S $scope [optional]
	 * @return string
	 */
	public function telephone($scope = null) {return $this->v(null, $scope);}

	/**
	 * @override
	 * @see \Df\Config\Settings::prefix()
	 * @used-by \Df\Config\Settings::v()
	 * @return string
	 */
	protected function prefix() {return 'dfe_customer/address';}
}