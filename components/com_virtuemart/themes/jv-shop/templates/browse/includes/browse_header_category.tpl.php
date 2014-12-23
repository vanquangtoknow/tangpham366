<?php if( !defined( '_VALID_MOS' ) && !defined( '_JEXEC' ) ) die( 'Direct Access to '.basename(__FILE__).' is not allowed.' ); ?>

<div class="jv-rounded-corners3 jv-head-cat">
    <div class="jv-tc">
		<div class="jv-tl"></div>
		<div class="jv-tr"></div>
	</div>
    <div class="jv-c clearfix"><div class="jv-cl"><div class="jv-cr">
    	<h3 class="jv-category-h3"><span class="jv-title"><?php echo $browsepage_lbl; ?></span> 
			<?php 
            if( $this->get_cfg( 'showFeedIcon', 1 ) && (VM_FEED_ENABLED == 1) ) { ?>
            <a class="vmFeedIcon" href="index.php?option=<?php echo VM_COMPONENT_NAME ?>&amp;page=shop.feed&amp;category_id=<?php echo $category_id ?>" title="<?php echo $VM_LANG->_('VM_FEED_SUBSCRIBE_TOCATEGORY_TITLE') ?>">
            <img src="<?php echo VM_THEMEURL ?>/images/feed-icon-14x14.png" align="baseline" alt="feed" border="0"/></a>
            <?php 
            } ?>
        </h3>
    </div></div></div>
    <div class="jv-bc clearfix">
		<div class="jv-bl"></div>
		<div class="jv-br"></div>
	</div>
</div>

<!--
<div style="text-align:left;">
	<?php echo $navigation_childlist; ?>
</div>

<?php if( trim(str_replace( "<br />", "" , $desc)) != "" ) { ?>

		<div class="jv-vmPageHeader">
			<?php echo $desc; ?>
		</div>
		<br class="clr" /><br />
		<?php
     }
?>
-->