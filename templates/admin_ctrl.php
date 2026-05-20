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

if (!MySBRoleHelper::checkAccess('admin'))
    return;

if (isset($_POST['dbmf_autosubs'])) {
    $blockrefs = MySBDBMFBlockRefHelper::load();
    foreach ($blockrefs as $blockref) {
        //print_r($_POST);
        //echo $blockref->keyname.':'.$_POST[$blockref->keyname].' / ';
        if ($blockref->autosubs == 1)
            $autosubs = 'on';
        else
            $autosubs = '';
        if (isset($_POST[$blockref->keyname]) and $_POST[$blockref->keyname] != $autosubs)
            $blockref->update(array('autosubs' => '1'));
        if (!isset($_POST[$blockref->keyname]) and $autosubs == 'on')
            $blockref->update(array('autosubs' => ''));
    }
}

$bradd = MySBConfigHelper::Value('dbmf_autosubs_blockref', 'dbmf3_asub');
$datebr = MySBConfigHelper::Value('dbmf_autosubs_datebr', 'dbmf3_asub');

if (isset($_POST['dbmf_autosubs_resetblockref'])) {
    $pinbr_sql = "UPDATE " . MySB_DBPREFIX . "dbmfcontacts SET " . $bradd . "='';";
    $pinbr_req = MySBDB::query($pinbr_sql);
}

if (isset($_POST['dbmf_autosubs_resetdatebr'])) {
    $datebr_sql = "UPDATE " . MySB_DBPREFIX . "dbmfcontacts SET " . $datebr . "='0000-00-00 00:00:00';";
    $datebr_req = MySBDB::query($datebr_sql);
}

include(_pathT('admin', 'dbmf3_asub'));

?>