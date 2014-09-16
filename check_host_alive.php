<?php
#
# Copyright (c) 2006-2010 Joerg Linge (http://www.pnp4nagios.org)
# Plugin: check_icmp [Multigraph]
#
# RTA
#

include("style.php");

# Ping
$ds_name[1] = "Round Trip Times";
$opt[1]  = "--vertical-label \"RTA\"  --title \"Ping times\" $options $colors ";
$def[1]  =  rrd::def("var1", $RRDFILE[1], $DS[1], "AVERAGE") ;
$def[1] .=  rrd::line2("var1", $main_color, "Round Trip Times") ;
$def[1] .=  rrd::gprint("var1", array("LAST", "MAX", "AVERAGE"), "%6.2lf $UNIT[1]") ;

if($WARN[1] != ""){
	if($UNIT[1] == "%%"){ $UNIT[1] = "%"; };
  	$def[1] .= rrd::hrule($WARN[1], $warn_color, "Warning ".(int) $WARN[1]." ".$UNIT[1]);
}
if($CRIT[1] != ""){
	if($UNIT[1] == "%%"){ $UNIT[1] = "%"; };
  	$def[1] .= rrd::hrule($CRIT[1], $crit_color, "Critical ".(int) $CRIT[1]." ".$UNIT[1]."\\n");
}

# Packets Lost
$ds_name[2] = "Packets Lost";
$opt[2] = "--vertical-label \"Packets lost\" -l0 -u105 --title \"Packets lost\" $options $colors ";

$def[2]  =  rrd::def("var1", $RRDFILE[2], $DS[2], "AVERAGE");
$def[2] .=  rrd::line2("var1", $main_color, "Packets Lost") ;
$def[2] .=  rrd::gprint("var1", array("LAST", "MAX", "AVERAGE"), "%3.0lf $UNIT[2]") ;

$def[2] .= rrd::hrule("100", $main_color) ;

if($WARN[2] != ""){
	if($UNIT[2] == "%%"){ $UNIT[2] = "%"; };
  	$def[2] .= rrd::hrule($WARN[2], $warn_color, "Warning  ".$WARN[2]." ".$UNIT[2]);
}
if($CRIT[2] != ""){
	if($UNIT[2] == "%%"){ $UNIT[2] = "%"; };
  	$def[2] .= rrd::hrule($CRIT[2], $crit_color, "Critical ".$CRIT[2]." ".$UNIT[2]."\\n");
}

?>
