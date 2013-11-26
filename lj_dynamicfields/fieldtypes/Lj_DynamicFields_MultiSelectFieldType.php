<?php

namespace Craft;

class Lj_DynamicFields_MultiSelectFieldType extends BaseFieldType
{
	public function getName()
	{
		return Craft::t('Multi-select (dynamic)');
	}

	public function getInputHtml($name, $values)
	{
		$oldTemplatesPath = craft()->path->getTemplatesPath();
		craft()->path->setTemplatesPath(craft()->path->getSiteTemplatesPath());
		$options = json_decode('[' . craft()->templates->renderString($this->getSettings()->json) . ']', true);
		craft()->path->setTemplatesPath($oldTemplatesPath);
		
		if ($this->isFresh()) :
		
		$values = array();
		
			foreach ($options as $option) :
				if (!empty($option['default'])) :
					$values[] = $option['value'];
				endif;
			endforeach;
		endif;
		
		return craft()->templates->render('lj_dynamicfields/input/multiselect', array(
			'name' => $name,
			'values' => $values,
			'options' => $options
		));
	}
	
	protected function defineSettings()
    {
        return array(
            'json' => array(AttributeType::String)
        );
    }
	
	public function getSettingsHtml()
    {
        return craft()->templates->render('lj_dynamicfields/settings/multiselect', array(
			'name' => 'json',
			'settings' => $this->getSettings()
        ));
    }
}