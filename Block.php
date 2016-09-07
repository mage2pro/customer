<?php
namespace Dfe\Customer;
use Dfe\Customer\Settings\Address as SA;
use Magento\Framework\View\Element\AbstractBlock;
class Block extends AbstractBlock {
	/**
	 * 2016-04-01
	 * @override
	 * @see AbstractBlock::_toHtml()
	 * @return string
	 */
	protected function _toHtml() {
		return df_x_magento_init('Dfe_Customer/main', [
			'countries' => df_country_codes_allowed()
			,'telephone' => SA::s()->telephone()
			,'utils' => df_asset_create(df_asset_name(df_asset_third_party(
				'Telephone/js/utils.js'
			)))->getUrl()
		]) . df_link_inline(df_asset_name(df_asset_third_party('Telephone/css/main.css')));
	}
}