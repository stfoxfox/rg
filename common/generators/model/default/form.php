<?php
/**
 * This is the template for generating the model class of a specified table.
 */

/* @var $this yii\web\View */
/* @var $generator common\generators\model\Generator */
/* @var $tableName string full table name */
/* @var $className string class name */
/* @var $queryClassName string query class name */
/* @var $tableSchema yii\db\TableSchema */
/* @var $labels string[] list of attribute labels (name => label) */
/* @var $rules string[] list of validation rules */
/* @var $relations array list of relations (name => relation declaration) */
/* @var $columns array list of columns in table (attributes) */

echo "<?php\n";
?>

namespace <?= $generator->formNs ?>;

use Yii;
use yii\base\Model;
use <?= $generator->ns . '\\' . $className ?>;
/**
* This is the model class for <?= $className ?> form.
*/
class <?= $className ?>Form extends Model
{
<?php foreach($columns as $column): ?>
    public $<?= $column . ";\n" ?>
<?php endforeach; ?>

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [<?= "\n            " . implode(",\n            ", $rules) . ",\n        " ?>];
    }

    /**
     * @param <?= $className ?> $item
     */
    public function loadFromItem($item)
    {
    <?php foreach($columns as $column): ?>
    $this-><?= $column ?> = $item-><?= $column . ";\n" ?>
    <?php endforeach; ?>
}

    /**
     * @inheritdoc
     * @var <?= $className ?> $item
     */
    public function edit($item)
    {
        if (!$this->validate()) {
            return null;
        }

    <?php foreach($columns as $column): ?>
    $item-><?= $column ?> = $this-><?= $column . ";\n" ?>
    <?php endforeach; ?>

        if ($item->save()) {
            return true;
        }

        return null;
    }

    public function create()
    {
        if (!$this->validate()) {
            return null;
        }

        $item = new <?= $className ?>();

    <?php foreach($columns as $column): ?>
    $item-><?= $column ?> = $this-><?= $column . ";\n" ?>
    <?php endforeach; ?>

        if ($item->save()) {
            return $item;
        }

        return null;
    }
}
