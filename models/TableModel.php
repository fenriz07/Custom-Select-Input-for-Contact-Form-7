<?php

class TableModel
{

    public static function select($options)
    {
        global $wpdb;

        $query = "SELECT %s, %s FROM %s";

        $query = sprintf($query, $options->value, $options->text, $options->table);

        $result = $wpdb->get_results($query);

        return $result;
    }
}
