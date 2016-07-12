<?php
namespace Dfe\Customer\Settings;
use Magento\Framework\App\ScopeInterface as S;
/** @method static Common s() */
class Common extends \Df\Core\Settings {
	/**
	 * 2016-04-01
	 * «Mage2.PRO» → «Customer» → «Common» → «Enable?»
	 * @param null|string|int|S $scope [optional]
	 * @return bool
	 */
	public function enable($scope = null) {return $this->b(__FUNCTION__, $scope);}

	/**
	 * @override
	 * @used-by \Df\Core\Settings::v()
	 * @return string
	 */
	protected function prefix() {return 'dfe_customer/common/';}
}