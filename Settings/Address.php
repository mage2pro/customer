<?php
namespace Dfe\Customer\Settings;
use Dfe\Customer\Settings\Common as SC;
use Magento\Framework\App\ScopeInterface as S;
/** @method static Address s() */
final class Address extends \Df\Config\Settings {
	/**
	 * 2016-04-04 «Mage2.PRO» → «Customer» → «Address» → «Telephone»
	 * @see \Magento\Config\Model\Config\Source\Nooptreq
	 * @param null|string|int|S $s [optional]
	 * @return bool
	 */
	function isTelephoneRequired($s = null) {return !SC::s()->enable($s) || 'req' === $this->telephone($s);}

	/**
	 * 2016-04-01 «Mage2.PRO» → «Customer» → «Address» → «Telephone»
	 * @see \Magento\Config\Model\Config\Source\Nooptreq
	 * @param null|string|int|S $s [optional]
	 * @return string
	 */
	function telephone($s = null) {return $this->v(null, $s);}

	/**
	 * @override
	 * @see \Df\Config\Settings::prefix()
	 * @used-by \Df\Config\Settings::v()
	 */
	protected function prefix():string {return 'dfe_customer/address';}
}