<?php
namespace Dfe\Customer\Settings;
use Dfe\Customer\Settings\Common as SC;
use Magento\Framework\App\ScopeInterface;
class Address extends \Df\Core\Settings {
	/**
	 * 2016-04-04
	 * «Mage2.PRO» → «Customer» → «Address» → «Telephone»
	 * @see \Magento\Config\Model\Config\Source\Nooptreq
	 * @param null|string|int|ScopeInterface $scope [optional]
	 * @return bool
	 */
	public function isTelephoneRequired($scope = null) {
		return !SC::s()->enable($scope) || 'req' === $this->telephone($scope);
	}

	/**
	 * 2016-04-01
	 * «Mage2.PRO» → «Customer» → «Address» → «Telephone»
	 * @see \Magento\Config\Model\Config\Source\Nooptreq
	 * @param null|string|int|ScopeInterface $scope [optional]
	 * @return string
	 */
	public function telephone($scope = null) {return $this->v(__FUNCTION__, $scope);}

	/**
	 * @override
	 * @used-by \Df\Core\Settings::v()
	 * @return string
	 */
	protected function prefix() {return 'dfe_customer/address/';}

	/** @return self */
	public static function s() {static $r; return $r ? $r : $r = df_o(__CLASS__);}
}