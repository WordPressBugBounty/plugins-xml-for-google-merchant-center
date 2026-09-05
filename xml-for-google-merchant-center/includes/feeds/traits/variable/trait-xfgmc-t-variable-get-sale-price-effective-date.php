<?php defined( 'WPINC' ) || exit;

/**
 * Trait for variable products.
 *
 * @link       https://icopydoc.ru
 * @since      4.4.0
 * @version    4.5.0 (04-09-2026)
 *
 * @package    XFGMC
 * @subpackage XFGMC/includes/feeds/traits/variable
 */

/**
 * The trait adds `get_sale_price_effective_date` method.
 * 
 * This method allows you to return the `sale_price_effective_date` tag.
 *
 * @since      4.4.0
 * @package    XFGMC
 * @subpackage XFGMC/includes/feeds/traits/variable
 * @author     Maxim Glazunov <icopydoc@gmail.com>
 * @depends    classes:     XFGMC_Get_Paired_Tag
 *             methods:     get_product
 *                          get_offer
 *                          get_feed_id
 *             functions:   
 */
trait XFGMC_T_Variable_Get_Sale_Price_Effective_Date {

	/**
	 * Get `sale_price_effective_date` tag.
	 * 
	 * @see https://support.google.com/merchants/answer/6324460
	 * 
	 * @param string $tag_name
	 * @param string $result_xml
	 * 
	 * @return string Example: `<g:sale_price_effective_date>2016-02-24T13:00-0800/2016-02-29T15:30-0800</g:sale_price_effective_date>`.
	 */
	public function get_sale_price_effective_date( $tag_name = 'g:sale_price_effective_date', $result_xml = '' ) {

		$tag_value = '';
		$use_sale_price_effective_date = XFGMC_Options::settings_get(
			'xfgmc_use_sale_price_effective_date',
			'disabled',
			$this->get_feed_id(),
			'xfgmc'
		);
		if ( $use_sale_price_effective_date === 'disabled' ) {
			return $result_xml;
		}

		if ( $use_sale_price_effective_date === 'enabled_default_value' ) {
			$sale_price_effective_date = XFGMC_Options::settings_get(
				'xfgmc_sale_price_effective_date',
				'',
				$this->get_feed_id(),
				'xfgmc'
			);
			if ( ! empty( $sale_price_effective_date ) ) {
				$tag_value = $sale_price_effective_date;
			}
		}

		if ( $use_sale_price_effective_date === 'enabled' ) {
			$add_to_availability = (int) XFGMC_Options::settings_get(
				'xfgmc_add_to_availability',
				'0',
				$this->get_feed_id(),
				'xfgmc'
			);
			// Получаем текущую дату + $add_to_availability дня в объекте DateTime, с учётом часового пояса WordPress
			$date = new DateTime( 'now', wp_timezone() );
			$date->modify( sprintf( '+%s days', $add_to_availability ) );
			// Формируем строку в нужном формате: Y-m-d\TH:iP (без секунд, смещение без разделителя)
			$tag_value = $date->format( 'Y-m-d\TH:iP' ); // ISO 8601 $date->format('c')
		}

		$tag_value = apply_filters(
			'x4gmc_f_variable_tag_value_sale_price_effective_date',
			$tag_value,
			[
				'product' => $this->get_product(),
				'offer' => $this->get_offer()
			],
			$this->get_feed_id()
		);
		if ( ! empty( $tag_value ) ) {
			$tag_name = apply_filters(
				'x4gmc_f_variable_tag_name_sale_price_effective_date',
				$tag_name,
				[
					'product' => $this->get_product(),
					'offer' => $this->get_offer()
				],
				$this->get_feed_id()
			);
			$result_xml = new XFGMC_Get_Paired_Tag( $tag_name, $tag_value );
		}

		$result_xml = apply_filters(
			'x4gmc_f_variable_tag_sale_price_effective_date',
			$result_xml,
			[
				'product' => $this->get_product(),
				'offer' => $this->get_offer()
			],
			$this->get_feed_id()
		);
		return $result_xml;

	}

}