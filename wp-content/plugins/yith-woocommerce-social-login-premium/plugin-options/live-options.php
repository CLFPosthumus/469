<?php
/**
 * This file belongs to the YIT Plugin Framework.
 *
 * This source file is subject to the GNU GENERAL PUBLIC LICENSE (GPL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/licenses/gpl-3.0.txt
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly


return array(

	'live' => array(

		'social_networks_menu' => array(
			'id'   => 'ywsl_social_networks_menu',
			'type' => 'ywsl_social_networks_menu'
		),

		'section_live_settings' => array(
			'name' => __( 'Live settings', 'yith-woocommerce-social-login' ),
			'desc' => __( '<strong>Callback URL</strong>: ' . YITH_WC_Social_Login()->get_base_url() . ( get_option( 'ywsl_callback_url' ) == 'root' ? '/' : '' ) . 'live.php', 'yith-woocommerce-social-login' ),
			'type' => 'title',
			'id'   => 'ywsl_section_live'
		),

		'live_enable' => array(
			'name'    => __( 'Enable Live Login', 'yith-woocommerce-social-login' ),
			'desc'    => '',
			'id'      => 'ywsl_live_enable',
			'default' => 'no',
			'type'    => 'checkbox'
		),

		'live_key' => array(
			'name'    => __( 'Live Consumer Key', 'yith-woocommerce-social-login' ),
			'desc'    => '',
			'id'      => 'ywsl_live_key',
			'default' => '',
			'type'    => 'text'
		),

		'live_secret' => array(
			'name'    => __( 'Live Consumer Secret', 'yith-woocommerce-social-login' ),
			'desc'    => '',
			'id'      => 'ywsl_live_secret',
			'default' => '',
			'type'    => 'text'
		),

		'live_icon' => array(
			'name'    => __( 'Live Icon', 'yit' ),
			'desc'    => '',
			'id'      => 'ywsl_live_icon',
			'default' => '',
			'type'    => 'ywsl_upload'
		),

		'section_live_settings_end' => array(
			'type' => 'sectionend',
			'id'   => 'ywsl_section_live_end'
		),

	)
);