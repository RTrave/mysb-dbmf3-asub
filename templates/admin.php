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
$dbmf_groups = MySBDBMFGroupHelper::load();


echo '
<div class="content">
  <h1 id="autosubs">'._G('DBMF_autosubs_config').'</h1>

<form action="'.$httpbase.'#autosubs" method="post">
  <div class="row checkbox-list">';

$blockrefs = MySBDBMFBlockRefHelper::load();
foreach( $blockrefs as $blockref ) {
    echo '
    <label for="'.$blockref->keyname.'">
      <input type="checkbox" name="'.$blockref->keyname.'"
             "'.MySBUtil::form_ischecked($blockref->autosubs,"1").'" id="'.$blockref->keyname.'">
      <i>'._G($blockref->lname).'</i>
    </label>';
}
echo '
  </div>
  <div class="row">
    <div class="col-sm-3"></div>
    <div class="col-sm-6">
      <input type="hidden" name="dbmf_autosubs" value="1">
      <input type="submit" class="btn-primary"
             value="'._G('DBMF_autosubs_configsubmit').'">
    </div>
    <div class="col-sm-3"></div>
  </div>
</form>

</div>

<div class="content">
  <h1 id="autosubs-reset">'._G('DBMF_autosubs_reset').'</h1>';

if( $bradd!='' )
  echo '
<form action="'.$httpbase.'#autosubs-reset" method="post"
        OnSubmit="return mysb_confirm(\'Reset autosubs pin in ALL contacts ?\')">
  <div class="row">
    <div class="col-sm-3"></div>
    <div class="col-sm-6">
      <input type="hidden" name="dbmf_autosubs_resetblockref" value="1">
      <input type="submit" class="btn-danger"
             value="'._G('DBMF_autosubs_resetblockref').': '.$bradd.'">
    </div>
    <div class="col-sm-3"></div>
  </div>
</form>';
else
  echo '
  <div class="row">
    <div class="col-sm-3"></div>
    <div class="col-sm-6">
      '._G('DBMF_autosubs_resetblockref_unset').'
    </div>
    <div class="col-sm-3"></div>
  </div>';

if( $datebr!='' )
  echo '
<form action="'.$httpbase.'#autosubs-reset" method="post"
        OnSubmit="return mysb_confirm(\'Reset autosubs dates in ALL contacts ?\')">
  <div class="row">
    <div class="col-sm-3"></div>
    <div class="col-sm-6">
      <input type="hidden" name="dbmf_autosubs_resetdatebr" value="1">
      <input type="submit" class="btn-danger"
             value="'._G('DBMF_autosubs_resetdatebr').': '.$datebr.'">
    </div>
    <div class="col-sm-3"></div>
  </div>
</form>';
else
  echo '
  <div class="row">
    <div class="col-sm-3"></div>
    <div class="col-sm-6">
      '._G('DBMF_autosubs_resetdatebr_unset').'
    </div>
    <div class="col-sm-3"></div>
  </div>';

echo '
</div>';

?>
