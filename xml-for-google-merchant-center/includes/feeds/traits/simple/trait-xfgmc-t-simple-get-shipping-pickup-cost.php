<?php defined( 'WPINC' ) || exit;

/**
 * Trait for simple products.
 *
 * @link       https://icopydoc.ru
 * @since      4.0.4
 * @version    4.5.0 (04-09-2026)
 *
 * @package    XFGMC
 * @subpackage XFGMC/includes/feeds/traits/simple
 */

/**
 * The trait adds `get_pickup_cost` method.
 * 
 * This method allows you to return the `pickup_cost` tag and nested tags.
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
trait XFGMC_T_Simple_Get_Shipping_Pickup_Cost {

	/**
	 * Get tags: `<g:pickup_cost>
	 * <g:pickup_cost_flat_rate> 3.00 USD </g:pickup_cost_flat_rate>
	 * <g:pick_cost_free_threshold> 20.00 USD </g:pickup_cost_free_threshold>
	 * </g:pickup_cost>`.
	 * 
	 * @see https://support.google.com/merchants/answer/16988704?sjid=660349729224591551-EU
	 * 
	 * @param string $tag_name
	 * @param string $result_xml
	 * 
	 * @return string Example: `<g:pickup_cost>...</g:pickup_cost>`
	 */
	public function get_pickup_cost( $tag_name = 'pickup_cost', $result_xml = '' ) {

		$pickup_cost = XFGMC_Options::settings_get(
			'xfgmc_pickup_cost',
			'disabled',
			$this->get_feed_id(),
			'xfgmc'
		);

		if ( $pickup_cost === 'disabled' ) {
			return $result_xml;
		}

		$pickup_cost_flat_rate = XFGMC_Options::settings_get(
			'xfgmc_pickup_cost_flat_rate',
			'',
			$this->get_feed_id(),
			'xfgmc'
		);
		$pick_cost_free_threshold = XFGMC_Options::settings_get(
			'xfgmc_pick_cost_free_threshold',
			'',
			$this->get_feed_id(),
			'xfgmc'
		);
		if ( empty( $pickup_cost_flat_rate ) && empty( $pick_cost_free_threshold ) ) {
			return $result_xml;
		}
		$default_currency = XFGMC_Options::settings_get(
			'xfgmc_default_currency',
			'USD',
			$this->get_feed_id(),
			'xfgmc'
		);
		$pickup_cost_flat_rate_value = number_format( (float) $pickup_cost_flat_rate, wc_get_price_decimals(), '.', '' );
		$pick_cost_free_threshold_value = number_format( (float) $pick_cost_free_threshold, wc_get_price_decimals(), '.', '' );

		$result_xml .= new XFGMC_Get_Open_Tag( 'g:pickup_cost' );
		if ( $pickup_cost_flat_rate_value > 0 ) {
			$result_xml .= new XFGMC_Get_Paired_Tag( 'g:pickup_cost_flat_rate', sprintf( '%s %s', $pickup_cost_flat_rate_value, $default_currency ) );
		}
		if ( $pick_cost_free_threshold_value > 0 ) {
			$result_xml .= new XFGMC_Get_Paired_Tag( 'g:pick_cost_free_threshold', sprintf( '%s %s', $pick_cost_free_threshold_value, $default_currency ) );
		}
		$result_xml .= new XFGMC_Get_Closed_Tag( 'g:pickup_cost' );

		$result_xml = apply_filters(
			'xfgmc_f_simple_tag_pickup_cost',
			$result_xml,
			[
				'product' => $this->get_product()
			],
			$this->get_feed_id()
		);
		return $result_xml;

	}

}