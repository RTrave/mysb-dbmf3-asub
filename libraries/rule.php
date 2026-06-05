<?php
/***************************************************************************
 *
 *   phpMySandBox/DBMFASub module - TRoman<abadcafe@free.fr> - 2026
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License', or
 *   ('at your option) any later version.
 *
 ***************************************************************************/

// No direct access.
defined('_MySBEXEC') or die;


/**
 * Category class
 *
 */
class MySBDBMFASubRule extends MySBObject
{

    /** 
     * @var  int Rule group ID
     */
    public $ruleid = 0;

    /** 
     * @var  array Rule array of BlockRefs in the rule
     */
    public $rulebrs = [];

    /**  
     * @brief ASub Rule constructor 
     * @param int ID of rules group
     * @param array DB Datas
     */
    public function __construct($ruleid = null, $data_rules = array())
    {
        global $app;
        if ($ruleid != null) {
            $req_rule = MySBDB::query(
                "SELECT * FROM " . MySB_DBPREFIX . 'dbmfasubrules ' .
                'WHERE id=' . $ruleid
                ,
                "MySBDBMFASubRule::__construct($ruleid)",
                false,
                'dbmf3_asub'
            );
            if (MySBDB::num_rows($req_rule) == 0)
                return;
            $data_rule = MySBDB::fetch_array($req_rule);
        }
        parent::__construct((array) ($data_rule));
        $brs = new MySBCSValues($data_rule['brids'], true);
        foreach ($brs->values as $brkey) {
            // echo ' -'.$data_rule['id'].':'.$brkey.'- ';
            $this->rulebrs[] = $brkey;
        }
    }

    /**
     * Updator.
     * @param   array   Array of referenced datas.
     */
    public function update($data_rules = array())
    {
        global $app;
        parent::__update('dbmfasubrules', (array) ($data_rules));
    }

}

/**
 * Category class
 *
 */
class MySBDBMFASubBlockRule extends MySBObject
{

    /** 
     * @var  int Rule group ID
     */
    public $block_id = 0;

    /** 
     * @var  string Rule array of BlockRefs in the rule
     */
    public $block_comments;

    /** 
     * @var  int Rule group ID
     */
    public $select_max = 0;

    public function __construct()
    {}
}

/** 
 * @brief Rules Helper class
 * @package    phpMySandBox
 * @subpackage Libraries\Objects
 */
class MySBDBMFASubRuleHelper
{

    /**
     * @brief Create new rule
     * @param   $name           string  Group name
     * @param   $comments       string  Group explicit comment
     * @param   $is_default     bool    Are users assigned in group by default ?
     * @return  MySBGroup|null
     */
    public static function create()
    {
        global $app;
        $req_newrole = MySBDB::query(
            'INSERT INTO ' . MySB_DBPREFIX . 'dbmfasubrules ' .
            '(brids) VALUES ("")',
            "MySBDBMFASubRuleHelper::create()"
        );
        return null;
    }

    /**
     * Delete a rule
     * @param   $id         int  Group name to delete, or self group
     */
    public static function delete($id = '')
    {
        global $app;
        MySBDB::query(
            "DELETE FROM " . MySB_DBPREFIX . "dbmfasubrules " .
            "WHERE id=" . $id,
            "MySBGroupHelper::delete($id)"
        );
    }

    /**
     * Load all rules
     * @return  array             array of MySBGroup
     */
    public static function load()
    {
        global $app;
        $req_rules = MySBDB::query(
            "SELECT * FROM " . MySB_DBPREFIX . "dbmfasubrules " .
            "ORDER BY id",
            "MySBDBMFASubRuleHelper::load()",
            true,
            'dbmf3_asub',
            true
        );
        $allrules = [];
        while ($data_rule = MySBDB::fetch_array($req_rules)) {
            $allrules[$data_rule['id']] = new MySBDBMFASubRule($data_rule['id']);
        }
        return $allrules;
    }

    public static function blocksLoad()
    {
        global $app;
        $req_rblocks = MySBDB::query(
            "SELECT * FROM " . MySB_DBPREFIX . "dbmfasubblocks " .
            "ORDER BY block_id",
            "MySBDBMFASubRuleHelper::blocksLoad()",
            true,
            'dbmf3_asub',
            false
        );
        $brules = [];
        while ($data_rblock = MySBDB::fetch_array($req_rblocks)) {
            $brule = new MySBDBMFASubBlockRule();
            $brule->block_id = $data_rblock["block_id"];
            $brule->block_comments = $data_rblock["comments"];
            $brule->select_max = $data_rblock["sel_max"];
            $brules[$brule->block_id] = $brule;
        }
        return $brules;
    }
}

?>