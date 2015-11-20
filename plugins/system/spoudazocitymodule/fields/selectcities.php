<?php
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
 
jimport('joomla.form.formfield');
 
class JFormFieldSelectCities extends JFormField {
 
	protected $type = 'SelectCities';
 
	// getLabel() left out
	
	public function getOptions(){
		$db = JFactory::getDBO();
		$query="SELECT id,name FROM #__k2_categories WHERE `plugins` LIKE '%\"citySelectisCity\":\"1\"%' AND `published`='1' ORDER BY name";
		$db->setQuery($query);
		$results = $db->loadObjectList();
		
		return $results;
	}
 
	public function getInput() {
		
		$html = array();

		// Initialize some field attributes.
		$class          = !empty($this->class) ? ' class="checkboxes ' . $this->class . '"' : ' class="checkboxes"';
		$required       = $this->required ? ' required aria-required="true"' : '';
		$autofocus      = $this->autofocus ? ' autofocus' : '';

		// Including fallback code for HTML5 non supported browsers.
		JHtml::_('jquery.framework');
		JHtml::_('script', 'system/html5fallback.js', false, true);

		// Start the checkbox field output.
		$html[] = '<fieldset id="' . $this->id . '"' . $class . $required . $autofocus . '>';

		// Get the field options.
		$options = $this->getOptions();
		
		$selected_cities = $this->value;
		
		$app = JFactory::getApplication();
		$app->setUserState('com_spoudazo.city_list', $selected_cities);
		
		// Build the checkbox field output.
		$html[] = '<ul>';

		foreach ($options as $i => $option)
		{			
			$checked = (!empty($selected_cities[$option->id]) && $selected_cities[$option->id] == 1) ? ' checked' : '';

			$html[] = '<li>';
			$html[] = '<input type="checkbox" id="' . $this->id . $i . '" name="' . $this->name . '['.$option->id.']" value="' . $option->id . '"' . $checked . $class . ' onclick="addCity(this);" />';

			$html[] = '<label for="' . $this->id . $i . '"' . $class . '>' . JText::_($option->name) . '</label>';
			$html[] = '</li>';
		}

		$html[] = '</ul>';

		// End the checkbox field output.
		$html[] = '</fieldset>';
		
		$html[] = '<script>
						function addCity(el){
							var value;
							if(jQuery(el).prop("checked")){
								value = 1;
							}else{
								value = 0;
							}
							jQuery.ajax({
								method: "POST",
								url: "' . JRoute::_('index.php') . '",
								data: { 
									option: "com_spoudazo",
									task: "spoudazo.addCityToUseState",
									id: el.value,
									value: value
								},
								success:function(response){
									try{
										response=jQuery.parseJSON(response);
										console.log(response);
										
									}catch(e){
										//console.log(e);
									}
								}
							});
							
						}
				   </script>';

		return implode($html);
	}
}

?>


