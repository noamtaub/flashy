<?php

header('Content-type: text/plain');

function createTable()
{
    $db = new JsonDatabase();

    try {
        $db->crateTable("customers");
    } catch (Exception $e) {
        print_r($e->getMessage());
    }
}

function failCreateTable()
{
    $db = new JsonDatabase();

    $db->crateTable("customers-fail");
    try {
        $db->crateTable("customers-fail");
    } catch (Exception $e) {
        print_r($e->getMessage());
    }
}

function insertOneRow()
{
    $db = new JsonDatabase();
    $data = [
        "name" => "Noam",
        "last" => "taub"
    ];
    try {
        $db->insert("users", $data);
    } catch (Exception $e) {
        print_r($e->getMessage());
    }
}

function insertMultipleRows()
{
    $db = new JsonDatabase();
    $data = [
        [
            "name" => "Moshe",
            "last" => "taub"
        ],
        [
            "name" => "Noam",
            "last" => "taub"
        ],
        [
            "name" => "Tzvi",
            "last" => "taub"
        ],
    ];
    try {
        $db->insertMulti("users", $data);
    } catch (Exception $e) {
        print_r($e->getMessage());
    }
}

function updateRow()
{
    $db = new JsonDatabase();

    $data = [
        "name" => "Avi",
        "last" => "Katz"
    ];

    try {
        $db->update('users', 2, $data);
    } catch (Exception $e) {
        print_r($e->getMessage());
    }
}
function deleteRow()
{
    $db = new JsonDatabase();

    try {
        $db->delete('users', 1);
    } catch (Exception $e) {
        print_r($e->getMessage());
    }
}

function findRow(){
    $db = new JsonDatabase();

    try {
        $db->find('users', 2);
    } catch (Exception $e) {
        print_r($e->getMessage());
    }
}
function findAll(){
    $db = new JsonDatabase();

    try {
        $db->findAll('users');
    } catch (Exception $e) {
        print_r($e->getMessage());
    }
}


function getDataFiltered(){
    $db = new JsonDatabase();

    try {
        $tableData = $db->findAll('users');
        $dataFilter = new DataFilter($tableData);
        echo $dataFilter->getDataByCol(['id', 'name']);
    }catch (Exception $e) {
        print_r($e->getMessage());
    }
}

createTable();
// failCreateTable();
// insertOneRow();
// insertMultipleRows();
// updateRow();
// deleteRow();
// findRow();
// findAll();
// getDataFiltered();
