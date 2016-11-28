<?php

/*
 * This file is part of the Mycone project.
 *
 * (c) Mycone project <http://github.com/mycone/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace mycone\users\migrations;

use Yii;

/**
 * @author Chen Hao <dzswchenhao@126.com>
 */
class Migration extends \yii\db\Migration
{
    /**
     * @var string
     */
    protected $tableOptions;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        switch (Yii::$app->db->driverName) {
            case 'mysql':
                $this->tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
                break;
            case 'pgsql':
                $this->tableOptions = null;
                break;
            default:
                throw new \RuntimeException('Your database is not supported!');
        }
    }
}
