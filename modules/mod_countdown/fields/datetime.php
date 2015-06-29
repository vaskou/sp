<?php
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

// Add CSS and JS
JHtml::stylesheet('http://netdna.bootstrapcdn.com/twitter-bootstrap/2.2.2/css/bootstrap-combined.min.css');
JHtml::stylesheet('http://tarruda.github.com/bootstrap-datetimepicker/assets/css/bootstrap-datetimepicker.min.css');
JHtml::script('http://tarruda.github.com/bootstrap-datetimepicker/assets/js/bootstrap-datetimepicker.min.js');

jimport('joomla.form.formfield');

class JFormFieldDateTime extends JFormField {

    protected $type = 'DateTime';
    public $twelve_hour_format = "false";
    public $format = "";

    public function getInput() {

        if(isset($this->element['format']))
        {
            $format = $this->element['format'];
            $twelve_hour_format = ($format == "24h")? "false" : "true";
        }

        return '<div class="well">'.
            '<div id="datetimepicker2" class="input-append">'.
                '<input data-format="MM/dd/yyyy HH:mm:ss PP" name="' . $this->name . '" type="text" value="'.$this->value.'"></input>'.
                '<span class="add-on">'.
                  '<i data-time-icon="icon-time" data-date-icon="icon-calendar"></i>'.
                '</span>'.
              '</div>'.
            '</div>'.
            '<script type="text/javascript">'.
              'jQuery(function() {'.
                'jQuery("#datetimepicker2").datetimepicker({'.
                  'language: "en"});'.
              '});'.
            '</script>';
    }

    public function getValue()
    {
        return $this->value;
    }
}
