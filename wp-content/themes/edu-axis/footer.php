<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package edu-axis
 */

 /**
  * Hook - edu_axis_action_after_content.
  *
  * @hooked edu_axis_main_content_ends - 30
  */
do_action( 'edu_axis_action_after_content' );

$footer_copyright = edu_axis_get_option( 'footer_copyright' );
?>

	<footer id="colophon" class="site-footer el-rt-animate fadeInUp">
	
		
		<div class="site-info">
			<div class="rt-wrapper">
			
					<div class="jr-wrapper-div1">
						<div class="content-wrapper-one">
							<h2>CONTACT INFORMATION</h2>
							<div class="address">
								<div class="address-label">
									<label>ADDRESS</label>
								</div>
								<div class="address-span">
									<span>
										#23 Lacson Extension-Corner Alijis Road, Bacolod City, Philippines, 6100.
									</span>
								</div>
							</div>
							<div class="phone">
								<div class="phone-label">
									<label>PHONE</label>
								</div>
								<div class="phone-span">
									<span>+63 (34) 432-3270</span>
								</div>
							</div>
							<div class="email">
								<div class="email-label">
									<label>EMAIL</label>
								</div>
								<div class="email-span">
									<span>mboxdigital@gmail.com</span>
								</div>
							</div>
							<div class="work-hours">
								<div class="work-label">
									<label>WORKING DAYS/HOURS</label>
								</div>
								<div class="work-span">
									<span>Mon - Sun / 9:00AM - 8:00PM</span>
								</div>
							</div>
							<div class="social-meida">
								<div class="facebook"><img src="../wp-content/themes/edu-axis/assets/images/facebook.png"></div>
								<div class="twitter"><img src="../wp-content/themes/edu-axis/assets/images/twitter.png"></div>
								<div class="gmail"><img src="../wp-content/themes/edu-axis/assets/images/gmail.png"></div>
							</div>
						</div>
						<div class="content-wrapper-two">
							<h2>MY ACCOUNT</h2>	
							<div class="my-account-main-wrapper1">
								<div class="my-account-wrapper1">
									<div>
										<span>About us</span>
									</div>
									<div>
										<span>Contact us</span>
									</div>
									<div>
										<span>My Account</span>
									</div>
								</div>
								<div class="my-account-wrapper2">
									<div>
										<span>Order history</span>
									</div>
									<div>
										<span>Advanced search</span>
									</div>
									<div>
										<span>Login</span>
									</div>
								</div>
							</div>
							
						</div>
						<div class="content-wrapper-three">
							<h2>BE THE FIRST TO KNOW</h2>
							<div class="be-the-first-to-know">
								<span>Get all the latest information on Events, Sales and Offers.Sign up for newsletter today.</span>
							</div>
							<div class="subscribe">
								<input type="email" name="email" placeholder="Email Address">
								<button>SUBSCRIBE</button>
							</div>
							<div class="payment-method-wrapper">
								<h2>PAYMENT PROVIDER</h2>
								<div class="payment-method-wrapper-c-one">
									<div class="paymaya"><img src="../wp-content/themes/edu-axis/assets/images/paymaya.png"></div>
									<div class="visa"><img src="../wp-content/themes/edu-axis/assets/images/visa.png"></div>
									<div class="gcash"><img src="../wp-content/themes/edu-axis/assets/images/gcash.png"></div>
								</div>
								
							</div>
						</div>
					
					</div>
				<!-- 	<div class="jr-wrapper-div2">
						<div class="bottom-wrapper">
							 <div class="cotact-wrapper">
							 	 
							 </div>
							 <div class="payment-wrapper">
							 	
							 </div>
						</div>
					</div> -->
				
			</div>
		</div><!-- .site-info -->
		<div class="copy-right-wrapper">
			<div class="rt-wrapper">
				<span>© Aldrtz Corporation. 2019. All Rights Reserved</span>
			</div>
		</div>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
