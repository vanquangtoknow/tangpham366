function jv_vmAccordionMenu(vmAccordionId, spanExpant, spanCollapse, accOptions, accHoverDelay, mouseHover) {
if($(vmAccordionId)){
    $(vmAccordionId).accParentItems = [];
    for(var i = 0; i < $(vmAccordionId).childNodes.length; i++) {
        if($(vmAccordionId).childNodes[i].className.indexOf('parent') >= 0){
            $(vmAccordionId).accParentItems.push($(vmAccordionId).childNodes[i]);
        }
    }
    $(vmAccordionId).accTogglers = [];
    $(vmAccordionId).accElements = [];
    var startItem = -1;
    for(var i = 0; i < $(vmAccordionId).accParentItems.length; i++) {
		var accToggler = document.createElement("span");
		$(vmAccordionId).accParentItems[i].insertBefore(accToggler, $(vmAccordionId).accParentItems[i].firstChild);
		$(vmAccordionId).accTogglers.push(accToggler);
        $(vmAccordionId).accElements.push($(vmAccordionId).accParentItems[i].getElementsByTagName('ul')[0]);

        if ( $(vmAccordionId).accParentItems[i].className.indexOf('active') >= 0 ) {
            startItem = i;
        }
   }
   if ( $(vmAccordionId).accParentItems.length > 0 ){
        $(vmAccordionId).Accordion = new Accordion($(vmAccordionId).accTogglers, $(vmAccordionId).accElements, $merge({
            opacity: false,
            alwaysHide: true,
            show: startItem,
            duration: 400,
            transition: Fx.Transitions.Bounce.easeOut,

            onActive: function(toggler, element){
                element.parentNode.parentNode.setStyle('height', 'auto');
                toggler.setAttribute("class","Collapse");
            },
            onBackground: function(toggler, element){
                element.parentNode.parentNode.setStyle('height', 'auto');
                element.setStyle('height', element.offsetHeight+'px');
                toggler.setAttribute("class","Expand");
            }

            }, accOptions)

        );
    }
    accTimer = null;
    if (!accHoverDelay) var accHoverDelay = 200;
	
    for(var i = 0; i < $(vmAccordionId).accParentItems.length; i++) {

        eval("function accOnclickFunc(){" +
        		"return function(){ " +
	        		"if( $('"+vmAccordionId+"').accElements["+i+"].style.height == '0px' ) { " +
	        				"$('"+vmAccordionId+"').Accordion.display("+i+") " +
	        		"}" +
        		"}" +
        	"}");
		eval("function accOnMouseoverFunc(){" +
				"return function(){" +
					"if( $('"+vmAccordionId+"').accElements["+i+"].style.height == '0px' ){" +
						"accTimer = $('"+vmAccordionId+"').Accordion.display.delay("+accHoverDelay+", $('"+vmAccordionId+"').Accordion, "+i+");" +
						"}" +
				"}" +
			"}");
		eval("function accOnmouseoutFunc(){return function(){if($defined(accTimer)){$clear(accTimer);}}}");

        $(vmAccordionId).accParentItems[i].firstChild.nextSibling.onclick = accOnclickFunc();
		if (mouseHover==1) {
			$(vmAccordionId).accParentItems[i].firstChild.nextSibling.onmouseover = accOnMouseoverFunc();
        }
		$(vmAccordionId).accParentItems[i].firstChild.nextSibling.onmouseout = accOnmouseoutFunc();
    }
    
    for(var i = 0; i < $(vmAccordionId).accElements.length; i++) {
        $(vmAccordionId).accElements[i].setAttribute('id', vmAccordionId+'_'+i);
        jv_vmAccordionMenu(vmAccordionId+'_'+i, spanExpant, spanCollapse, accOptions, accHoverDelay, mouseHover)
    }

}
}
