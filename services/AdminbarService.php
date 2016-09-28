<?php
namespace Craft;

class AdminbarService extends BaseApplicationComponent
{
  private $_barEmbedded = false;
  private $_editEmbedded = false;
  private $_editId = 0;

  // public methods
  public function bar($config = array())
  {
    $adminbar = craft()->plugins->getPlugin('Adminbar');
    $config['barEmbedded'] = $this->_barEmbedded;
    $config['customLinks'] = $adminbar->getSettings()->customLinks;
    $config['color'] = isset($config['color']) ? $config['color'] : $adminbar->getSettings()->defaultColor;
    
    if (craft()->getEdition() >= Craft::Pro) {
      $config['localesEnabled'] = true;
    } else {
      $config['localesEnabled'] = false;
    }

    // add config file settings to config
    $config['additionalLinks'] = $this->_getConfigSetting('additionalLinks');
    $config['cacheBar'] = $this->_getConfigSetting('cacheBar');
    $config['clearCacheLink'] = $this->_getConfigSetting('clearCacheLink');
    $config['displayDashboardLink'] = $this->_getConfigSetting('displayDashboardLink');
    $config['displayGreeting'] = $this->_getConfigSetting('displayGreeting');
    $config['displayLogout'] = $this->_getConfigSetting('displayLogout');
    $config['displaySettingsLink'] = $this->_getConfigSetting('displaySettingsLink');
    $config['enableMobileMenu'] = $this->_getConfigSetting('enableMobileMenu');
    $config['scrollLinks'] = $this->_getConfigSetting('scrollLinks');

    // redirect tempalate path to plugin path
    $oldTemplatesPath = craft()->templates->getTemplatesPath();
    $newTemplatesPath = craft()->path->getPluginsPath() . 'adminbar/templates/';
    craft()->templates->setTemplatesPath($newTemplatesPath);

    // render admin bar
    $barHtml = craft()->templates->render('bar', $config);
    
    if (isset($config['type']) && $config['type'] === 'primary') {
      craft()->templates->includeFootHtml($barHtml);
    } else {
      print($barHtml);
    }

    // return templates path to original location
    craft()->templates->setTemplatesPath($oldTemplatesPath);

    // change embedded value to true
    $this->_barEmbedded = true;
  }
  // public methods
  public function edit($entry, $config = array())
  {
    $adminbar = craft()->plugins->getPlugin('Adminbar');
    $config['editEmbedded'] = $this->_editEmbedded;
    $config['entry'] = $entry;
    $config['id'] = $this->_editId;
    $config['enabled'] = $this->canEmbed() ? true : false;
    $config['color'] = isset($config['color']) ? $config['color'] : $adminbar->getSettings()->defaultColor;
    
    if (craft()->getEdition() >= Craft::Pro) {
      $config['localesEnabled'] = true;
    } else {
      $config['localesEnabled'] = false;
    }

    // add config file settings to config
    $config['displayEditDate'] = $this->_getConfigSetting('displayEditDate');
    $config['displayEditAuthor'] = $this->_getConfigSetting('displayEditAuthor');
    $config['displayRevisionNote'] = $this->_getConfigSetting('displayRevisionNote');
    
    // figure out if $entry is a custom URL string, otherwise assume it's an Entry
    if (is_string($entry)) {
      $config['type'] = 'string';
    } else {
      $config['type'] = 'entry';
    }
    
    // get recent revision information
    $revision = $config['type'] == 'entry' ? craft()->entryRevisions->getVersionsByEntryId($entry['id'], $entry['locale'], 1, true) : '';
    if (!empty($revision)) {
      $revisionAuthor = craft()->users->getUserById($revision[0]->creatorId);
      $config['revisionAuthor'] = $revisionAuthor;
      $config['revisionNote'] = $revision[0]->revisionNotes;
    } else {
      $config['revisionAuthor'] = null;
      $config['revisionNote'] = null;
    }

    // redirect tempalate path to plugin path
    $oldTemplatesPath = craft()->templates->getTemplatesPath();
    $newTemplatesPath = craft()->path->getPluginsPath() . 'adminbar/templates/';
    craft()->templates->setTemplatesPath($newTemplatesPath);

    // render admin bar
    $editHtml = craft()->templates->render('edit', $config);

    print($editHtml);

    // return templates path to original location
    craft()->templates->setTemplatesPath($oldTemplatesPath);
    
    $this->_editId += 1;
    $this->_editEmbedded = true;
  }
  
  public function clearAdminBarCache() {
    $user = craft()->userSession->getUser();
    
    craft()->templateCache->deleteCachesByKey('adminbar' . $user->id);
  }
  
  // check to see if bar should be auto embedded
  public function canEmbed()
  {
    return (
      !craft()->request->isAjaxRequest() &&
      !craft()->isConsole() &&
      !craft()->request->isCpRequest() &&
      craft()->userSession->isLoggedIn()
    );
  }
  private function _getConfigSetting($key)
  {
    // get settings from config file
    $configSetting = craft()->config->get($key, 'adminbar');
    return $configSetting;
  }
}