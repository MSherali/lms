<?php
/**
 * Created by PhpStorm.
 * User: MSherali
 * Date: 3/24/2017
 * Time: 9:23 AM
 */

return [
    'sourcePath' => __DIR__. '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR,
    'languages' => ['uz-CY','uz-Latn','ru-RU','en-US'],
    'translator' => 'Yii::t',
    'sort' => false,
    'removeUnused' => false,
    'only' => ['*.php'],
    'except' => [
        '.svn',
        '.git',
        '.gitignore',
        '.gitkeep',
        '.hgignore',
        '.hgkeep',
        '/messages',
        '/vendor',
    ],
    'format' => 'php',
    'messagePath' => __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'messages',
    'overwrite' => true,
];