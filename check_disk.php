<?php
#
# Copyright (c) 2006-2010 Joerg Linge (http://www.pnp4nagios.org)
# Template for check_disk
#
# RRDtool Options
#

include("style.php");

$i = 0;

foreach ($this->DS as $KEY=>$VAL) {
# set initial values
	$fmt = '%7.3lf';
	$pct = '';
	$upper = "";
	$maximum = "";
	$divis = 1;
	$return = '\n';
	$unit = "B";
	$label = $unit;
	if ($VAL['UNIT'] != "") {
		$unit = $VAL['UNIT'];
		$label = $unit;
		if ($VAL['UNIT'] == "%%") {
			$label = '%';
			$fmt = '%5.1lf';
			$pct = '%';
		}
	}
	if ($VAL['MAX'] != "") {
		# adjust value and unit, details in .../helpers/pnp.php
		$max = pnp::adjust_unit( $VAL['MAX'].$unit,1024,$fmt );
		$upper = $max[1]; 
		$maximum = "of $max[1] $max[2]$pct used";
		$label = $max[2];
		$divis = $max[3];
		$return = '';
	}
	$name = str_replace("_","/",$VAL['NAME']);

    if ($name == "/dev"
        || $name == "/run"
        || $name == "/run/shm"
        || $name == "/run/lock") {
        continue;
    }

    $i++;

    $ds_name[$i] = $name;
	# set graph labels
	$opt[$i]     = "--vertical-label $label -l 0 -u $upper --title \"Filesystem $ds_name[$i]\" $colors $options ";
	# Graph Definitions
	$def[$i]     = rrd::def( "var1", $VAL['RRDFILE'], $VAL['DS'], "AVERAGE" ); 
	# "normalize" graph values
	$def[$i]    .= rrd::cdef( "v_n","var1,$divis,/");
	$def[$i]    .= rrd::area( "v_n", $gray);
	$def[$i]    .= rrd::line2( "v_n", $main_color, $ds_name[$i] );
	# show values in legend
	$def[$i]    .= rrd::gprint( "v_n", "LAST", "$fmt $label$pct $maximum ");
	$def[$i]    .= rrd::gprint( "v_n", "AVERAGE", "$fmt $label$pct avg used $return");
	# create max line and legend
	if ($VAL['MAX'] != "") {
		$def[$i] .= rrd::gprint( "v_n", "MAX", "$fmt $label$pct max used \\n" );
		$def[$i] .= rrd::hrule( $max[1], $black, "Size of FS $max[0]");
	}
	# create warning line and legend
	if ($VAL['WARN'] != "") {
		$warn = pnp::adjust_unit( $VAL['WARN'].$unit,1024,$fmt );
		$def[$i] .= rrd::hrule( $warn[1], $warn_color, "Warning  on $warn[0]" );
	}
	# create critical line and legend
	if ($VAL['CRIT'] != "") {
		$crit = pnp::adjust_unit( $VAL['CRIT'].$unit,1024,$fmt );
		$def[$i] .= rrd::hrule( $crit[1], $crit_color, "Critical on $crit[0]" );
	}
}
?>
