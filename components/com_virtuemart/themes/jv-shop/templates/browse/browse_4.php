<div class="browseProductContainer">
    <a class="jv-a-img" href="<?php echo $product_flypage ?>" title="<?php echo $product_name ?>">
     <?php echo ps_product::image_tag( $product_thumb_image, 'class="browseProductImage" border="0" title="'.$product_name.'" alt="'.$product_name .'"' ) ?>
    </a><br />  
  <span class="jv-span-name"><?php echo $product_name ?></span><br />  
  <?php echo $product_price ?><br />  
  <a class="jv-a-detail" href="<?php echo $product_flypage ?>">View Details</a>
  <br style="clear:both;" />
</div>
