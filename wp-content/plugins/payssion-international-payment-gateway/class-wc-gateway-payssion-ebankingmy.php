<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once( 'class-wc-gateway-payssion.php' );

/**
 * Payssion 
 *
 * @class 		WC_Gateway_Payssion_Ebankingmy
 * @extends		WC_Payment_Gateway
 * @author 		Payssion
 */
class WC_Gateway_Payssion_Ebankingmy extends WC_Gateway_Payssion {
	public $title = 'Malaysia e-banking';
	protected $pm_id = 'ebanking_my';
}