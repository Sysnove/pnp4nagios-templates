<?php
#
# Copyright (c) 2006-2010 Joerg Linge (http://www.pnp4nagios.org)
# Default Template used if no other template is found.
# Don`t delete this file ! 
#
# Define some colors ..

include("style.php");

$_WARNRULE = $warn_color;
$_CRITRULE = $crit_color;
$_AREA     = $gray;
$_LINE     = $main_color;
#
# Initial Logic ...
#

foreach ($this->DS as $KEY=>$VAL) {

	$maximum  = "";
	$minimum  = "";
	$critical = "";
	$crit_min = "";
	$crit_max = "";
	$warning  = "";
	$warn_max = "";
	$warn_min = "";
	$vlabel   = " ";
	$lower    = "";
	$upper    = "";
	
	if ($VAL['WARN'] != "") {
		$warning = $VAL['WARN'];
	}
	if ($VAL['WARN_MAX'] != "") {
		$warn_max = $VAL['WARN_MAX'];
	}
	if ($VAL['WARN_MIN'] != "") {
		$warn_min = $VAL['WARN_MIN'];
	}
	if ($VAL['CRIT'] != "") {
		$critical = $VAL['CRIT'];
	}
	if ($VAL['CRIT_MAX'] != "") {
		$crit_max = $VAL['CRIT_MAX'];
	}
	if ($VAL['CRIT_MIN'] != "") {
		$crit_min = $VAL['CRIT_MIN'];
	}
	if ($VAL['MIN'] != "") {
		$lower = " --lower=" . $VAL['MIN'];
		$minimum = $VAL['MIN'];
	}
	if ($VAL['MAX'] != "") {
		$maximum = $VAL['MAX'];
	}
	if ($VAL['UNIT'] == "%%") {
		$vlabel = "%";
		$upper = " --upper=101 ";
		$lower = " --lower=0 ";
	}
	else {
		$vlabel = $VAL['UNIT'];
	}

	$opt[$KEY] = '--vertical-label "' . $vlabel . '" --title "' . $this->MACRO['DISP_HOSTNAME'] . ' / ' . $this->MACRO['DISP_SERVICEDESC'] . '"' . $upper . $lower . " $options $colors";
	$ds_name[$KEY] = $VAL['LABEL'];
	$def[$KEY]  = rrd::def     ("var1", $VAL['RRDFILE'], $VAL['DS'], "AVERAGE");
	//$def[$KEY] .= rrd::gradient("var1", "3152A5", "BDC6DE", rrd::cut($VAL['NAME'],16), 20);
	$def[$KEY] .= rrd::line2   ("var1", $_LINE, rrd::cut($VAL['NAME'],16) );
	$def[$KEY] .= rrd::gprint  ("var1", array("LAST","MAX","AVERAGE"), "%3.4lf %S".$VAL['UNIT']);
	if ($warning != "") {
		$def[$KEY] .= rrd::hrule($warning, $_WARNRULE, "Warning  $warning \\n");
	}
	if ($warn_min != "") {
		$def[$KEY] .= rrd::hrule($warn_min, $_WARNRULE, "Warning  (min)  $warn_min \\n");
	}
	if ($warn_max != "") {
		$def[$KEY] .= rrd::hrule($warn_max, $_WARNRULE, "Warning  (max)  $warn_max \\n");
	}
	if ($critical != "") {
		$def[$KEY] .= rrd::hrule($critical, $_CRITRULE, "Critical $critical \\n");
	}
	if ($crit_min != "") {
		$def[$KEY] .= rrd::hrule($crit_min, $_CRITRULE, "Critical (min)  $crit_min \\n");
	}
	if ($crit_max != "") {
		$def[$KEY] .= rrd::hrule($crit_max, $_CRITRULE, "Critical (max)  $crit_max \\n");
	}
	$def[$KEY] .= rrd::comment("Default Template\\r");
	$def[$KEY] .= rrd::comment("Command " . $VAL['TEMPLATE'] . "\\r");
}
?>
