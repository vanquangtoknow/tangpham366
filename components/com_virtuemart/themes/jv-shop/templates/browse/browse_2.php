<div class="jv-ProductContainer">
    <div class="jv-ProductImageContainer" >
    	<a href="<?php echo $product_flypage ?>">
          <?php echo ps_product::image_tag( $product_thumb_image, 'class="browseProductImage" border="0" title="'.$product_name.'" alt="'.$product_name .'"' ) ?>
       </a>
    </div>
	<?php if(strlen($product_s_desc) > 120) $product_s_desc = substr($product_s_desc,0,120)."..."; ?>
    <div class="jv-ProductDescription">
		<h3 class="jv-ProductTitle"><a title="<?php echo $product_name ?>" href="<?php echo $product_flypage ?>">
			<?php echo $product_name ?></a>
		</h3>
		<?php echo $product_s_desc ?><br />
      <a class="jv-vmProductDetails" href="<?php echo $product_flypage ?>"><?php echo $product_details ?>...</a>
    </div>
  <div class="jv-ContainPriceRating">
	  <div class="jv-PriceContainer">
			  <?php echo $product_price ?>
	  </div>
	  <div class="jv-RatingContainer">
		<?php echo $product_rating ?>
	  </div>
  </div>
  <div class="jv-AddToCartContainer">
      <?php echo $form_addtocart ?>
  </div>
</div>
