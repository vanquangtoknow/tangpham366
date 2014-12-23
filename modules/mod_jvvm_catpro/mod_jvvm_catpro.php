<?php
if( !defined( '_VALID_MOS' ) && !defined( '_JEXEC' ) ) die( 'Direct Access to '.basename(__FILE__).' is not allowed.' );
/* Latest Products Module
*
* @version $Id: mod_virtuemart_latestprod.php 1159 2008-01-14 20:30:30Z soeren_nb $
* @package VirtueMart
* @subpackage modules
*
* @copyright (C) 2000 - 2004 Mr PHP
// W: www.mrphp.com.au
// E: info@mrphp.com.au
// P: +61 418 436 690
* Conversion to Mambo and the rest:
* 	@copyright (C) 2004-2005 Soeren Eberhardt
*
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* VirtueMart is Free Software.
* VirtueMart comes with absolute no warranty.
*
* www.virtuemart.net
*/

global $mosConfig_absolute_path;
// Load the virtuemart main parse code
if( file_exists(dirname(__FILE__).'/../../components/com_virtuemart/virtuemart_parser.php' )) {
	require_once( dirname(__FILE__).'/../../components/com_virtuemart/virtuemart_parser.php' );
} else {
	require_once( dirname(__FILE__).'/../components/com_virtuemart/virtuemart_parser.php' );
}
$slide_height = $params->get( 'slide_height', 200 );
$type_product = $params->get( 'type_product', 1 );
$max_items = $params->get( 'max_items', null );
$slide = $params->get( 'slide', null );
$autorun = $params->get( 'autorun', null );
$fadeeffect = $params->get( 'fadeeffect', null );
$products_per_page = $params->get( 'products_per_page', 4 );
$category_id = $params->get( 'category_id', null );
$show_price = (bool)$params->get( 'show_price', 1 );
$show_addtocart = (bool)$params->get( 'show_addtocart', 1 );

JHTML::_('stylesheet','style.css','modules/mod_jvvm_catpro/assets/css/');
JHTML::_('stylesheet','contentslider.css','modules/mod_jvvm_catpro/assets/css/');
if($slide)
	JHTML::_('script','contentslider.js','modules/mod_jvvm_catpro/assets/js/');
if($autorun) $auto = "true";
else $auto = "false";
if($fadeeffect) $fade = "true";
else $fade = "false";
require_once( CLASSPATH . 'ps_product.php');
$ps_product = new ps_product;

$categorys = explode( ',', $category_id );
JArrayHelper::toInteger( $categorys );
//$db =& new ps_DB;
$db	=& JFactory::getDBO();
$sess = new ps_session();

