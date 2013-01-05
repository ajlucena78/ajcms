<meta content="application/xhtml+xml;charset=ISO-8859-1" http-equiv="Content-Type" />
<link href="<?php echo $_SESSION['config']->getPathApp(); ?>/view/css/admin.css" rel="stylesheet" 
		type="text/css" />
<script type="text/javascript" src="<?php echo $_SESSION['config']->getPathApp(); 
		?>/view/js/funciones_capas.js"></script>
<script type="text/javascript" src="<?php echo $_SESSION['config']->getPathApp(); ?>/view/js/loader.js"></script>
<?php
	if (!isset($INCLUYE_TINYMCE))
		$INCLUYE_TINYMCE = false;
	if ($INCLUYE_TINYMCE) { ?>
	<!-- tinyMCE -->
	<script type="text/javascript" src="<?php echo $_SESSION['config']->getPathApp(); 
			?>/view/js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
	<script type="text/javascript">
		tinyMCE.init({
			mode : "textareas",
					theme : "advanced",
					plugins : "safari,spellchecker,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,pagebreak,imagemanager,filemanager",
					theme_advanced_buttons1_add_before : "save,newdocument,separator",
					theme_advanced_buttons1_add : "fontselect,fontsizeselect",
					theme_advanced_buttons2_add : "separator,insertdate,inserttime,preview,separator,forecolor,backcolor",
					theme_advanced_buttons2_add_before: "cut,copy,paste,pastetext,pasteword,separator,search,replace,separator",
					theme_advanced_buttons3_add_before : "tablecontrols,separator",
					theme_advanced_buttons3_add : "emotions,iespell,media,advhr,separator,print,separator,ltr,rtl,separator,fullscreen",
					theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,spellchecker,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,blockquote,pagebreak,|,insertfile,insertimage",
					theme_advanced_toolbar_location : "top",
					theme_advanced_toolbar_align : "left",
					theme_advanced_statusbar_location : "bottom",
					content_css : "<?php echo $_SESSION['config']->getPathApp(); ?>/view/css/style.css",
							plugin_insertdate_dateFormat : "%d/%m/%Y",
							plugin_insertdate_timeFormat : "%H:%M:%S",
							theme_advanced_resize_horizontal : false,
							theme_advanced_resizing : true,
							apply_source_formatting : true,
							language : "es",
							valid_elements : "@[id|class|style|title|dir<ltr?rtl|lang|xml::lang|onclick|ondblclick|"
                                + "onmousedown|onmouseup|onmouseover|onmousemove|onmouseout|onkeypress|"
                                + "onkeydown|onkeyup],a[rel|rev|charset|hreflang|tabindex|accesskey|type|"
                                + "name|href|target|title|class|onfocus|onblur],strong/b,em/i,strike,u,"
                                + "#p,-ol[type|compact],-ul[type|compact],-li,br,img[longdesc|usemap|"
                                + "src|border|alt=|title|hspace|vspace|width|height|align],-sub,-sup,"
                                + "-blockquote,-table[border=0|cellspacing|cellpadding|width|frame|rules|"
                                + "height|align|summary|bgcolor|background|bordercolor],-tr[rowspan|width|"
                                + "height|align|valign|bgcolor|background|bordercolor],tbody,thead,tfoot,"
                                + "#td[colspan|rowspan|width|height|align|valign|bgcolor|background|bordercolor"
                                + "|scope],#th[colspan|rowspan|width|height|align|valign|scope],caption,-div,"
                                + "-span,-code,-pre,address,-h1,-h2,-h3,-h4,-h5,-h6,hr[size|noshade],-font[face"
                                + "|size|color],dd,dl,dt,cite,abbr,acronym,del[datetime|cite],ins[datetime|cite],"
                                + "object[classid|width|height|codebase|*],param[name|value|_value],embed[type|width"
                                + "|height|src|*],script[src|type],map[name],area[shape|coords|href|alt|target],bdo,"
                                + "button,col[align|char|charoff|span|valign|width],colgroup[align|char|charoff|span|"
                                + "valign|width],dfn,fieldset,form[action|accept|accept-charset|enctype|method],"
                                + "input[accept|alt|checked|disabled|maxlength|name|readonly|size|src|type|value],"
                                + "kbd,label[for],legend,noscript,optgroup[label|disabled],option[disabled|label|selected|value],"
                                + "q[cite],samp,select[disabled|multiple|name|size],small,"
                                + "textarea[cols|rows|disabled|name|readonly],tt,var,big,iframe[*]"
				});
			</script>
	<!-- /tinyMCE -->
<?php } ?>
<link rel="stylesheet" type="text/css" media="all" href="<?php echo $_SESSION['config']->getPathApp(); 
		?>/view/js/jscalendar-1.0/calendar-fps.css" />
<script type="text/javascript" src="<?php echo $_SESSION['config']->getPathApp(); 
		?>/view/js/flowplayer-3.2.4.min.js"></script>
<!-- <link rel="stylesheet" type="text/css" href="<?php echo $_SESSION['config']->getPathApp(); 
		?>/view/css/flowplayer.css"> -->
<style type="text/css">
	a.myPlayer
	{
		display:block;
		border:1px solid #999;
	}
	a.myPlayer img
	{
		margin-top:70px;
		border:0px;
	}
	a.myPlayer:hover
	{
		border:1px solid #000;
	}
</style>