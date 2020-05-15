<?php

include DIR_CSI7 . '/models/TableModel.php';

class OptionRepository{

    private $options;

    public $table;
    public $text;
    public $value;

    
    private $optionsAvailables;

    function __construct( $options )
    {
        $this->options = $options;

        $this->table = null;
        $this->text = null;
        $this->value = null;

        $this->optionsAvailables = [
            'table',
            'text',
            'value',
        ];

        foreach ($this->options as $option) {
            $this->setOptions($option);
        }

        $this->deleteProperties();

    }

    private function setOptions($option){

        $option = explode(':',$option);

        if( in_array($option[0],$this->optionsAvailables))
        {
            $this->{$option[0]} = $option[1];
        }

    }

    private function deleteProperties()
    {
        unset($this->options);
        unset($this->optionsAvailables);
    }

    public function existAllOptions()
    {
        if( $this->table == null || $this->text == null || $this->value == null)
        {
            return false;
        }

        return true;
    }

    public function getOptions()
    {
        $html   = '';
        $option = '<option value="%s"> %s </option>';

        $results = TableModel::select($this);
        
        $html .= '<option disabled selected value="none"> Seleccioné </option>';

        foreach ($results as $result) {
            $html .= sprintf( $option, $result->{$this->value},$result->{$this->text});
        }

        return $html;
    }
}