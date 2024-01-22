<?php
/**
 * Template override to create a link tree with a menu
 * 
 * @copyright   (C) 2024 Sven Schultschik. <https://www.schultschik.de>
 * @license     GNU General Public License version 3 or later
 */

defined('_JEXEC') or die;

use Joomla\CMS\Helper\ModuleHelper;

/** @var Joomla\CMS\WebAsset\WebAssetManager $wa */
$wa = $app->getDocument()->getWebAssetManager();
$wa->registerAndUseScript('mod_menu', 'mod_menu/menu.min.js', [], ['type' => 'module']);

$doc =  $app->getDocument();
$css = ".linktree .card-img-left {
    width: 100%;
    height: 100%;
    background-color: rgba(224, 224, 229, 0.4);
    border-radius: 50%;
}";
$wa->addInlineStyle($css);

$id = '';

if ($tagId = $params->get('tag_id', '')) {
    $id = ' id="' . $tagId . '"';
}

// The menu class is deprecated. Use mod-menu instead
?>
<div<?php echo $id; ?> class="d-grid linktree <?php echo $class_sfx; ?>">
    <?php foreach ($list as $i => &$item) {
        $itemParams = $item->getParams();

        switch ($item->type):
            case 'separator':
            case 'component':
            case 'heading':
            case 'url':
            default:
                require ModuleHelper::getLayoutPath('mod_menu', 'linktree_url');
                break;
        endswitch;
    }
    ?>
    </div>