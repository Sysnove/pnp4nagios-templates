<?php

#   This program is free software; you can redistribute it and/or modify
#   it under the terms of the GNU General Public License as published by
#   the Free Software Foundation; either version 2 of the License, or
#   (at your option) any later version.
#
#   This program is distributed in the hope that it will be useful,
#   but WITHOUT ANY WARRANTY; without even the implied warranty of
#   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
#   GNU General Public License for more details.
#
#   You should have received a copy of the GNU General Public License
#   along with this program; if not, write to the Free Software
#   Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA

#   PNP Template for check_postfix_mailqueue
#   Author: Bjoern Bongermino (http://www.bongermino.de/)

include("style.php");

$opt[1] = "--vertical-label \"Mails \" -l 0 -r --title \"Postfix Mailqueue Stats for $hostname\" $colors $options ";

$def[1]  = "DEF:deferred=$RRDFILE[1]:$DS[1]:AVERAGE " ;
$def[1] .= "DEF:active=$RRDFILE[2]:$DS[2]:AVERAGE " ;
$def[1] .= "DEF:maildrop=$RRDFILE[3]:$DS[3]:AVERAGE " ;
$def[1] .= "DEF:incoming=$RRDFILE[4]:$DS[4]:AVERAGE " ;
$def[1] .= "DEF:corrupt=$RRDFILE[5]:$DS[5]:AVERAGE " ;
$def[1] .= "DEF:hold=$RRDFILE[6]:$DS[6]:AVERAGE " ;

$def[1] .= "COMMENT:\"\\t\\t\\t\\tLAST\\t\\tAVERAGE\\t\\tMAX\\n\" " ;

$def[1] .= "LINE2:deferred#008000:\"deferred\\t\\t \" " ;
$def[1] .= "GPRINT:deferred:LAST:\"%6.0lf\\t\" " ;
$def[1] .= "GPRINT:deferred:AVERAGE:\" %6.0lf\\t\\t\" " ;
$def[1] .= "GPRINT:deferred:MAX:\" %6.0lf\\n\" " ;

$def[1] .= "LINE2:active#0C64E8:\"active\\t\\t \" " ;
$def[1] .= "GPRINT:active:LAST:\"%6.0lf\\t\" " ;
$def[1] .= "GPRINT:active:AVERAGE:\" %6.0lf\\t\\t\" " ;
$def[1] .= "GPRINT:active:MAX:\" %6.0lf\\n\" " ;

$def[1] .= "LINE2:maildrop#E80C3E:\"maildrop\\t\\t \" " ;
$def[1] .= "GPRINT:maildrop:LAST:\"%6.0lf\\t\" " ;
$def[1] .= "GPRINT:maildrop:AVERAGE:\" %6.0lf\\t\\t\" " ;
$def[1] .= "GPRINT:maildrop:MAX:\" %6.0lf\\n\" " ;

$def[1] .= "LINE2:incoming#FFA500:\"incoming\\t\\t \" " ;
$def[1] .= "GPRINT:incoming:LAST:\"%6.0lf\\t\" " ;
$def[1] .= "GPRINT:incoming:AVERAGE:\" %6.0lf\\t\\t\" " ;
$def[1] .= "GPRINT:incoming:MAX:\" %6.0lf\\n\" " ;

$def[1] .= "LINE2:corrupt#1CC8E8:\"corrupt\\t\\t \" " ;
$def[1] .= "GPRINT:corrupt:LAST:\"%6.0lf\\t\" " ;
$def[1] .= "GPRINT:corrupt:AVERAGE:\" %6.0lf\\t\\t\" " ;
$def[1] .= "GPRINT:corrupt:MAX:\" %6.0lf\\n\" " ;

$def[1] .= "LINE2:hold#E80C8C:\"hold\\t\\t\\t \" " ;
$def[1] .= "GPRINT:hold:LAST:\"%6.0lf\\t\" " ;
$def[1] .= "GPRINT:hold:AVERAGE:\" %6.0lf\\t\\t\" " ;
$def[1] .= "GPRINT:hold:MAX:\" %6.0lf\\n\" " ;
?>
