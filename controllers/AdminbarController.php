<?php
namespace Craft;

class AdminbarController extends BaseController
{
  public function actionClearTemplateCache($returnUrl)
  {
    craft()->templateCache->deleteAllCaches();

    $this->redirect($returnUrl, $terminate = true, $statusCode = 302);
  }
}