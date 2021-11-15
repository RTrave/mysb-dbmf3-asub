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

if(MySBConfigHelper::Value('dbmf_autosubs_anonaccess','dbmf3_asub')!=1)
  if(!MySBRoleHelper::checkAccess('dbmf_autosubs')) return;

include( _pathT('step1','dbmf3_asub') );

?>
