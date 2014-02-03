<?php
#
# Copyright (c) 2006-2010 Guillaume Subiron (http://www.sysnove.fr)
# Plugin: check_ldap3
#

$ds_name[1] = "Mails stats";
$opt[1] = " --vertical-label \"mail(s) / min\" --title \"Mail stats for $hostname\" ";

$def[1] = rrd::def("sent", $RRDFILE[1], $DS[1], "AVERAGE");
$def[1] .= rrd::def("received", $RRDFILE[2], $DS[2], "AVERAGE");
$def[1] .= rrd::def("bounced", $RRDFILE[3], $DS[3], "AVERAGE");
$def[1] .= rrd::def("rejected", $RRDFILE[4], $DS[4], "AVERAGE");
$def[1] .= rrd::def("virus", $RRDFILE[5], $DS[5], "AVERAGE");
$def[1] .= rrd::def("spam", $RRDFILE[6], $DS[6], "AVERAGE");

$def[1] .= rrd::line1("sent", "#11AD00", "Sent");
$def[1] .= rrd::gprint("sent", array("LAST", "AVERAGE", "MAX"), "%6.2lf mail(s)/min");
$def[1] .= rrd::line1("received", "#001EFF", "Received");
$def[1] .= rrd::gprint("received", array("LAST", "AVERAGE", "MAX"), "%6.2lf mail(s)/min");
$def[1] .= rrd::line1("bounced", "#BF8300", "Bounced");
$def[1] .= rrd::gprint("bounced", array("LAST", "AVERAGE", "MAX"), "%6.2lf mail(s)/min");
$def[1] .= rrd::line1("rejected", "#FFFF00", "Rejected");
$def[1] .= rrd::gprint("rejected", array("LAST", "AVERAGE", "MAX"), "%6.2lf mail(s)/min");
$def[1] .= rrd::line1("virus", "#FF0000", "Virus");
$def[1] .= rrd::gprint("virus", array("LAST", "AVERAGE", "MAX"), "%6.2lf mail(s)/min");
$def[1] .= rrd::line1("spam", "#FF00FF", "Spam");
$def[1] .= rrd::gprint("spam", array("LAST", "AVERAGE", "MAX"), "%6.2lf mail(s)/min");

?>
