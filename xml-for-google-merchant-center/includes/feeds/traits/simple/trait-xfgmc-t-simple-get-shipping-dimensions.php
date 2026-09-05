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
 * The trait adds `get_shipping_dimensions` method.
 * 
 * This method allows you to return the `shipping_dimensions` tag.
 *
 * @since      0.1.0
 * @package    XFGMC
 * @subpackage XFGMC/includes/feeds/traits/simple
 * @author     Maxim Glazunov <icopydoc@gmail.com>
 * @depends    classes:     XFGMC_Get_Paired_Tag
 *             methods:     get_product
 *                          get_product
 *                          get_feed_id
 *             functions:   
 */
trait XFGMC_T_Simple_Get_Shipping_Dimensions {

	/**
	 * Get `dimensions` tag or `<g:shipping_length>20 in</g:shipping_length>`, `<g:shipping_width>40 in</g:shipping_width>`,
	 * `<g:shipping_height>10 in</g:shipping_height>`, `<g:shipping_weight>3.5 lb</g:shipping_weight>`.
	 * 
	 * @see https://support.google.com/merchants/answer/6324498
	 *      https://support.google.com/merchants/answer/6324503
	 * 
	 * @param string $tag_name
	 * @param string $result_xml
	 * 
	 * @return string Example: `<g:shipping_length>20 in</g:shipping_length>`
	 */
	public function get_shipping_dimensions( $tag_name = 'shipping_dimensions', $result_xml = '' ) {

		// * к сожалению wc_get_dimension не всегда возвращает float и юзер может передать в размер что-то типа '13-18'
		$shipping_length_value = 0;
		$shipping_width_value = 0;
		$shipping_height_value = 0;
		$shipping_weight_value = 0;
		$shipping_length_source = XFGMC_Options::settings_get(
			'xfgmc_shipping_length',
			'woo_shippings',
			$this->get_feed_id(),
			'xfgmc'
		);
		if ( empty( $shipping_length_source ) || $shipping_length_source === 'woo_shippings' ) {
			if ( $this->get_product()->has_dimensions() ) {
				$shipping_length_value = $this->get_product()->get_length();
				if ( ! empty( $shipping_length_value ) && get_option( 'woocommerce_dimension_unit' ) !== 'cm' ) {
					$shipping_length_value = round( wc_get_dimension( $shipping_length_value, 'cm' ), 3 );
				}
			}
		} else {
			$shipping_length_source = (int) $shipping_length_source;
			$tag_value = $this->get_product()->get_attribute( wc_attribute_taxonomy_name_by_id( $shipping_length_source ) );
			$shipping_length_value = round( wc_get_dimension( (float) $tag_value, 'cm' ), 3 );
		}

		$shipping_width_source = XFGMC_Options::settings_get(
			'xfgmc_shipping_width',
			'woo_shippings',
			$this->get_feed_id(),
			'xfgmc'
		);
		if ( empty( $shipping_width_source ) || $shipping_width_source === 'woo_shippings' ) {
			if ( $this->get_product()->has_dimensions() ) {
				$shipping_width_value = $this->get_product()->get_width();
				if ( ! empty( $shipping_width_value ) && get_option( 'woocommerce_dimension_unit' ) !== 'cm' ) {
					$shipping_width_value = round( wc_get_dimension( $shipping_width_value, 'cm' ), 3 );
				}
			}
		} else {
			$shipping_width_source = (int) $shipping_width_source;
			$tag_value = $this->get_product()->get_attribute( wc_attribute_taxonomy_name_by_id( $shipping_width_source ) );
			$shipping_width_value = round( wc_get_dimension( (float) $tag_value, 'cm' ), 3 );
		}

		$shipping_height_source = XFGMC_Options::settings_get(
			'xfgmc_shipping_height',
			'woo_shippings',
			$this->get_feed_id(),
			'xfgmc'
		);
		if ( empty( $shipping_height_source ) || $shipping_height_source === 'woo_shippings' ) {
			if ( $this->get_product()->has_dimensions() ) {
				$shipping_height_value = $this->get_product()->get_height();
				if ( ! empty( $shipping_height_value ) && get_option( 'woocommerce_dimension_unit' ) !== 'cm' ) {
					$shipping_height_value = round( wc_get_dimension( $shipping_height_value, 'cm' ), 3 );
				}
			}
		} else {
			$shipping_height_source = (int) $shipping_height_source;
			$tag_value = $this->get_product()->get_attribute( wc_attribute_taxonomy_name_by_id( $shipping_height_source ) );
			$shipping_height_value = round( wc_get_dimension( (float) $tag_value, 'cm' ), 3 );
		}

		$shipping_weight_source = XFGMC_Options::settings_get(
			'xfgmc_shipping_weight',
			'woo_shippings',
			$this->get_feed_id(),
			'xfgmc'
		);
		if ( empty( $shipping_weight_source ) || $shipping_weight_source === 'woo_shippings' ) {
			$shipping_weight_value = $this->get_product()->get_weight();
			if ( ! empty( $shipping_weight_value ) && get_option( 'woocommerce_weight_unit' ) !== 'kg' ) {
				$shipping_weight_value = round( wc_get_weight( $shipping_weight_value, 'kg' ), 3 );
			}
		} else {
			$shipping_weight_source = (int) $shipping_weight_source;
			$tag_value = $this->get_product()->get_attribute( wc_attribute_taxonomy_name_by_id( $shipping_weight_source ) );
			$shipping_weight_value = round( wc_get_weight( (float) $tag_value, 'kg' ), 3 );
		}

		if ( $shipping_length_value > 0 ) {
			$result_xml .= new XFGMC_Get_Paired_Tag( 'g:shipping_length', sprintf( '%s cm', $shipping_length_value ) );
		}
		if ( $shipping_width_value > 0 ) {
			$result_xml .= new XFGMC_Get_Paired_Tag( 'g:shipping_width', sprintf( '%s cm', $shipping_width_value ) );
		}
		if ( $shipping_height_value > 0 ) {
			$result_xml .= new XFGMC_Get_Paired_Tag( 'g:shipping_height', sprintf( '%s cm', $shipping_height_value ) );
		}
		if ( $shipping_weight_value > 0 ) {
			$result_xml .= new XFGMC_Get_Paired_Tag( 'g:shipping_weight', sprintf( '%s kg', $shipping_weight_value ) );
		}

		$result_xml = apply_filters(
			'xfgmc_f_simple_tag_dimensions',
			$result_xml,
			[
				'product' => $this->get_product()
			],
			$this->get_feed_id()
		);
		return $result_xml;

	}

}