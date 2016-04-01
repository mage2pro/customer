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
			'telephone' => SA::s()->telephone()
		]);
	}
}