<?php defined( 'WPINC' ) || exit;

/**
 * Trait for simple products.
 *
 * @link       https://icopydoc.ru
 * @since      0.1.0
 * @version    4.5.0 (04-09-2026)
 *
 * @package    XFGMC
 * @subpackage XFGMC/includes/feeds/traits/simple
 */

/**
 * The trait adds `get_material` methods.
 * 
 * This method allows you to return the `material` tag.
 *
 * @since      0.1.0
 * @package    XFGMC
 * @subpackage XFGMC/includes/feeds/traits/simple
 * @author     Maxim Glazunov <icopydoc@gmail.com>
 * @depends    classes:     XFGMC_Get_Paired_Tag
 *             methods:     get_product
 *                          get_feed_id
 *             functions:   
 */
trait XFGMC_T_Simple_Get_Material {

	/**
	 * Get `material` tag.
	 * 
	 * @see https://support.google.com/merchants/answer/6324410
	 * 
	 * @param string $tag_name
	 * @param string $result_xml
	 * 
	 * @return string Example: `<g:material>Leather</g:material>`
	 */
	public function get_material( $tag_name = 'g:material', $result_xml = '' ) {

		$material = XFGMC_Options::settings_get(
			'xfgmc_material',
			'enabled',
			$this->get_feed_id(),
			'xfgmc'
		);
		if ( $material === 'disabled' ) {
			return $result_xml;
		} else { 
			$tag_value = $this->get_simple_global_attribute_value( $material );
			$result_xml = $this->get_simple_tag( $tag_name, $tag_value );
		}
		return $result_xml;

	}

}