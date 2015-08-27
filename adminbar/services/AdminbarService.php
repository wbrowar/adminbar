<?php
namespace Craft;

class AdminbarService extends BaseApplicationComponent
{
	private $_adminbarEmbedded;
	private $_pluginLinks = array();
	
	// public methods
	public function bar($currentEntry, $color, $type)
	{
		// check if user can access CP
		$user = craft()->userSession->getUser();
		if ($user && craft()->userSession->isAdmin() || $user && craft()->userPermissions->doesUserHavePermission($user->id, 'accessCp')) {
			$plugin = craft()->plugins->getPlugin('Adminbar');
			
			// get links from other plugins
			$pluginLinksHook = craft()->plugins->call('addAdminBarLinks');
			$pluginLinks = array();
			$externalLinksStringData = '';
			
			foreach ($pluginLinksHook as $key => $link) {
				$pluginName = craft()->plugins->getPlugin($key)->getName();
				
				for($i=0; $i<count($link); $i++) {
					if (isset($link[$i]['title']) && isset($link[$i]['url']) && isset($link[$i]['type'])) {
						$link[$i]['id'] = str_replace(' ', '', $link[$i]['title']) . $link[$i]['url'] . $link[$i]['type'];
						$link[$i]['originator'] = $pluginName;
						array_push($pluginLinks, $link[$i]);
					}
					
					// save data to compare later
					$externalLinksStringData .= var_export($link[$i], true);
				}
			}
			
			// if settings don't match, clear template cache
			if (isset($this->getAdminbarSettings()->externalLinksString['default'])) {
				$externalLinksStringSettingString = $this->getAdminbarSettings()->externalLinksString['default'];
			} else {
				$externalLinksStringSettingString = '...';
			}
			
			if ($externalLinksStringSettingString == '' || $externalLinksStringSettingString != $externalLinksStringData) {
				$this->updateAdminbarSettings(array('externalLinksString' => array(AttributeType::String, 'label' => 'Plugin Links String', 'default' => $externalLinksStringData)));
				$plugin->clearAdminBarCache();
			}
			
			// redirect tempalate path to plugin path
			$oldTemplatesPath = craft()->path->getTemplatesPath();
			$newTemplatesPath = craft()->path->getPluginsPath().'adminbar/templates/';
			craft()->path->setTemplatesPath($newTemplatesPath);
			
			// check to see if defaults are overriden
			if ($color === '') {
				$color = $this->getAdminbarSettings()->defaultColor;
			}
			
			// render admin bar
			$adminbarHtml = craft()->templates->render('bar', array(
				'adminbarEmbedded' => $this->_adminbarEmbedded,
				'sticky' => $this->getAdminbarSettings()->autoEmbedSticky,
				'entry' => $currentEntry,
				'color' => $color,
				'type' => $type,
				'customLinks' => $this->getAdminbarSettings()->customLinks,
				'enabledLinks' => $this->getAdminbarSettings()->enabledLinks,
			));
			
			if ($type == 'primary') {
				craft()->templates->includeFootHtml($adminbarHtml);
			} else {
				print($adminbarHtml);
			}
			
			// return templates path to original locatiojn
			craft()->path->setTemplatesPath($oldTemplatesPath);
			
			// change embedded value to true
			$this->_adminbarEmbedded = true;
		}
	}
	
	// private methods
	private function getAdminbarSettings()
	{
		// get values of links set in CP
		$plugin = craft()->plugins->getPlugin('Adminbar');
		return $plugin->getSettings();
	}
	private function updateAdminbarSettings(array $settings=array()) {
		$plugin = craft()->plugins->getPlugin('Adminbar');
    $savedSettings = $plugin->getSettings()->getAttributes();
    $newSettingsRow = array_merge($savedSettings, $settings);

    return craft()->plugins->savePluginSettings($plugin, $newSettingsRow);
	}
}