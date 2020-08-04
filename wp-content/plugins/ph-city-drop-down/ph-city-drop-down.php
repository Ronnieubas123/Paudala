<?php
/*
Plugin Name: City Drop-Down
Description: This plugin will add City Field as a drop-down on the checkout page for a specific country and will let you re-arrange the checkout address fields.
Version: 1.0.7
Author: PluginHive
Author URI: https://www.pluginhive.com/about/
Text Domain: ph-city-drop-down
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit; 
}   

//check if woocommerce exists
if ( !class_exists( 'woocommerce' ) ) {   
	add_action( 'admin_init', 'ph_city_drop_down_plugin_deactivate' );
	if ( ! function_exists( 'ph_city_drop_down_plugin_deactivate' ) ) {
		function ph_city_drop_down_plugin_deactivate() {
			if ( !class_exists( 'woocommerce' ) ){
				deactivate_plugins( plugin_basename( __FILE__ ) );
				wp_safe_redirect( admin_url('plugins.php') );

			}
		}
	}
}

function shipping_select_city() {

	if ( ! class_exists( 'Shipping_Select_City' ) ) {

		class Shipping_Select_City extends WC_Shipping_Method {

		/**
		 * Constructor for your shipping class
		 *
		 * @access public
		 * @return void
		 */
		public function __construct() {
			$this->id                 = 'ph_city_drop_down'; 
			$this->method_title       = __( 'City As Drop-Down List', 'ph-city-drop-down' );  
			$this->method_description = __( 'Add city names to be displayed as drop-down during customer check-out<br/><br/><b>Note: </b><i>City Field will be changed to a drop-down in both billing and shipping address.</i>', 'ph-city-drop-down' ); 

			$this->init();

			$this->title 	= __( 'City Selection', 'ph-city-drop-down' );
			$this->enabled 	= isset( $this->settings['enabled'] ) ? $this->settings['enabled'] : 'yes';
			$this->state_and_cities = !empty($this->settings[ 'state_and_cities'])?$this->settings[ 'state_and_cities'] : array();

			$this->custom_fields 	= ( isset($this->settings[ 'checkout_priority']) && !empty($this->settings[ 'checkout_priority']) ) ? $this->settings[ 'checkout_priority']: array();

		}


		/**
		 * Init your settings
		 *
		 * @access public
		 * @return void
		 */

		function init() {
			
			// Load the settings API
			$this->init_form_fields(); 
			$this->init_settings(); 

			add_action( 'admin_enqueue_scripts', array($this,'ph_admin_enqueue'));

			// Save settings in admin if you have any defined
			add_action( 'woocommerce_update_options_shipping_' . $this->id, array( $this, 'process_admin_options' ) );
		}

		/**
		 * Define settings field for this shipping
		 * @return void 
		 */
		function init_form_fields() { 
			$this->sellingAllowedCountry = get_option('woocommerce_allowed_countries');
			$country_codes = get_option( 'woocommerce_specific_allowed_countries', array() );

			if((count($country_codes)==1) && ($this->sellingAllowedCountry =='specific')){

				$this->country_code = $country_codes[0];

				$this->fullCountry = WC()->countries->countries[ $this->country_code ];   

				$this->form_fields = array(

					'enabled' => array(
						'title' => __( 'Enable', 'ph-city-drop-down' ),
						'type' => 'checkbox',
						'description' => __( 'Enable to display city field as drop-down in the checkout page', 'ph-city-drop-down' ),
						'default' => 'yes'
					),

					'shipment_Country' => array(
						'type' => 'country',
						'description' => __( 'If empty - Please change ', 'ph-city-drop-down' ),
						'desc_tip' => true,
					),

					'state_and_cities' => array(
						'id' => 'shipment_state_and_cities',
						'type' => 'stateAndCities',
					),

					'checkout_priority' => array(
						'id' => 'woocommerce_checkout_priority',
						'type' => 'checkout_priority',
					),
				);
			}
			else {

				$this->form_fields = array(
					'title' => array(
						'type'	=> 'title',
						'title' => __( 'Please Select a Single Specific Country To Enable City Drop-Down Settings', 'ph-city-drop-down' ),
					),

					'checkout_priority' => array(
						'id' => 'woocommerce_checkout_priority',
						'type' => 'checkout_priority',
					),
				);
			}
		} 

		public function generate_country_html(){
			ob_start();
			?>

			<tr>
				<th>
					Country
				</th>
				<td>
					<label><?php echo $this->fullCountry;?></label>
				</td>
			</tr>

			<?php
			return ob_get_clean();
		}

		function checkSelectedState($currentState,$selectedState) {
			if($currentState == $selectedState) {
				return "selected";
			}
			else
				return "";
		}

		public function generate_stateAndCities_html(){
			ob_start();


			if(isset($this->country_code) && ($this->sellingAllowedCountry =='specific')){
				$countries = new WC_Countries();
				$this->states = $countries->get_states($this->country_code);
			}

			$tool_tip_icon = plugins_url("woocommerce/assets/images/help.png");
			?>
			<style>
				/*Style for tooltip*/
				.ph-tooltip { position: relative; top: 4px; }
				.ph-tooltip .ph-tooltiptext { visibility: hidden; width: 150px; background-color: #333; color: #fff; text-align: center; border-radius: 3px; padding: .618em 1em; font-size: .8em;
					/* Position the tooltip */
					position: absolute; z-index: 1;}
					.ph-tooltip:hover .ph-tooltiptext {visibility: visible;}
					/*End of tooltip styling*/
				</style>

				<table id="state_and_cities_table" class="wp-list-table widefat fixed posts">
					<thead>
						<tr>
							<th class="check-column" style="padding: 0px; vertical-align: middle;"><input type="checkbox" /></th>
							<th>
								<?php
								_e( 'State', 'ph-city-drop-down' );
								echo '<span class="ph-tooltip"><img src="'.$tool_tip_icon.'" height="16" width="16" /><span class="ph-tooltiptext">Creating multiple rules for same State is not recommended. Only the rule which is configured first will be saved.</span></span>';
								?>
							</th>
							<th>
								<?php
								_e('Cities', 'ph-city-drop-down'); 
								echo '<span class="ph-tooltip"><img src="'.$tool_tip_icon.'" height="16" width="16" /><span class="ph-tooltiptext">Enter the cities corresponding to the state. Each of them separated by a comma(,). Eg: Los Angeles, Bakersfield.</span></span>';
								?>
							</th>
						</tr>
					</thead>
					<tbody>
						<form action="" method="post">
							<?php

							$this->state_and_cities_table           = !empty($this->settings[ 'state_and_cities'])?$this->settings[ 'state_and_cities']: array();

							foreach ( $this->state_and_cities_table as $key => $value ){
								?>
								<tr>
									<td class="check-column" style="padding: 9px; vertical-align: middle;">
										<input type="checkbox" />
									</td>
									<td>
										<?php if( isset($this->states)&& !empty($this->states)&&($this->sellingAllowedCountry =='specific')){ ?>
											<select name="shipment_state[<?php echo $key; ?>]">

												<?php foreach ($this->states as $statecode=>$state) { ?>
													<option value="<?php echo $statecode;?>" <?php echo $this->checkSelectedState($statecode,$value['shipment_state'] )?>><?php echo $state;?></option>
												<?php } ?>
											</select>
											<?php
										} 
										else { ?>
											<input type="text" size="50" placeholder="Eg: California" name="shipment_state[<?php echo $key; ?>]" value="<?php echo isset( $value['shipment_state'] ) ? $value['shipment_state'] : ''; ?>"/>
										<?php }?>

									</td>
									<td >
										<input type="text" name="shipment_cities[<?php echo $key; ?>]" value="<?php echo isset( $value['shipment_cities']) ? $value['shipment_cities'] : ''; ?>"/>
									</td>

									</tr><?php
								}?>
							</form>
						</tbody>
						<tfoot>
							<tr>
								<th colspan="3">
									<a href="#" class="button plus insert"><?php _e( 'Add New State', 'ph-city-drop-down' ); ?></a>
									<a href="#" class="button minus remove"><?php _e( 'Remove State(s)', 'ph-city-drop-down' ); ?></a>
								</th>
							</tr>
						</tfoot>
					</table>

					<?php 
					return ob_get_clean();
				}

				public function validate_stateAndCities_field( $key =array() ) {

					$stateAndCities     = array();
					$shipment_state     = array_unique( isset( $_POST['shipment_state'] ) ? $_POST['shipment_state'] : array());
					$shipment_cities    = isset( $_POST['shipment_cities'] ) ? $_POST['shipment_cities'] : array();

					if(!empty( array_keys( $shipment_state ))){
						for ( $i = 0; $i <= max( array_keys( $shipment_state ) ); $i ++ ) {

							if ( empty($shipment_state[$i]) )
							{
								continue;
							}

							$stateAndCities[] = array(
								'shipment_state'            => $shipment_state[$i],
								'shipment_cities'           => $shipment_cities[$i],
							);
						}
					}

					return $stateAndCities;

				}

				public function generate_checkout_priority_html() {

					ob_start();
					?>
					<style type="text/css">
						
						.checkout_priority
						{
							width: 25%;
							margin: 30px 0px;
							text-align: center;
							border-spacing: 10px;
						}

						.checkout_priority th
						{
							text-align: center;
							font-weight: bold;
						}
						.checkout_priority td.sort
						{
							padding: 10px;
							cursor: move;
							background-color: #FAFAFA;
							border: 1px solid #CCC;
						}
						.checkout_priority td.sort:hover
						{
							border-color: #555;
							box-shadow: 3px 7px 5px #888888;
						}
						.unsort
						{
							padding: 10px;
							cursor: no-drop;
							background-color: #FAFAFA;
							border: 1px solid #CCC;
						}
					</style>
					<br/>
					<hr/>
					<table class="checkout_priority widefat">
						<h2>Reorder Checkout Address Fields</h2>
						<p>Drag and Drop the Address Fields to re-arrange.</p>
						<thead>
							
							<th class="sort"><?php _e( 'ADDRESS FIELDS', 'ph-city-drop-down' ); ?></th>

						</thead>

						<tbody>
							<?php
							$sort = 0;
							$this->ordered_fields = array();

							$this->fields = array(
								//"10"	=>	"First Name",
								//"20"	=>	"Last Name",
								"30"	=>	"Company Name",
								"40" 	=>	"Country",
								"50"	=>	"Address Line 1",
								"60"	=>	"Address Line 2",
								"70"	=>	"City",
								"80"	=>	"State",
								"90"	=>	"Post Code",
							);

							$this->custom_fields 	= ( isset($this->settings[ 'checkout_priority']) && !empty($this->settings[ 'checkout_priority']) ) ? $this->settings[ 'checkout_priority']: array();

							foreach ( $this->fields as $priority => $name ) {

								if ( isset( $this->custom_fields[ $priority ]['order'] ) ) {
									$sort = $this->custom_fields[ $priority ]['order'];
								}

								while ( isset( $this->ordered_fields[ $sort ] ) )
									$sort++;

								$this->ordered_fields[ $sort ] = array( $priority, $name );

								$sort++;
							}	

							ksort( $this->ordered_fields );

							foreach ( $this->ordered_fields as $value ) {
								$priority = $value[0];
								$name = $value[1];
								?>
								<tr>
									<td class="sort">
										
										<strong><?php echo $name; ?></strong>

										<input type="hidden" class="order" name="checkout_field_order[<?php echo $priority; ?>][order]" value="<?php echo isset( $this->custom_fields[ $priority ]['order'] ) ? $this->custom_fields[ $priority ]['order'] : $priority; ?>" />

										<input type="hidden" name="checkout_field_order[<?php echo $priority; ?>][name]" value="<?php echo $name; ?>" />
									</td>

									

								</tr>
								<?php
							}
							?>
						</tbody>
					</table>

					<script type="text/javascript">

						jQuery('.checkout_priority tbody').sortable({
							items:'tr',
							cursor:'move',
							axis:'y',
							handle: '.sort',
							scrollSensitivity:40,
							forcePlaceholderSize: true,
							helper: 'clone',
							opacity: 0.65,
							placeholder: 'wc-metabox-sortable-placeholder',
							start:function(event,ui){

							},
							stop:function(event,ui){
								checkout_priority_row_indexes();
							}
						});

						function checkout_priority_row_indexes() {
							jQuery('.checkout_priority tbody tr').each(function(index, el){
								jQuery('input.order', el).val( parseInt( jQuery(el).index('.checkout_priority tr') ) );
							});
						};

					</script>
					<?php
					return ob_get_clean();
				}

				public function validate_checkout_priority_field( $key ) {

					$reordered_fields		= array();
					$checkout_field_order	= isset( $_POST['checkout_field_order'] ) ? $_POST['checkout_field_order'] : array();

					foreach ( $checkout_field_order as $priority => $settings ) {

						$reordered_fields[ $priority ] = array(
							'order'		=> wc_clean( $settings['order'] ),
							'name'		=> wc_clean( $settings['name'] ),
						);

					}

					return $reordered_fields;
				}

				function ph_admin_enqueue() {

					$this->states = array();
					if(isset($this->country_code) && ($this->sellingAllowedCountry =='specific')){
						$countries = new WC_Countries();
						$this->states = $countries->get_states($this->country_code);
					}

					wp_enqueue_script('admin_city_and_state_script', plugins_url('/assets/my-admin-script.js', __FILE__ ));
					wp_localize_script( "admin_city_and_state_script", "states", $this->states );
				}
			}   
		}   
	}

	add_action( 'woocommerce_shipping_init', 'shipping_select_city' );

	function add_shipping_select_city( $methods ) {
		$methods[] = 'shipping_Select_City';
		return $methods;
	}

	add_filter( 'woocommerce_shipping_methods', 'add_shipping_select_city' );

	/* Create a settings link */
	function ph_city_dropdown_settings_link( $links ) 
	{
		$settings_link = '<a href="admin.php?page=wc-settings&tab=shipping&section=ph_city_drop_down">Settings</a>';
		array_push( $links, $settings_link );
		return $links;
	}

	add_filter( "plugin_action_links_".plugin_basename(__FILE__), 'ph_city_dropdown_settings_link');


	if( !class_exists('PH_City_As_Dropdown_in_Checkout') ) {

		class PH_City_As_Dropdown_in_Checkout {
			
			function __construct() {

				$this->settings 				= get_option('woocommerce_ph_city_drop_down_settings');
				$this->sellingAllowedCountry	= get_option('woocommerce_allowed_countries');
				$country_codes 					= get_option( 'woocommerce_specific_allowed_countries', array() );

				if((count($country_codes)==1) && ($this->sellingAllowedCountry =='specific')){

					$this->countryCode = $country_codes[0];
				}

				$this->enabled 				= isset( $this->settings['enabled'] ) ? $this->settings['enabled'] : 'yes';
				$this->state_and_cities 	= !empty( $this->settings[ 'state_and_cities'] ) ? $this->settings[ 'state_and_cities'] : array();
				$this->custom_fields 		= ( isset($this->settings[ 'checkout_priority']) && !empty($this->settings[ 'checkout_priority']) ) ? $this->settings[ 'checkout_priority']: array();

				$this->order_array = array(
					'1' => '35',
					'2' => '45',
					'3' => '55',
					'4' => '65',
					'5' => '75',
					'6' => '85',
					'7' => '95',
				);

				if( isset($this->countryCode) && !empty($this->countryCode) && !empty($this->state_and_cities) ) {
					$this->return_state_and_cities();
				}

				add_action( 'wp_enqueue_scripts', array($this,'ph_enqueue'));

				add_filter( 'woocommerce_checkout_fields', array($this, 'ph_custom_address_fields'), 12, 1 );
				add_filter( 'woocommerce_default_address_fields', array($this, 'ph_custom_default_address_fields'),12,1 );
			}

			function return_state_and_cities () {

				$this->stateslist 	= array();
				$cities 			= array();
				$this->array_of_state_and_cities = array();

				if( $this->settings['enabled']=='no' ) {
					return '';
				}

				$state_and_cities        = $this->settings[ 'state_and_cities' ];

				$index =1;

				if( !empty($state_and_cities) ) {
					foreach($state_and_cities as $row) {
						$this->stateslist[$index] = $row['shipment_state'];
						$cities[$index] = $row['shipment_cities'];
						$index++;
					}
				}

				$this->array_of_state_and_cities[0]		= array();
				$this->array_of_state_and_cities[0][0] 	= null;
				
				foreach($this->stateslist as $state) {
					array_push($this->array_of_state_and_cities[0], $state);
				}

				foreach($cities as $index => $citylist) {
					$this->array_of_state_and_cities[$index] = explode(',', $citylist);
					foreach($this->array_of_state_and_cities[$index] as $i=>$city){
						$this->array_of_state_and_cities[$index][$i] = __( trim($city, " "), 'ph-city-drop-down' );
					}
				}

				add_filter( 'woocommerce_checkout_fields', function( $fields ) {

					$city_args = wp_parse_args( array(
						'type' => 'select',
						'options' => $this->array_of_state_and_cities[1],
						'input_class' => array(
							'wc-enhanced-select',
						)
					), $fields['shipping']['shipping_city'] );

					$fields['shipping']['shipping_city']	= $city_args;
					$fields['billing']['billing_city']		= $city_args;

					return $fields;
				} ); 
			}

			function ph_enqueue() {

				wp_enqueue_script('city_and_state_script', plugins_url('/assets/myscript.js', __FILE__ ));

				$countries 		= new WC_Countries();
				$states 		= $countries->get_states($this->countryCode);
				$states_array 	= array();

				if( isset($this->array_of_state_and_cities[0]) ) {

					foreach ($this->array_of_state_and_cities[0] as $key => $value) {

						if(isset($states[$value])) {

							$states_array[$value] = __( $states[$value], 'ph-city-drop-down' );
						}
					}
				}

				$this->array_of_state_and_cities[0] = $states_array;

				// To support Translation
				$translated_array 	= array();

				foreach ($this->array_of_state_and_cities as $index => $stateAndCity) {

					$translated_array[$index] = array();

					if( is_array($stateAndCity) && !empty($stateAndCity) ) {

						foreach ($stateAndCity as $key => $value) {
							
							$translated_array[$index][$key] = __( $value, 'ph-city-drop-down' );
						}
					}
				}

				wp_localize_script( "city_and_state_script", "ph_city_drop_down_admin", array("state_and_cities" => $translated_array, "selectState" => __('Select State', 'ph-city-drop-down' ), "selectCity" => __('Select City', 'ph-city-drop-down' ) ) );
			}

			// Sorting Fields within a Group
			public function ph_custom_address_fields( $checkout_fields ) {

				$reordered_array = array();

				if( !empty($this->custom_fields) )
				{
					foreach( $this->custom_fields as $field => $order )
					{
						if( isset($order['order']) && !empty($order['order']) )
						{

							$order_num = $order['order'];
							$reordered_array[$field] = $this->order_array[$order_num];

						}

					}

				}

				if( !empty($reordered_array) )
				{

					if( isset($checkout_fields['billing']) )
					{
						if( isset($checkout_fields['billing']['billing_company']) ){

							$checkout_fields['billing']['billing_company']['priority'] 		= $reordered_array['30'];
						}

						if( isset($checkout_fields['billing']['billing_country']) ){

							$checkout_fields['billing']['billing_country']['priority'] 		= $reordered_array['40'];
						}

						if( isset($checkout_fields['billing']['billing_address_1']) ){

							$checkout_fields['billing']['billing_address_1']['priority'] 	= $reordered_array['50'];
						}

						if( isset($checkout_fields['billing']['billing_address_2']) ){

							$checkout_fields['billing']['billing_address_2']['priority'] 	= $reordered_array['60'];
						}

						if( isset($checkout_fields['billing']['billing_city']) ){

							$checkout_fields['billing']['billing_city']['priority'] 		= $reordered_array['70'];
						}

						if( isset($checkout_fields['billing']['billing_state']) ){

							$checkout_fields['billing']['billing_state']['priority'] 		= $reordered_array['80'];
						}

						if( isset($checkout_fields['billing']['billing_postcode']) ){

							$checkout_fields['billing']['billing_postcode']['priority'] 	= $reordered_array['90'];
						}
					}

					if( isset($checkout_fields['shipping']) )
					{

						if( isset($checkout_fields['shipping']['shipping_company']) ){

							$checkout_fields['shipping']['shipping_company']['priority'] 	= $reordered_array['30'];
						}

						if( isset($checkout_fields['shipping']['shipping_country']) ){

							$checkout_fields['shipping']['shipping_country']['priority'] 	= $reordered_array['40'];
						}

						if( isset($checkout_fields['shipping']['shipping_address_1']) ){

							$checkout_fields['shipping']['shipping_address_1']['priority'] 	= $reordered_array['50'];
						}

						if( isset($checkout_fields['shipping']['shipping_address_2']) ){

							$checkout_fields['shipping']['shipping_address_2']['priority'] 	= $reordered_array['60'];
						}

						if( isset($checkout_fields['shipping']['shipping_city']) ){

							$checkout_fields['shipping']['shipping_city']['priority']		= $reordered_array['70'];
						}

						if( isset($checkout_fields['shipping']['shipping_state']) ){

							$checkout_fields['shipping']['shipping_state']['priority'] 		= $reordered_array['80'];
						}

						if( isset($checkout_fields['shipping']['shipping_postcode']) ){

							$checkout_fields['shipping']['shipping_postcode']['priority'] 	= $reordered_array['90'];
						}
					}
				}

				return $checkout_fields;
			}

			//Sorting Fields without a Group
			public function ph_custom_default_address_fields( $address_fields ) {

				$reordered_array = array();

				if( !empty($this->custom_fields) )
				{
					foreach( $this->custom_fields as $field => $order )
					{
						if( isset($order['order']) && !empty($order['order']) )
						{

							$order_num = $order['order'];
							$reordered_array[$field] = $this->order_array[$order_num];

						}
					}

				}

				if( !empty($reordered_array) )
				{
					if( isset($address_fields['company']) ){

						$address_fields['company']['priority'] 		= $reordered_array['30'];
					}

					if( isset($address_fields['country']) ){

						$address_fields['country']['priority'] 		= $reordered_array['40'];
					}

					if( isset($address_fields['address_1']) ){

						$address_fields['address_1']['priority'] 	= $reordered_array['50'];
					}

					if( isset($address_fields['address_2']) ){

						$address_fields['address_2']['priority'] 	= $reordered_array['60'];
					}

					if( isset($address_fields['city']) ){

						$address_fields['city']['priority'] 		= $reordered_array['70'];
					}

					if( isset($address_fields['state']) ){

						$address_fields['state']['priority'] 		= $reordered_array['80'];
					}

					if( isset($address_fields['postcode']) ){

						$address_fields['postcode']['priority'] 	= $reordered_array['90'];
					}
				}

				return $address_fields;
			}
		}

		new PH_City_As_Dropdown_in_Checkout();
	}


