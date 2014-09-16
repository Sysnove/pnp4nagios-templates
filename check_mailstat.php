<?php
#
# Copyright (c) 2006-2010 Guillaume Subiron (http://www.sysnove.fr)
# Plugin: check_ldap3
#

include("style.php");

$ds_name[1] = "Mails stats";
$opt[1] = " --vertical-label \"mail(s) / min\" --title \"Mail stats for $hostname\" $options $colors ";

$def[1] = rrd::def("sent", $RRDFILE[1], $DS[1], "AVERAGE");
$def[1] .= rrd::def("received", $RRDFILE[2], $DS[2], "AVERAGE");
$def[1] .= rrd::def("bounced", $RRDFILE[3], $DS[3], "AVERAGE");
$def[1] .= rrd::def("rejected", $RRDFILE[4], $DS[4], "AVERAGE");
$def[1] .= rrd::def("virus", $RRDFILE[5], $DS[5], "AVERAGE");
$def[1] .= rrd::def("spam", $RRDFILE[6], $DS[6], "AVERAGE");

$def[1] .= "COMMENT:\"\\t\\t\\tLAST\\t\\tAVERAGE\\t\\tMAX\\n\" " ;

$def[1] .= rrd::line2("sent", "#008000", "Sent\\t\\t ");
//$def[1] .= rrd::gprint("sent", array("LAST", "AVERAGE", "MAX"), "%6.2lf mail(s)/min");
$def[1] .= "GPRINT:sent:LAST:\"%6.2lf\\t\"  " ;
$def[1] .= "GPRINT:sent:AVERAGE:\" %6.2lf\\t\\t\"   " ;
$def[1] .= "GPRINT:sent:MAX:\" %6.2lf\\n\" " ;

$def[1] .= rrd::line2("received", "#0C64E8", "Received\\t ");
//$def[1] .= rrd::gprint("received", array("LAST", "AVERAGE", "MAX"), "%6.2lf mail(s)/min");
$def[1] .= "GPRINT:received:LAST:\"%6.2lf\\t\" " ;
$def[1] .= "GPRINT:received:AVERAGE:\" %6.2lf\\t\\t\" " ;
$def[1] .= "GPRINT:received:MAX:\" %6.2lf\\n\" " ;

$def[1] .= rrd::line2("bounced", "#BF8300", "Bounced\\t ");
//$def[1] .= rrd::gprint("bounced", array("LAST", "AVERAGE", "MAX"), "%6.2lf mail(s)/min");
$def[1] .= "GPRINT:bounced:LAST:\"%6.2lf\\t\" " ;
$def[1] .= "GPRINT:bounced:AVERAGE:\" %6.2lf\\t\\t\" " ;
$def[1] .= "GPRINT:bounced:MAX:\" %6.2lf\\n\" " ;

$def[1] .= rrd::line2("rejected", "#FFA500", "Rejected\\t ");
//$def[1] .= rrd::gprint("rejected", array("LAST", "AVERAGE", "MAX"), "%6.2lf mail(s)/min");
$def[1] .= "GPRINT:rejected:LAST:\"%6.2lf\\t\" " ;
$def[1] .= "GPRINT:rejected:AVERAGE:\" %6.2lf\\t\\t\" " ;
$def[1] .= "GPRINT:rejected:MAX:\" %6.2lf\\n\" " ;

$def[1] .= rrd::line2("virus", "#FF0000", "Virus\\t\\t ");
//$def[1] .= rrd::gprint("virus", array("LAST", "AVERAGE", "MAX"), "%6.2lf mail(s)/min");
$def[1] .= "GPRINT:virus:LAST:\"%6.2lf\\t\" " ;
$def[1] .= "GPRINT:virus:AVERAGE:\" %6.2lf\\t\\t\" " ;
$def[1] .= "GPRINT:virus:MAX:\" %6.2lf\\n\" " ;

$def[1] .= rrd::line2("spam", "#FF00FF", "Spam\\t\\t ");
//$def[1] .= rrd::gprint("spam", array("LAST", "AVERAGE", "MAX"), "%6.2lf mail(s)/min");
$def[1] .= "GPRINT:spam:LAST:\"%6.2lf\\t\" " ;
$def[1] .= "GPRINT:spam:AVERAGE:\" %6.2lf\\t\\t\" " ;
$def[1] .= "GPRINT:spam:MAX:\" %6.2lf\\n\" " ;

?>
