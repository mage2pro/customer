<?php
namespace Dfe\Customer\Settings;
use Magento\Framework\App\ScopeInterface;
class Common extends \Df\Core\Settings {
	/**
	 * 2016-04-01
	 * «Mage2.PRO» → «Customer» → «Common» → «Enable?»
	 * @param null|string|int|ScopeInterface $scope [optional]
	 * @return bool
	 */
	public function enable($scope = null) {return $this->b(__FUNCTION__, $scope);}

	/**
	 * @override
	 * @used-by \Df\Core\Settings::v()
	 * @return string
	 */
	protected function prefix() {return 'dfe_customer/common/';}

	/** @return self */
	public static function s() {static $r; return $r ? $r : $r = df_o(__CLASS__);}
}