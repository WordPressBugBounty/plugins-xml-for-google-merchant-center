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
 * The trait adds `get_pattern` methods.
 * 
 * This method allows you to return the `pattern` tag.
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
trait XFGMC_T_Variable_Get_Pattern {

	/**
	 * Get `pattern` tag.
	 * 
	 * @see https://support.google.com/merchants/answer/6324483
	 * 
	 * @param string $tag_name
	 * @param string $result_xml
	 * 
	 * @return string Example: `<g:pattern>Striped</g:pattern>`
	 */
	public function get_pattern( $tag_name = 'g:pattern', $result_xml = '' ) {

		$pattern = XFGMC_Options::settings_get(
			'xfgmc_pattern',
			'enabled',
			$this->get_feed_id(),
			'xfgmc'
		);
		if ( $pattern === 'disabled' ) {
			return $result_xml;
		} else { 
			$tag_value = $this->get_variable_global_attribute_value( $pattern );
			$result_xml = $this->get_variable_tag( $tag_name, $tag_value );
		}
		return $result_xml;

	}

}