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

$httpbase = 'index.php?tpl=admin/admin&amp;page=admin&amp;module=dbmf3_asub';
// $dbmf_groups = MySBDBMFGroupHelper::load();
// echo ' -T-'.$GET["rule"].'<br>';
if (isset($_POST["dbmf_autosubs_rulenew"])) {
    $current_rule = new MySBDBMFASubRule(-1);
    $rdata = [];
    $current_rule->update($rdata);
} else
    $current_rule = new MySBDBMFASubRule($_GET["rule"]);
$brs_cs = new MySBCSValues($current_rule->brids, true);
// echo '/'.$current_rule->brids;

echo '
<div class="content">
  <h1 id="autosubs">' . _G('DBMF_autosubs_rulesconfig') . '</h1>
  <h2>Rule: ' . $current_rule->id . '</h2>
  
<form action="' . $httpbase . '#autosubsrules" method="post">
  <div class="row checkbox-list">';

$blockrefs = MySBDBMFBlockRefHelper::load();
foreach ($blockrefs as $blockref) {
    // echo '/'.$brs_cs->csstring();
    $check_status = '';
    if ($brs_cs->have($blockref->keyname))
        $check_status = ' checked=checked ';
    if ($blockref->autosubs)
        echo '
    <label for="' . $blockref->keyname . '" title="' . $blockref->keyname . '">
      <input type="checkbox" name="' . $blockref->keyname . '"
             "' . $check_status . '" id="' . $blockref->keyname . '">
      <i>' . _G($blockref->lname) . '</i>
    </label>';
}
echo '
  </div>
  <div class="row">
    <div class="col-sm-3"></div>
    <div class="col-sm-6">
      <input type="hidden" name="dbmf_autosubs_ruleupdate" value="' . $current_rule->id . '">
      <input type="submit" class="btn-primary"
             value="' . _G('DBMF_autosubs_configsubmit') . '">
    </div>
    <div class="col-sm-3"></div>
  </div>
</form>

</div>
';

?>