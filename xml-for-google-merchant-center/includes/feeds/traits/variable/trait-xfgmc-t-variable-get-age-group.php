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
 * The trait adds `get_age` methods.
 * 
 * This method allows you to return the `age` tag.
 *
 * @since      0.1.0
 * @package    XFGMC
 * @subpackage XFGMC/includes/feeds/traits/variable
 * @author     Maxim Glazunov <icopydoc@gmail.com>
 * @depends    classes:     XFGMC_Get_Paired_Tag
 *             methods:     get_product
 *                          get_offer
 *                          get_feed_id
 *                          get_variable_product_post_meta
 *                          get_variable_tag
 *                          get_variable_global_attribute_value
 *             functions:    
 */
trait XFGMC_T_Variable_Get_Age_Group {

	/**
	 * Get `age` tag.
	 * 
	 * @see https://support.google.com/merchants/answer/6324463
	 * 
	 * @param string $tag_name
	 * @param string $result_xml
	 * 
	 * @return string Example: `<g:age_group>adult</g:age_group>`.
	 */
	public function get_age_group( $tag_name = 'g:age_group', $result_xml = '' ) {

		$age_group = XFGMC_Options::settings_get(
			'xfgmc_age_group',
			'disabled',
			$this->get_feed_id(),
			'xfgmc'
		);
		if ( $age_group === 'disabled' ) {
			return $result_xml;
		}

		switch ( $age_group ) {
			case 'post_meta':

				// из метаполя
				$age_group_post_meta = XFGMC_Options::settings_get(
					'xfgmc_age_group_post_meta',
					'',
					$this->get_feed_id(),
					'xfgmc'
				);
				if ( ! empty( $age_group_post_meta ) ) {
					$tag_value = $this->get_variable_product_post_meta( $age_group_post_meta, '' ); // ! '' - без префикса
				}

				break;
			case 'default_value':

				// из поля значение по умолчанию
				$age_group_post_meta = XFGMC_Options::settings_get(
					'xfgmc_age_group_post_meta',
					'',
					$this->get_feed_id(),
					'xfgmc'
				);
				if ( ! empty( $age_group_post_meta ) ) {
					$tag_value = $age_group_post_meta;
				}

				break;
			default:

				$tag_value = $this->get_variable_global_attribute_value( $age_group );
		}

		$result_xml = $this->get_variable_tag( $tag_name, $tag_value );
		return $result_xml;

	}

}