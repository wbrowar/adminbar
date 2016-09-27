<?php
namespace Craft;

class AdminbarController extends BaseController
{
  public function actionClearTemplateCache($returnUrl)
  {
    craft()->templateCache->deleteAllCaches();

    $this->redirect($returnUrl, $terminate = true, $statusCode = 302);
  }
  public function actionClearTemplateCacheByKey($returnUrl, $key)
  {
    craft()->templateCache->deleteCachesByKey($key);

    $this->redirect($returnUrl, $terminate = true, $statusCode = 302);
  }
  public function actionClearTemplateCacheByElementType($returnUrl, $type)
  {
    craft()->templateCache->deleteCachesByElementType($type);

    $this->redirect($returnUrl, $terminate = true, $statusCode = 302);
  }
}