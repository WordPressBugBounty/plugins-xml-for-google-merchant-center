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
 * The trait adds `get_condition` methods.
 * 
 * This method allows you to return the `condition` tag.
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
trait XFGMC_T_Variable_Get_Condition {

	/**
	 * Get `condition` tag.
	 * 
	 * @see https://support.google.com/merchants/answer/6324469
	 * 
	 * @param string $tag_name
	 * @param string $result_xml
	 * 
	 * @return string Example: `<g:condition>used</g:condition>`.
	 */
	public function get_condition( $tag_name = 'g:condition', $result_xml = '' ) {

		$condition = XFGMC_Options::settings_get(
			'xfgmc_condition',
			'disabled',
			$this->get_feed_id(),
			'xfgmc'
		);
		if ( $condition === 'disabled' ) {
			return $result_xml;
		} else {
			$tag_value = $this->get_variable_product_post_meta( 'condition' );
			if ( $tag_value === 'disabled' ) {
				return $result_xml;
			}
			if ( empty( $tag_value ) || $tag_value === 'default' ) {
				$condition_default_value = XFGMC_Options::settings_get(
					'xfgmc_condition_default_value',
					'disabled',
					$this->get_feed_id(),
					'xfgmc'
				);
				if ( $condition_default_value !== 'disabled' ) {
					$tag_value = $condition_default_value;
				}
			}
			$result_xml = $this->get_variable_tag( $tag_name, $tag_value );
		}
		return $result_xml;

	}

}