<?php
namespace Dfe\Customer;
use Dfe\Customer\Settings\Address as SA;
use Magento\Framework\View\Element\AbstractBlock as _P;
// 2016-04-01
/** @final Unable to use the PHP «final» keyword here because of the M2 code generation. */
class Block extends _P {
	/**
	 * 2016-04-01
	 * @override
	 * @see _P::_toHtml()
	 * @used-by _P::toHtml():
	 *		$html = $this->_loadCache();
	 *		if ($html === false) {
	 *			if ($this->hasData('translate_inline')) {
	 *				$this->inlineTranslation->suspend($this->getData('translate_inline'));
	 *			}
	 *			$this->_beforeToHtml();
	 *			$html = $this->_toHtml();
	 *			$this->_saveCache($html);
	 *			if ($this->hasData('translate_inline')) {
	 *				$this->inlineTranslation->resume();
	 *			}
	 *		}
	 *		$html = $this->_afterToHtml($html);
	 * https://github.com/magento/magento2/blob/2.2.0-RC1.6/lib/internal/Magento/Framework/View/Element/AbstractBlock.php#L642-L683
	 * @return string
	 */
	final protected function _toHtml() {return df_js(__CLASS__, 'main', [
		'countries' => df_country_codes_allowed()
		,'telephone' => SA::s()->telephone()
		,'utils' => df_asset_create(df_asset_name(df_asset_third_party('Telephone/js/utils.js')))->getUrl()
	]) . df_link_inline(df_asset_name(df_asset_third_party('Telephone/css/main.css')));}
}