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
  <h1 id="autosubs">' . _G('DBMF_autosubs_config') . '</h1>

<form action="' . $httpbase . '#autosubs" method="post">
  <div class="row checkbox-list">';

$blockrefs = MySBDBMFBlockRefHelper::load();
foreach ($blockrefs as $blockref) {
    echo '
    <label for="' . $blockref->keyname . '" title="' . $blockref->keyname . '">
      <input type="checkbox" name="' . $blockref->keyname . '"
             ' . MySBUtil::form_ischecked($blockref->autosubs, "1") . ' id="' . $blockref->keyname . '">
      <i>' . _G($blockref->lname) . '</i>
    </label>';
}
echo '
  </div>
  <div class="row">
    <div class="col-sm-3"></div>
    <div class="col-sm-6">
      <input type="hidden" name="dbmf_autosubs" value="1">
      <input type="submit" class="btn-primary"
             value="' . _G('DBMF_autosubs_configsubmit') . '">
    </div>
    <div class="col-sm-3"></div>
  </div>
</form>

</div>



<div class="content">
  <h1 id="autosubsblocks">' . _G('DBMF_autosubs_denytext') . '</h1>

<form action="' . $httpbase . '#autosubsblocks" method="post">
  <div class="row checkbox-list">';

$area_id = 'editor_id_'.rand(1,999999);
$editor = new MySBEditor();
echo $editor->init($area_id,"simple");
$deny_text = MySBConfigHelper::Value("dbmf_autosubs_denytext","dbmf3_asub");

echo '
    <div class="col-3">
        '._G('dbmf_autosubs_denytext_entry').'<br>
    </div>
    <div class="col-9">
        <textarea name="message_deny" rows="3"
                class="mceEditor" id="'.$area_id.'">'.$deny_text.'</textarea>
    </div>
  </div>
  <div class="row">
    <div class="col-sm-3"></div>
    <div class="col-sm-6">
      <input type="hidden" name="dbmf_autosubs_denytext" value="1">
      <input type="submit" class="btn-primary"
             value="' . _G('DBMF_autosubs_configsubmit') . '">
    </div>
    <div class="col-sm-3"></div>
  </div>
</form>
</div>

<div class="content">
  <h1 id="autosubsblocks">' . _G('DBMF_autosubs_blocks') . '</h1>

<form action="' . $httpbase . '#autosubsblocks" method="post">
  <div class="row checkbox-list">';

$ruleblocks = MySBDBMFBlockHelper::load();
$brules = MySBDBMFASubRuleHelper::blocksLoad();
foreach($ruleblocks as $ruleblock) {
    $comments = "";
    $sel_max = 0;
    if(isset($brules[$ruleblock->id])) {
        $comments = $brules[$ruleblock->id]->block_comments;
        $sel_max = $brules[$ruleblock->id]->select_max;
    }
    echo '
    <h2>'._G($ruleblock->lname).'</h2>
    <div class="row">
    <div class="col-3">
        '._G('DBMF_autosubs_blocks_entry').'<br>
    </div>
    <div class="col-9">
        <textarea name="body_'.$ruleblock->id.'" rows="3"
                class="mceEditor" id="'.$area_id.'">'.$comments.'</textarea>
    </div>
    </div>
    <div class="row">
    <div class="col-sm-3">
        <select name="selectmax_'.$ruleblock->id.'" id="category">
            <option value="-1" '.MySBUtil::form_isselected($sel_max,-1).'>No selection</option>
            <option value="0" '.MySBUtil::form_isselected($sel_max,0).'>'._G('DBMF_autosubs_nolimit').'</option>
            <option value="1" '.MySBUtil::form_isselected($sel_max,1).'>1</option>
            <option value="2" '.MySBUtil::form_isselected($sel_max,2).'>2</option>
            <option value="3" '.MySBUtil::form_isselected($sel_max,3).'>3</option>
            <option value="4" '.MySBUtil::form_isselected($sel_max,4).'>4</option>
        </select>
    </div>
    <label class="col-sm-9" for="category">
        '._G('DBMF_autosubs_selectmax').'
    </label>
    </div>
';
}

