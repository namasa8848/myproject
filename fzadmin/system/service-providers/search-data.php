<?php

include "../../../conf/config.php";

    /* The search input from user ** passed from jQuery .get() method */
    $param = $_GET["searchData"];
    $scat = $_GET["scat"];

if ( $scat == "0" )
{ $adddata =""; }
else
{ $adddata = "AND rcity='".$scat."'"; }


    /* If connection to database, run sql statement. */


        /* Fetch the users input from the database and put it into a
         valuable $fetch for output to our table. */



$fetch = mysql_query("SELECT * FROM rests WHERE (name LIKE '%{$param}%' OR id LIKE '%{$param}%' OR gsm LIKE '%{$param}%') $adddata ORDER BY updated desc");

$data_total = mysql_num_rows($fetch);

        /*
           Retrieve results of the query to and build the table.
           We are looping through the $fetch array and populating
           the table rows based on the users input.
         */

echo "<tr><td colspan='6' style='padding:15px 0px 15px 0px;'>Search Results: " . $param . "</td>";
echo "<td colspan='4' style='padding:15px 0px 15px 0px;text-align:right;'>Total Results: " . $data_total . "</td></tr>";

while ( $row = mysql_fetch_object( $fetch ) ) {
$sResults .= '<tr id="fp_'. $row->id . '" onmouseover="ChangeBackgroundColor(this)" onmouseout="RestoreBackgroundColor(this)">';

$sResults .= '<td>' . $row->id . '</td>';

$sResults .= '<td><b><a href="rest.php?id=' . $row->id . '">' . $row->name . '</a></b>';

if( $row->flash == 1 )
{ $sResults .= '&nbsp; <img src="../images/new.gif"></td>'; }
else
{ $sResults .= '</td>'; }


$sResults .= '<td>' . $row->gsm . '</td>';

$sResults .= '<td>' . $row->fz_comm . '%</td>';


if( $row->priority == 0 )
{ $sResults .= '<td> &nbsp; </td>'; }
else
{ $sResults .= '<td>' . $row->priority . '</td>'; }


if( $row->discount == 0 )
{ $sResults .= '<td> &nbsp; </td>'; }
else
{ $sResults .= '<td>' . $row->discount . '%</td>'; }


if( $row->dis_min == 0 )
{ $sResults .= '<td> &nbsp; </td>'; }
else
{ $sResults .= '<td>' . SetPrice($row->dis_min) . '</td>'; }

if( $row->delivery_type == 1 )
{ $sResults .= '<td>SELF</td>'; }
else if( $row->delivery_type == 2 )
{ $sResults .= '<td><font color="blue">FZ EXPRESS</font></td>'; }
else
{ $sResults .= '<td><font color="red">None</font></td>'; }

if( $row->status == 1 )
{ $sResults .= '<td><font color="green">OPEN</font></td>'; }
else
{ $sResults .= '<td><font color="red">CLOSED</font></td>'; }


$sResults .= '<td>' . $row->rcity . '</td></tr>';


}


    /* Free connection resources. */
    mysql_close($conn);

    /* Toss back the results to populate the table. */
    echo $sResults;

?>