<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DBConnection
 *
 * @author Sakkeer Hussain
 */
class DBConnection {

    private $handler;

    function __construct() {
        if (!$this->connect(Constants::$db_host, Constants::$db_user_name, Constants::$db_password)) {
            header("Location: " . Constants::$error_page . "?error_message=db_connection_failed");
        } else {
            if (!mysql_select_db(Constants::$database_name)) {
                header("Location: " . Constants::$error_page . "?error_message=db_selection_failed");
            }
        }
    }

    function connect($db_host, $db_user_name, $db_password) {
        $this->handler = mysql_connect($db_host, $db_user_name, $db_password);
        if ($this->handler) {
            return true;
        } else {
            return false;
        }
    }

    function executeQuery($query) {
        return mysql_query($query, $this->handler);
    }

    function add_model($model) {
        $model_vars = get_object_vars($model);
        $table_name = get_class($model);
        $field_list = '';
        $values = '';
        $query = 'INSERT INTO :table_name (:field_list) VALUES (:values)';
        foreach ($model_vars as $field => $value) {
            if ($value != null) {
                if ($values == '' || $field_list == '') {
                    $field_list = '`' . $field . '`';
                    $values = "'" . $value . "'";
                } else {
                    $field_list = $field_list . ',' . '`' . $field . '`';
                    $values = $values . ',' . "'" . $value . "'";
                }
            }
        }

        $query = str_replace(':table_name', $table_name, $query);
        $query = str_replace(':field_list', $field_list, $query);
        $query = str_replace(':values', $values, $query);
        if($this->executeQuery($query)){
            return mysql_insert_id($this->handler);
        }  else {
            return FALSE;
        }
    }

    function update_model($model) {
        $model_vars = get_object_vars($model);
        $table_name = get_class($model);
        $field_and_values = '';
        $query = 'UPDATE `:table_name` SET :field_and_values WHERE id='.$model->id;
        foreach ($model_vars as $field => $value) {
            if ($value != null || $value == 0 || $value == '') {
                if ($field_and_values == '') {         
                    $field_and_values = '`' . $field . '` = '."'" . $value . "'";
                } else {
                    $field_and_values = $field_and_values.', `' . $field . '` = '."'" . $value . "'";
                }
            }
        }
        $query = str_replace(':table_name', $table_name, $query);
        $query = str_replace(':field_and_values', $field_and_values, $query);
        if($this->executeQuery($query)){
            return TRUE;
        }  else {
            return FALSE;
        }
    }

    function get_model($model, $id=null) {
        if($id==NULL){
            $id = $model->id;
        }
        $table_name = get_class($model);
        $query = 'SELECT * FROM :table_name WHERE `id` = ' . $id . ' LIMIT 1';
        $query = str_replace(':table_name', $table_name, $query);
        $result = $this->executeQuery($query);
        if ($row = mysql_fetch_assoc($result)) {
            foreach ($row as $key => $value) {
                $model->{$key} = $value;
            }
            return $model;
        } else {
            return FALSE;
        }
    }

    function delete_model($model, $id=null) {
        if($id==NULL){
            $id = $model->id;
        }
        $table_name = get_class($model);
        $query = 'DELETE FROM :table_name WHERE `id` = ' . $id ;
        $query = str_replace(':table_name', $table_name, $query);
        $result = $this->executeQuery($query);
        if ($result) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function get_model_list($model, $conditions = null) {
        $table_name = get_class($model);
        $query = 'SELECT * FROM :table_name';
        $array = array();
        $query = str_replace(':table_name', $table_name, $query);
        if ($conditions != NULL) {
            $query = $query . ' WHERE ' . $conditions;
        }
        $result = $this->executeQuery($query);
        if ($result) {
            while ($row = mysql_fetch_assoc($result)) {
                $obj = new $table_name;
                foreach ($row as $key => $value) {
                    $obj->{$key} = $value;
                }
                array_push($array, $obj);
            }
            if (empty($array)) {
                return FALSE;
            } else {
                return $array;
            }
        } else {
            return FALSE;
        }
    }
    
    function delete_model_list($model, $conditions = null) {
        $table_name = get_class($model);
        $query = 'DELETE FROM :table_name';
        $array = array();
        $query = str_replace(':table_name', $table_name, $query);
        if ($conditions != NULL) {
            $query = $query . ' WHERE ' . $conditions;
        }
        $result = $this->executeQuery($query);
        return $result;
    }

}
