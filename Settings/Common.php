<?php
namespace Dfe\Customer\Settings;
use Magento\Framework\App\ScopeInterface as S;
/** @method static Common s() */
class Common extends \Df\Core\Settings {
	/**
	 * @override
	 * @see \Df\Core\Settings::prefix()
	 * @used-by \Df\Core\Settings::v()
	 * @return string
	 */
	protected function prefix() {return 'dfe_customer/common/';}
}