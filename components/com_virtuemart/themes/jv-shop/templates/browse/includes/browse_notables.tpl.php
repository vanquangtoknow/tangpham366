<?php if( !defined( '_VALID_MOS' ) && !defined( '_JEXEC' ) ) die( 'Direct Access to '.basename(__FILE__).' is not allowed.' ); ?>

<?php //echo $buttons_header // The PDF, Email and Print buttons ?>
<?php echo $browsepage_header // The heading, the category description ?>
<?php echo $parameter_form // The Parameter search form ?>
<?php echo $orderby_form // The sort-by, order-by form PLUS top page navigation ?>

<div id="product_list" style="width:100%; float:none;">
<?php
$data =array(); // Holds the rows of products
$i = $row = $tmp_row = 0; // Counters
$num_products = count( $products );
$j = 0;
foreach( $products as $product ) {
		if ($j % 4 == 0) {
			echo '<div class="jv-product-wrap">';
		}
		$j++;
		/*** Now echo the filled cell ***/
		if( $tmp_row != $row || $row == 0 ) {
			if ( ($num_products - $i) < $products_per_row ) {
				$cell_count =$num_products - $i;
			}
			else {
				$cell_count = $products_per_row;
			}
			$row++;
			$tmp_row = $row;
		}
		$colspan = $products_per_row - $cell_count + 1;
		if( $cell_count < 1 ) {
			$cell_count = 1;
		}
		echo "\n<div class=\"jv-divproduct\" style=\"width:". intval(round(100/$cell_count)) ."%;\" id=\"".uniqid( "row_" ) ."\">
		<div class=\"jv-rounded-corners3\">
		<div class=\"jv-tc\">
			<div class=\"jv-tl\"></div>
			<div class=\"jv-tr\"></div>
		</div>
		<div class=\"jv-c clearfix\"><div class=\"jv-cl\"><div class=\"jv-cr\">";
		
		foreach( $product as $attr => $val ) {
			// Using this we make all the variables available in the template
			// translated example: $this->set( 'product_name', $product_name );
			$this->set( $attr, $val );
		}

		// Parse the product template (usually 'browse_x') for each product
		// and store it in our $data array 
		echo $this->fetch_cache( 'browse/'.$templatefile .'.php' );
		
		$i++;
		if ( ($i) % $products_per_row == 0) {
			$row++;
			/** if yes, close the current "row" ***/
			echo "\n</div></div></div>
			<div class=\"jv-bc clearfix\">
			<div class=\"jv-bl\"></div>
			<div class=\"jv-br\"></div>
			</div></div></div>";
		}
		else {
			echo "\n</div>";
	
		}
		
		if ($j % 4 == 0) {
			echo '</div>';
		}

}
?>
<?php 
if($j % 4 != 0) {
	echo '</div>';
}
?>
</div>
<?php 
echo $browsepage_footer;

// Show Featured Products
if( $this->get_cfg( 'showFeatured', 1 )) {
    /* featuredproducts(random, no_of_products,category_based) no_of_products 0 = all else numeric amount
    edit featuredproduct.tpl.php to edit layout */
    echo $ps_product->featuredProducts(true,10,true);
}
//echo $recent_products;

?>