echo '
  </div>
  <div class="row">
    <div class="col-sm-3"></div>
    <div class="col-sm-6">
      <input type="hidden" name="dbmf_autosubs_blockedit" value="1">
      <input type="submit" class="btn-primary"
             value="' . _G('DBMF_autosubs_configsubmit') . '">
    </div>
    <div class="col-sm-3"></div>
  </div>
</form>
</div>

<div class="content">
  <h1 id="autosubsrules">' . _G('DBMF_autosubs_rulesconfig') . '</h1>
  <h2>Existing rules</h2>';

$rules_a = MySBDBMFASubRuleHelper::load();

// $rules_a = ["br1", "br2"];
foreach ($rules_a as $rule) {

    echo '
  <div class="content list">
  <div class="row checkbox-list">
    <form class="col-1 btn btn-primary-light"
          action="index.php?tpl=admin/admin&amp;page=rules&amp;module=dbmf3_asub&amp;rule=' . $rule->id . '#autosubsrules" method="post"
          title="' . _G('DBMF_autosubs_rule_edit') . ' ' . $rule->id . '">
      <input type="hidden" name="dbmf_editexport" value="' . $rule->id . '">
      <input src="images/icons/text-editor.png"
             type="image" alt="">
    </form>
    <div class="col-10">
      <p>';
    foreach($rule->rulebrs as $rulebr) {
        $bro = MySBDBMFBlockRefHelper::getByKeyname($rulebr);
        echo '
    <label>
      <i>' . _G($bro->lname) . '</i>
    </label>';
    }
    echo '<br>
      <span class="help">' . $rule->id . '</span></p>
    </div>
  <a class="col-1 t-center btn-danger-light"
     href="'.$httpbase.'&amp;rule_delete='.$rule->id.'#autosubsrules"
     title="Delete '.$rule->id.'">
    <img src="images/icons/user-trash.png" alt="user-trash">
  </a>
  </div>
  </div>';
}

echo '
<form action="index.php?tpl=admin/admin&amp;page=admin&amp;module=dbmf3_asub#autosubsrules" method="post">
  <div class="row">
    <div class="col-sm-3"></div>
    <div class="col-sm-6">
      <input type="hidden" name="dbmf_autosubs_rulenew" value="1">
      <input type="submit" class="btn-primary"
             value="' . _G('DBMF_autosubs_rule_new') . '">
    </div>
    <div class="col-sm-3"></div>
  </div>
</form>

</div>


<div class="content">
  <h1 id="autosubs-reset">' . _G('DBMF_autosubs_reset') . '</h1>';

if ($bradd != '')
    echo '
<form action="' . $httpbase . '#autosubs-reset" method="post"
        OnSubmit="return mysb_confirm(\'Reset autosubs pin in ALL contacts ?\')">
  <div class="row">
    <div class="col-sm-3"></div>
    <div class="col-sm-6">
      <input type="hidden" name="dbmf_autosubs_resetblockref" value="1">
      <input type="submit" class="btn-danger"
             value="' . _G('DBMF_autosubs_resetblockref') . ': ' . $bradd . '">
    </div>
    <div class="col-sm-3"></div>
  </div>
</form>';
else
    echo '
  <div class="row">
    <div class="col-sm-3"></div>
    <div class="col-sm-6">
      ' . _G('DBMF_autosubs_resetblockref_unset') . '
    </div>
    <div class="col-sm-3"></div>
  </div>';

if ($datebr != '')
    echo '
<form action="' . $httpbase . '#autosubs-reset" method="post"
        OnSubmit="return mysb_confirm(\'Reset autosubs dates in ALL contacts ?\')">
  <div class="row">
    <div class="col-sm-3"></div>
    <div class="col-sm-6">
      <input type="hidden" name="dbmf_autosubs_resetdatebr" value="1">
      <input type="submit" class="btn-danger"
             value="' . _G('DBMF_autosubs_resetdatebr') . ': ' . $datebr . '">
    </div>
    <div class="col-sm-3"></div>
  </div>
</form>';
else
    echo '
  <div class="row">
    <div class="col-sm-3"></div>
    <div class="col-sm-6">
      ' . _G('DBMF_autosubs_resetdatebr_unset') . '
    </div>
    <div class="col-sm-3"></div>
  </div>';

echo '
</div>';

?>