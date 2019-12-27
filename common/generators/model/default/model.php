<?php
/**
 * This is the template for generating the model class of a specified table.
 */

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\model\Generator */
/* @var $tableName string full table name */
/* @var $className string class name */
/* @var $queryClassName string query class name */
/* @var $tableSchema yii\db\TableSchema */
/* @var $labels string[] list of attribute labels (name => label) */
/* @var $rules string[] list of validation rules */
/* @var $relations array list of relations (name => relation declaration) */

echo "<?php\n";
?>
namespace <?= $generator->ns ?>;

use Yii;
use <?= $generator->ns ?>\gii\Base<?= $className . ";\n" ?>

/**
* This is the model class for table "<?= $generator->generateTableName($tableName) ?>".
* Class <?=$className . "\n"?>
* @package <?=$generator->ns . "\n"?>
* @inheritdoc
*/
class <?= $className ?> extends Base<?= $className . "\n" ?>
{
    /**
    * @inheritdoc
    */
}
