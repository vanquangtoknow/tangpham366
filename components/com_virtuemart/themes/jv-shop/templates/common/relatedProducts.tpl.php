<?php if( !defined( '_VALID_MOS' ) && !defined( '_JEXEC' ) ) die( 'Direct Access to '.basename(__FILE__).' is not allowed.' ); ?>
<?php
	$j = 0;
?>
<div class="jv-rounded-corners3 wrap-jv-relatepro">
    <div class="jv-tc">
		<div class="jv-tl"></div>
		<div class="jv-tr"></div>
	</div>
    <div class="jv-c clearfix"><div class="jv-cl"><div class="jv-cr">
    	
		<h3><?php echo $VM_LANG->_('PHPSHOP_RELATED_PRODUCTS_HEADING') ?></h3>
		 
		<div class="jv-relatepro">
			<?php 
			while( $products->next_record() ) { 
			$j++;
			?>
				<div class="jv-relatepro-items" style="width: 23.5%; float: left; position: relative; margin-right: 6px; text-align: center;">
					<?php echo $ps_product->product_snapshot( $products->f('product_sku') ) ?>
				</div>
			<?php 
			}
			?>
		</div>

    </div></div></div>
    <div class="jv-bc clearfix">
		<div class="jv-bl"></div>
		<div class="jv-br"></div>
	</div>
</div>