<?php
class MyHeader{
   function show_header(){
		$obj =& get_instance();
		$obj->load->helper('url');
		$header = "<div id='header'>";
		$header .= "<a href='http://www.inteligenciamecanica.com'>";
		$header .= "<span style='font-family: Gill Sans MT; font-weight: bold; font-size:14pt;'>INTELIGENCIA</span>
				   <br style='font-family: Gill Sans MT;'><span style='font-family: Gill Sans MT;font-weight: bold; font-size:14pt;'>MEC&Aacute;NICA</span>
				   ";
		$header	.= "</a>";
		$header .= "<a align='right' href='http://www.stihl.com.mx'>";
		$header .= "<img src='http://www.stihl.com.mx/stihl-mx/logo.gif' border='0' height='22' width='108' align='right'>";
		$header .= "</a>";
		$header .= "</div>";
		return $header;
		}
	}
?>