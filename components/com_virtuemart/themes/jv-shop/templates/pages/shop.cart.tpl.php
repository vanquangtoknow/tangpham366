<?php
if( !defined( '_VALID_MOS' ) && !defined( '_JEXEC' ) ) die( 'Direct Access to '.basename(__FILE__).' is not allowed.' );
/**
*
* @version $Id: shop.cart.tpl.php 1345 2008-04-03 20:26:21Z soeren_nb $
* @package VirtueMart
* @subpackage themes
* @copyright Copyright (C) 2004-2008 soeren - All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
* VirtueMart is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See /administrator/components/com_virtuemart/COPYRIGHT.php for copyright notices and details.
*
* http://virtuemart.net
*/
mm_showMyFileName( __FILE__ );

echo '<div class="jv-rounded-corners3 cart-title">
<div class="jv-tc">
<div class="jv-tl"></div>
<div class="jv-tr"></div>
</div><div class="jv-c clearfix"><div class="jv-cl"><div class="jv-cr"><h2>'. $VM_LANG->_('PHPSHOP_CART_TITLE') .'</h2></div></div></div>
<div class="jv-bc clearfix">
<div class="jv-bl"></div>
<div class="jv-br"></div>
</div></div>';

include(PAGEPATH. 'basket.php');
echo '<div class="jv-rounded-corners3 wrap-basket">
<div class="jv-tc">
<div class="jv-tl"></div>
<div class="jv-tr"></div>
</div><div class="jv-c clearfix"><div class="jv-cl"><div class="jv-cr">';
echo $basket_html;
echo '</div></div></div><div class="jv-bc clearfix">
<div class="jv-bl"></div>
<div class="jv-br"></div>
</div></div>';


if ($cart["idx"]) {
    ?>
    <div class="link-continue-checkout">
    <?php
    if( $continue_link != '') {
		?>
		 <a href="<?php echo $continue_link ?>" class="continue_link">
		 	<?php echo $VM_LANG->_('PHPSHOP_CONTINUE_SHOPPING'); ?>
		 </a>
		<?php
    }
        
   if (!defined('_MIN_POV_REACHED')) { ?>

       <span style="font-weight:bold;"><?php echo $VM_LANG->_('PHPSHOP_CHECKOUT_ERR_MIN_POV2') . " ".$CURRENCY_DISPLAY->getFullValue($_SESSION['minimum_pov']) ?></span>
       <?php
   }
   else {
   		$href = $sess->url( $_SERVER['PHP_SELF'].'?page=checkout.index&ssl_redirect=1', true);
   		$href2 = $sess->url( $mm_action_url . "/index2.php?page=checkout.index&ssl_redirect=1", true);
   		$class_att = 'class="checkout_link"';
   		$text = $VM_LANG->_('PHPSHOP_CHECKOUT_TITLE');
 		
   		if( $this->get_cfg('useGreyBoxOnCheckout', 1)) {
   			echo vmCommonHTML::getGreyBoxPopupLink( $href2, $text, '', $text, $class_att, 500, 600, $href );
   		}
   		else {
   			echo vmCommonHTML::hyperlink( $href, $text, '', $text, $class_att );
   		}
 	}
	?>
	</div>
	
	<?php
	// End if statement
}
?>