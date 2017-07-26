<?php

use yii\helpers\Html;
use yii\helpers\BaseStringHelper;
use dmstr\widgets\Menu;
//use firdows\menu\models\Navigate;
//use culturePnPsu\material\components\Navigate;
use mdm\admin\components\Helper;

/* @var $this \yii\web\View */
/* @var $content string */

$controller = $this->context;
//$menus = $controller->module->menus;
//$route = $controller->route;
$user = Yii::$app->user->identity->profile->resultInfo;
$module = $this->context->module->id;
?>
<?php $this->beginContent('@app/views/layouts/main.php') ?>

<div class='box'>
    <div class='box-header with-border'>
        <h3 class='box-title'><?= Yii::t('culture/visit-count', 'Visit Count') ?></h3>
    </div><!--box-header -->

    <div class='box-body'>
        <?= $content ?>
    </div>
</div>


<?php $this->endContent(); ?>
