<?php if( !defined( '_VALID_MOS' ) && !defined( '_JEXEC' ) ) die( 'Direct Access to '.basename(__FILE__).' is not allowed.' ); ?>
<div class="jv-detail-wrap" style="width: 100%;">
<?php //echo $buttons_header // The PDF, Email and Print buttons ?>

<?php
if( $this->get_cfg( 'showPathway' )) {
	echo "<div class=\"pathway\">$navigation_pathway</div>";
}
if( $this->get_cfg( 'product_navigation', 1 )) {
	if( !empty( $previous_product )) {
		echo '<a class="previous_page" href="'.$previous_product_url.'">'.shopMakeHtmlSafe($previous_product['product_name']).'</a>';
	}
	if( !empty( $next_product )) {		
		echo '<a class="next_page" href="'.$next_product_url.'">'.shopMakeHtmlSafe($next_product['product_name']).'</a>';
	}
}
?>
<br style="clear:both;" />
	<div class="jv-detail-inner">
		<div class="jv-detail-img" style="float: left; width: 45%; clear: none;">
			<div class="jv-detail-imgfull">
				<?php echo $product_image ?>
			</div>
            <?php if($this->vmlistAdditionalImages( $product_id, $images )) : ?>
            <div class="jv-detail-imgadd">
				<?php echo $this->vmlistAdditionalImages( $product_id, $images ) ?>
			</div>
            <?php endif; ?>
		</div>
		<div class="jv-detail-desc">
			<div class="jv-detail-padding">
            	<h3><?php echo $product_name ?> <?php echo $edit_link ?></h3>
				<?php echo $product_price_lbl ?>
				<?php echo $product_price ?><br />
				<?php echo $product_packaging ?>
				<a class="buttonask" href="<?php echo $ask_seller_href ?>"><?php echo $ask_seller_text ?></a>
				<div class="jv-line"></div>
				<?php echo $product_description ?><br/>
				<span style="font-style: italic;"><?php echo $file_list ?></span>

                <div class="jv-addavai" style="width: 100%; clear: both; overflow: hidden">
					<div class="jv-rounded-corners3">
						<div class="jv-tc clearfix">
							<div class="jv-tl"></div>
							<div class="jv-tr"></div>
						</div>
						<div class="jv-c clearfix"><div class="jv-cl"><div class="jv-cr">	
							<?php if( $this->get_cfg( 'showAvailability' )) { ?>
							<div class="jv-availability" style=" float:left;">
								<span style="font-weight:bold; "><?php echo $product_availability; ?></span>
							</div>
							<?php } ?>
							
							<?php echo $product_type ?>
							<div class="jv-addrocart" style=" float: right;">
								<?php echo $addtocart ?>
							</div>
						</div></div></div>
						<div class="jv-bc clearfix">
							<div class="jv-bl"></div>
							<div class="jv-br"></div>
						</div>
					</div>
                </div>
				<?php echo $related_products ?>
                <?php echo $product_reviewform ?>
			</div>
		</div>

	</div>