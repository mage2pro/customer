<?php
namespace Dfe\Customer\Settings;
/** @method static Common s() */
final class Common extends \Df\Config\Settings {
	/**
	 * @override
	 * @see \Df\Config\Settings::prefix()
	 * @used-by \Df\Config\Settings::v()
	 * @return string
	 */
	protected function prefix() {return 'dfe_customer/common';}
}