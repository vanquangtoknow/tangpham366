<?php if( !defined( '_VALID_MOS' ) && !defined( '_JEXEC' ) ) die( 'Direct Access to '.basename(__FILE__).' is not allowed.' );

if($empty_cart) { ?>
<div>
   <?php if(!$vmMinicart) {  ?>
	<div class="vm-showcart">
 		 <?php echo $show_cart ?>
  </div>
  <div class="vm-total-pro clearfix">
   <?php }
     echo $VM_LANG->_('PHPSHOP_EMPTY_CART') ?>
  </div>
</div>
<?php } 
else {
// Loop through each row and build the table
   
}
 if (!$empty_cart && !$vmMinicart) { ?>
    <div class="vm-showcart">
    <?php echo $show_cart ?>
    </div>

<?php } 
if(!$vmMinicart) { ?>
  <!-- <hr style="clear: both;" /> -->
<?php } ?>
<div class="vm-total-pro clearfix">
    <strong><?php echo $total_products ?></strong><span class="productPrice"><?php echo $total_price ?></span>
</div>
<?php 
echo $saved_cart;
?>
