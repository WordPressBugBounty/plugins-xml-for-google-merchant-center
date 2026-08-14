<?php defined( 'WPINC' ) || exit;

/**
 * Trait for variable products.
 *
 * @link       https://icopydoc.ru
 * @since      4.4.0
 * @version    4.4.0 (14-08-2026)
 *
 * @package    XFGMC
 * @subpackage XFGMC/includes/feeds/traits/variable
 */

/**
 * The trait adds `get_pickup_sla` method.
 * 
 * This method allows you to return the `pickup_sla` tag.
 *
 * @since      4.4.0
 * @package    XFGMC
 * @subpackage XFGMC/includes/feeds/traits/variable
 * @author     Maxim Glazunov <icopydoc@gmail.com>
 * @depends    classes:     XFGMC_Get_Paired_Tag
 *                          XFGMC_Options
 *             methods:     get_product
 *                          get_offer
 *                          get_feed_id
 *             functions:   
 */
trait XFGMC_T_Variable_Get_Pickup_Sla {

	/**
	 * Get `pickup_sla` tag.
	 * 
	 * @see https://support.google.com/merchants/answer/14635400?sjid=660349729224591551-EU
	 * 
	 * @param string $tag_name
	 * @param string $result_xml
	 * 
	 * @return string Example: `<g:pickup_sla>multi-week</g:pickup_sla>`.
	 */
	public function get_pickup_sla( $tag_name = 'g:pickup_sla', $result_xml = '' ) {

		$pickup_sla = common_option_get(
			'xfgmc_pickup_sla',
			'disabled',
			$this->get_feed_id(),
			'xfgmc'
		);
		if ( $pickup_sla === 'disabled' ) {
			return $result_xml;
		}

	 	$result_xml = $this->get_variable_tag( $tag_name, $pickup_sla );
		return $result_xml;

	}

}