$query = "SELECT * FROM #__vm_category WHERE category_publish = 'Y'";
$query .= " AND category_id IN (".implode(',',$categorys).") ";
$db->setQuery($query);
$categorys_id = $db->loadObjectList();
?>
<div style="display: none;"><a href="http://www.joomlavision.com" title="Joomla Templates">Joomla Templates</a> and Joomla Extensions by JoomlaVision.Com</div>
<?php
foreach($categorys_id as $category){
	
	if($type_product == 2) {
		$query  = "SELECT DISTINCT product_sku FROM #__".VM_TABLEPREFIX."_product, #__".VM_TABLEPREFIX."_product_category_xref, #__".VM_TABLEPREFIX."_category WHERE \n";
		$query .= "(#__".VM_TABLEPREFIX."_product.product_parent_id='' OR #__".VM_TABLEPREFIX."_product.product_parent_id='0') \n";
		$query .= "AND #__".VM_TABLEPREFIX."_product.product_id=#__".VM_TABLEPREFIX."_product_category_xref.product_id \n";
		$query .= "AND #__".VM_TABLEPREFIX."_category.category_id=#__".VM_TABLEPREFIX."_product_category_xref.category_id \n";
		$query .= "AND #__".VM_TABLEPREFIX."_category.category_id='".$category->category_id."' \n";
		$query .= "AND #__".VM_TABLEPREFIX."_product.product_publish='Y' \n";
		$query .= "AND #__".VM_TABLEPREFIX."_product.product_special='Y' \n";
		if( CHECK_STOCK && PSHOP_SHOW_OUT_OF_STOCK_PRODUCTS != "1") {
			$query .= " AND product_in_stock > 0 \n";
		}
		$query .= "ORDER BY RAND() LIMIT 0, ".$max_items;
	} else {
		$query  = "SELECT DISTINCT product_sku FROM #__".VM_TABLEPREFIX."_product, #__".VM_TABLEPREFIX."_product_category_xref, #__".VM_TABLEPREFIX."_category WHERE ";
		$query .= "product_parent_id=''";
		$query .= "AND #__".VM_TABLEPREFIX."_product.product_id=#__".VM_TABLEPREFIX."_product_category_xref.product_id ";
		$query .= "AND #__".VM_TABLEPREFIX."_category.category_id=#__".VM_TABLEPREFIX."_product_category_xref.category_id ";
		if( !empty( $category_id ) ) {
			$query .= "AND #__".VM_TABLEPREFIX."_category.category_id='".$category->category_id."' ";
		}
		if( CHECK_STOCK && PSHOP_SHOW_OUT_OF_STOCK_PRODUCTS != "1") {
			$query .= " AND product_in_stock > 0 ";
		}
		$query .= "AND #__".VM_TABLEPREFIX."_product.product_publish='Y' ";
		$query .= "ORDER BY #__".VM_TABLEPREFIX."_product.product_id DESC ";
		$query .= "LIMIT 0, ".$max_items;
	}

	$db->setQuery($query);
	$product_list = $db->loadObjectList();
	$count_list = count($product_list);
	if( $count_list > 0 ){
		$thepage = round(($count_list / $products_per_page),0);

	//echo '<h3><span class="jv-title">'.$category->category_name.'</span><span id="paginate-jvvmcatpro'.$category->category_id.'" class="jv-navigation">&nbsp;</span><span class="jv-viewall">
	//<a href="';
	//$sess->purl(URL."index.php?option=com_virtuemart&amp;page=shop.browse&amp;category_id=".$category->category_id);
	//echo '" title="'.$category->category_name.'">'.JText::_('View all +').'</a></span></h3>';
	
?>

<?php
	if($thepage > 1 && $slide){
?>
		<div id="jvvmcatpro<?php echo $category->category_id; ?>" class="sliderwrapper" style="height: <?php echo $slide_height; ?>px;">
<?php
	} else {
?>
	<div id="jvvmcatpro<?php echo $category->category_id; ?>" class="sliderwrapper-noslide">
<?php
	}	

		for($i=0;$i<$thepage;$i++){
?>
			<div class="contentdiv">
				<ul>
<?php
			for($j=$i*$products_per_page;$j<$i*$products_per_page+$products_per_page; $j++){
				if($product_list[$j]->product_sku){
					echo "<li class='item".$i++."'>";
						echo "<div class='jv-rounded-corners3'>";
							echo "<div class='jv-tc clearfix'>
										<div class='jv-tl'></div>
										<div class='jv-tr'></div>
								</div>";
							echo "<div class='jv-c clearfix'><div class='jv-cl'><div class='jv-cr'>";
								echo "<div class='product-center'>";
									$ps_product->show_snapshot($product_list[$j]->product_sku, $show_price, $show_addtocart);
								echo "</div>";
							echo "</div></div></div>";
							echo "<div class='jv-bc clearfix'>
									<div class='jv-bl'></div>
									<div class='jv-br'></div>
								</div>";
						echo "</div>";
					echo "</li>";
				}
			}
?>
				</ul>
			</div>
<?php
		}
?>
		</div>
<?php
	if($thepage > 1 && $slide){
?>
		<script type="text/javascript">
			featuredcontentslider.init({
				id: "jvvmcatpro<?php echo $category->category_id; ?>",
				contentsource: ["inline", ""],
				toc: "#increment",
				nextprev: ["Previous", "Next"],
				enablefade: [<?php echo $fade; ?>, 0.1],
				autorotate: [<?php echo $auto; ?>, 5000],
				onChange: function(previndex, curindex){
					
				}})
		</script>		
<?php
		}
	}
}
?>