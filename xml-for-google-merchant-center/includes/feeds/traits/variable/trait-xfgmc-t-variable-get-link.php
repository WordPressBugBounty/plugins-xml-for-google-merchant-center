<?php defined( 'WPINC' ) || exit;

/**
 * Trait for variable products.
 *
 * @link       https://icopydoc.ru
 * @since      0.1.0
 * @version    4.5.0 (04-09-2026)
 *
 * @package    XFGMC
 * @subpackage XFGMC/includes/feeds/traits/variable
 */

/**
 * The trait adds `get_link` method.
 * 
 * This method allows you to return the `link` tag.
 *
 * @since      0.1.0
 * @package    XFGMC
 * @subpackage XFGMC/includes/feeds/traits/variable
 * @author     Maxim Glazunov <icopydoc@gmail.com>
 * @depends    classes:     XFGMC_Get_Paired_Tag
 *             methods:     get_product
 *                          get_offer
 *                          get_feed_id
 *             functions:   
 */
trait XFGMC_T_Variable_Get_Link {

	/**
	 * Get `link` tag.
	 * 
	 * @see https://support.google.com/merchants/answer/6324416
	 * 
	 * @param string $tag_name
	 * @param string $result_xml
	 * 
	 * @return string Example: `<g:link]>http://best.seller.ru/product_page.asp?pid=12346</g:link]>`.
	 */
	public function get_link( $tag_name = 'g:link', $result_xml = '' ) {

		$link = XFGMC_Options::settings_get(
			'xfgmc_link',
			'enabled',
			$this->get_feed_id(),
			'xfgmc'
		);

		if ( $link === 'disabled' ) {
			return $result_xml;
		}

		$tag_value = htmlspecialchars( get_permalink( $this->get_offer()->get_id() ) );
		$clear_get = XFGMC_Options::settings_get(
			'xfgmc_clear_get',
			'disabled',
			$this->get_feed_id(),
			'xfgmc'
		);
		if ( $clear_get === 'enabled' ) {
			$tag_value = get_from_url( $tag_value, 'url' );
		}

		// ? это избавляет от двойного кодирования, но отдука она пока хз 
		// ? @see https://wordpress.org/support/topic/работает-отлично-после-небольшой-дор/
		$tag_value = urldecode( $tag_value );

		$result_xml = $this->get_variable_tag( $tag_name, $tag_value );
		$result_xml = xfgmc_replace_domain( $result_xml, $this->get_feed_id() );

		return $result_xml;

	}

}