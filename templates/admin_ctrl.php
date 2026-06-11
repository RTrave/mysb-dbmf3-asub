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
            $blockref->update(array('autosubs' => '0'));
    }
}

if (isset($_POST["dbmf_autosubs_denytext"])) {
    // echo $_POST["message_deny"]."br";
    $config_deny = MySBConfigHelper::get("dbmf_autosubs_denytext","dbmf3_asub");
    $config_deny->setValue($_POST["message_deny"]);
}

if (isset($_POST["dbmf_autosubs_blockedit"])) {
    $ruleblocks = MySBDBMFBlockHelper::load();
    $brules = MySBDBMFASubRuleHelper::blocksLoad();
    foreach($ruleblocks as $ruleblock) {
        // echo "TUTU<br>";
        // if(isset($_POST["body_".$ruleblock->id])) {
        //     echo 'BODY_'.$ruleblock->id.'<br>';
        //     echo $_POST["body_".$ruleblock->id].'<br>';
        // }
        // if(isset($_POST["selectmax_".$ruleblock->id])) {
        //     echo 'SELMAX_'.$ruleblock->id.'<br>';
        //     echo $_POST["selectmax_".$ruleblock->id].'<br>';
        // }
        if(!isset($brules[$ruleblock->id])) {
            $req_rblocks = MySBDB::query(
                "INSERT INTO " . MySB_DBPREFIX . "dbmfasubblocks " .
                '(block_id,comments,sel_max) VALUES ('.$ruleblock->id.',"'.
                $_POST["body_".$ruleblock->id].'",'.
                $_POST["selectmax_".$ruleblock->id].')',
                "admin_ctrl",
                true,
                'dbmf3_asub',
                true
            );
        }
        else {
            $req_rblocks = MySBDB::query(
                "UPDATE " . MySB_DBPREFIX . "dbmfasubblocks SET " .
                'comments="'.MySBUtil::str2db($_POST["body_".$ruleblock->id]).'",'.
                'sel_max='.$_POST["selectmax_".$ruleblock->id].
                ' WHERE block_id='.$ruleblock->id,
                "admin_ctrl",
                true,
                'dbmf3_asub',
                true
            );
        }
    }
}

if (isset($_POST["dbmf_autosubs_rulenew"])) {
    MySBDBMFASubRuleHelper::create();
    // $current_rule = new MySBDBMFASubRule(-1);
    // $rdata = [];
    // $current_rule->update($rdata);
}
if (isset($_GET["rule_delete"])) {
    MySBDBMFASubRuleHelper::delete($_GET["rule_delete"]);
    // $current_rule = new MySBDBMFASubRule(-1);
    // $rdata = [];
    // $current_rule->update($rdata);
}
if (isset($_POST['dbmf_autosubs_ruleupdate'])) {
    $blockrefs = MySBDBMFBlockRefHelper::load();
    $br_csv = new MySBCSValues(null,true);
    foreach ($blockrefs as $blockref) {

        if (isset($_POST[$blockref->keyname]) && $blockref->autosubs==1 ) {
            // echo $blockref->keyname;
            $br_csv->add($blockref->keyname);}

        //print_r($_POST);
        //echo $blockref->keyname.':'.$_POST[$blockref->keyname].' / ';
    }
    // foreach($br_csv->values as $brrr)
    //     echo '!'.$brrr.'<br>';
    // echo $br_csv->csstring().'<br>';
    $rule_mod = new MySBDBMFASubRule($_POST['dbmf_autosubs_ruleupdate']);
    // echo $_POST['dbmf_autosubs_ruleupdate'].'<br>'.$rule_mod->brids;
    // foreach($rule_mod->rulebrs as $brrr)
    //     echo '<br>*'.$brrr;
    // echo $rule_mod->rulebrs;
    $rule_mod->update(array('brids' => $br_csv->csstring()));
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