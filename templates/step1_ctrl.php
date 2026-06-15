<?php
/***************************************************************************
 *
 *   phpMySandBox/DBMF3AutoSubs - RTrave<roman.trave@abadcafe.org> - 2018
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License', or
 *   ('at your option) any later version.
 *
 ***************************************************************************/

// No direct access.
defined('_MySBEXEC') or die;

global $app;

if (MySBConfigHelper::Value('dbmf_autosubs_anonaccess', 'dbmf3_asub') != 1) {
    if (!MySBRoleHelper::checkAccess('dbmf_autosubs', false)) {
        $app->displayStopAlert(_G(MySBConfigHelper::Value('dbmf_autosubs_denytext', 'dbmf3_asub')));
        return;
    }

}
$datestart_t = MySBConfigHelper::Value('dbmf_autosubs_datestart', 'dbmf3_asub');
if ($datestart_t) {
    $date_start = new MySBDateTime($datestart_t);
    // echo "TA:" . $date_start->absDiff("i");
    if ($date_start->absDiff("i") < 0) {
        $app->displayStopAlert(_G(MySBConfigHelper::Value('dbmf_autosubs_denytext', 'dbmf3_asub')) . 
            "<br><small><i>start date: " . $date_start->html() . "</i></small><br>");
    }
}
$datestop_t = MySBConfigHelper::Value('dbmf_autosubs_datestop', 'dbmf3_asub');
if ($datestop_t && $datestop_t != $datestart_t) {
    $date_stop = new MySBDateTime($datestop_t);
    // echo "TB:" . $date_stop->absDiff("i");
    if ($date_stop->absDiff("i") > 0) {
        $app->displayStopAlert(_G(MySBConfigHelper::Value('dbmf_autosubs_denytext', 'dbmf3_asub')) . 
            "<br><small><i>stop date: " . $date_stop->html() . "</i></small>");
    }
}


include(_pathT('step1', 'dbmf3_asub'));

?>