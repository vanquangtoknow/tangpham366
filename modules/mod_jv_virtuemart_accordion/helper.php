<?php
/**
 * @package JV Virtuemart Accordion module for Joomla! 1.5
 * @author http://www.joomlavision.com
 * @copyright (C) 2010- JoomlaVision.Com
 * @license PHP files are GNU/GPL
**/
defined('_JEXEC') or die('Restricted access');

if( file_exists(JPATH_SITE.DS.'components'.DS.'com_virtuemart'.DS.'virtuemart_parser.php' )) {
	require_once( JPATH_SITE.DS.'components'.DS.'com_virtuemart'.DS.'virtuemart_parser.php' );
} else {
	require_once( JPATH_SITE.DS.'components'.DS.'com_virtuemart'.DS.'virtuemart_parser.php' );
}

class modjv_virtuemart_accordionHelper
{
	var $_fxeffect;
	var $_eventType;
	var $_duration;
	var $_time;
	var $_currentparent = array();
	var $_idactive;
	
	function __construct($params) {
		$this->_fxeffect 	  			= $params->get('fxeffect', $this->_fxeffect);
		$this->_eventType				= $params->get('event_type', $this->_eventType);
		$this->_duration				= $params->get('duration', $this->_duration);
		$this->_time					= $params->get('time', $this->_time);
		$this->_idactive				= JRequest::getVar('category_id');
		$this->_currentparent 			= modjv_virtuemart_accordionHelper::getParent($this->_idactive,NULL);
		if($this->_currentparent!=NULL){
			$this->_currentparent 		= array_merge((array)$this->_idactive, $this->_currentparent);
		}else{
			$this->_currentparent		= (array)$this->_idactive;
		}
	}
	function jvDisplay($params, $id_mod){
		echo $display = $this->jvAccordion($id_mod);
		return $display;
	}
	function recordCount($category_id){
		$database = new ps_DB();
		$query = "SELECT category_name as cname, category_id as cid, category_child_id as ccid "
		. "FROM #__{vm}_category as a, #__{vm}_category_xref as b "
		 . "WHERE a.category_publish='Y' AND "
		 . " b.category_parent_id='$category_id' AND a.category_id=b.category_child_id "
		 . "ORDER BY category_parent_id, list_order, category_name ASC";
		$database->setQuery( $query);
		$subac = $database->loadObjectList();
		$check_sub = count($subac);
		return $check_sub;
	}
	function getList($Itemid, $category_id)
	{
		$database = new ps_DB();
		$query = "SELECT category_name as cname, category_id as cid, category_child_id as ccid "
		. "FROM #__{vm}_category as a, #__{vm}_category_xref as b "
		 . "WHERE a.category_publish='Y' AND "
		 . " b.category_parent_id='$category_id' AND a.category_id=b.category_child_id "
		 . "ORDER BY category_parent_id, list_order, category_name ASC";
		$database->query( $query );		
		$categories = $database->record;
		
		$html = '';
		if( !( $categories==null ) ) {
			$html .='<ul class="detail-parent">';	
				
			for ($i=0; $i<count($categories); $i++) {
				$category = $categories[$i];
				$link = JRoute::_( 'index.php?option=com_virtuemart&amp;page=shop.browse&amp;category_id='. $category->cid .'&amp;Itemid='.$Itemid );
				$check_sub = modjv_virtuemart_accordionHelper::recordCount($category->cid);	
					
				if($check_sub>0){
					if(in_array($category->cid, $this->_currentparent)) {
						$html .='<li class=\'parent active item'.$category->cid.'\'><a href=\''.$link.'\'>'.$category->cname.'</a>'.modjv_virtuemart_accordionHelper::getList($Itemid, $category->ccid).'</li>';
					}else{
						$html .='<li class=\'parent item'.$category->cid.'\'><a href=\''.$link.'\'>'.$category->cname.'</a>'.modjv_virtuemart_accordionHelper::getList($Itemid, $category->ccid).'</li>';
					}		
				}else{
					if($this->_idactive == $category->cid){
						$html .='<li class=\'active item'.$category->cid.'\'><a href=\''.$link.'\'>'.$category->cname.'</a>'.modjv_virtuemart_accordionHelper::getList($Itemid, $category->ccid).'</li>';
					}else{
						$html .='<li class=\'item'.$category->cid.'\'><a href=\''.$link.'\'>'.$category->cname.'</a>'.modjv_virtuemart_accordionHelper::getList($Itemid, $category->ccid).'</li>';	
					}
				}
			}
			$html .='</ul>';
		}
		return $html;			
	}
	function jvAccordion($id_mod){
		global $mainframe;
		$hs_base = JURI::base () . 'modules/mod_jv_virtuemart_accordion/assets/js/';
		$hs_basecs = JURI::base () . 'modules/mod_jv_virtuemart_accordion/assets/css/';
		$headtag = array ();
		$headtag []="<script type='text/javascript' src='".$hs_base."jv_vm_accordion.js'></script>";
		$headtag []="<link type='text/css' rel='stylesheet' href='".$hs_basecs."style.css' />";		
		$headtag [] = JHTML::_ ( 'behavior.mootools' );		
		$mainframe->addCustomHeadTag ( implode ( "\n", $headtag ) );
		$database = new ps_DB();
		$query = "SELECT id"
					. "\n FROM #__menu"
					. "\n WHERE type = 'component'"
					. "\n AND link LIKE '%com_virtuemart%'"
					;
					$database->setQuery( $query );
					$Itemid = $database->loadResult();
		$query = 'SELECT a.category_id, a.category_name, a.category_publish, a.list_order, f.category_parent_id, f.category_child_id'
		        . ' FROM jos_vm_category AS a, jos_vm_category_xref AS f'
		        . ' WHERE a.category_publish="Y" AND a.category_id = f.category_child_id AND f.category_parent_id=\'0\''
		        . ' ORDER BY a.list_order';
		$database->setQuery( $query);
		$rows = $database->loadObjectList();
		$html = '';
		$html .='
			<script type="text/javascript">
				window.addEvent(\'domready\', function(){
					jv_vmAccordionMenu(
						"jvacc_'.$id_mod.'",
						"",
						"",
						{duration:'.$this->_duration.', transition:Fx.Transitions.'.$this->_fxeffect.'},
						'.$this->_time.', 
						'.$this->_eventType.'
					);					
				});
			</script>
		';
		$html .='<div id="jvAccordmenu">';
		$html .='<ul id="jvacc_'.$id_mod.'" class=\'jv_accordion\'>';
		for($i=0; $i<count($rows); $i++){
			$item = $rows[$i];
			$link = JRoute::_( 'index.php?option=com_virtuemart&amp;page=shop.browse&amp;category_id='. $item->category_id .'&amp;Itemid='.$Itemid );
			$check_sub = $this->recordCount($item->category_id);
				
			if($check_sub>0){
				if(in_array($item->category_id, $this->_currentparent)) {
					$html .='<li class=\'parent active item'.$item->category_id.'\'><a href=\''.$link.'\'>'.$item->category_name.'</a>'.$this->getList($Itemid, $item->category_id).'</li>';
				}else{
					$html .='<li class=\'parent item'.$item->category_id.'\'><a href=\''.$link.'\'>'.$item->category_name.'</a>'.$this->getList($Itemid, $item->category_id).'</li>';
				}		
			}else{
				if($this->_idactive == $item->category_id) {
					$html .='<li class=\'active item'.$item->category_id.'\'><a href=\''.$link.'\'>'.$item->category_name.'</a>'.$this->getList($Itemid, $item->category_id).'</li>';
				}else{
					$html .='<li class=\'item'.$item->category_id.'\'><a href=\''.$link.'\'>'.$item->category_name.'</a>'.$this->getList($Itemid, $item->category_id).'</li>';
				}				
			}
		}
		$html .='</ul>';
		$html .='</div>';
		return $html;
	}
	function getParent($category_id, $parentCategory=NULL){
		$database = & JFactory::getDBO();
		$query = "SELECT category_name as cname, category_id as cid, category_child_id as ccid "
		. "FROM #__vm_category as a, #__vm_category_xref as b "
		 . "WHERE a.category_publish='Y' AND "
		 . " b.category_child_id='$category_id' AND a.category_id=b.category_parent_id "
		 . "ORDER BY category_parent_id, list_order, category_name ASC";
		$database->setQuery( $query);
		$parentcid = $database->loadObject();
		if ($parentCategory==NULL) {
			$parentCategory = array();
		}
		if (!count($parentcid)) {
			return;
		}
		$this->_currentparent[] = $parentcid->cid;
		modjv_virtuemart_accordionHelper::getParent($parentcid->cid,$parentCategory);
		return $this->_currentparent;
	}
}
