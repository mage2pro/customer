<?php
namespace Dfe\Customer;
use Dfe\Customer\Settings\Address as SA;
use Magento\Framework\View\Element\AbstractBlock;
/**
 * 2016-04-01
 * @final Unable to use the PHP «final» keyword here because of the M2 code generation.
 */
class Block extends AbstractBlock {
	/**
	 * 2016-04-01
	 * @override
	 * @see AbstractBlock::_toHtml()
	 * @return string
	 */
	final protected function _toHtml() {return
		df_x_magento_init(__CLASS__, 'main', [
			'countries' => df_country_codes_allowed()
			,'telephone' => SA::s()->telephone()
			,'utils' => df_asset_create(df_asset_name(df_asset_third_party(
				'Telephone/js/utils.js'
			)))->getUrl()
		]) . df_link_inline(df_asset_name(df_asset_third_party('Telephone/css/main.css')))
	;}
}