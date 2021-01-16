<?php

namespace app\modules\chat\assets;

use yii\web\AssetBundle;
use yii\web\JqueryAsset;

/**
 * Class ChatOnMainAsset
 *
 * @package app\modules\chat\assets
 */
class ChatOnMainAsset extends AssetBundle
{
    public $sourcePath = '@app/modules/chat/assets/dist';

    /**
     * @var array
     */
    public $css = [
    ];

    /**
     * @var array
     */
    public $js = [
        'chat.main.js',
    ];

    /**
     * @var array
     */
    public $depends = [
        JqueryAsset::class,
    ];
}