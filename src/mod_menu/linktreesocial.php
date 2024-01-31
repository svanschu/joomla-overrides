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

$css = ".linktree_social { text-align: center; }
.linktree_social button { margin-left: 5px; margin-right: 5px; }
";
$wa->addInlineStyle($css);

$id = '';

if ($tagId = $params->get('tag_id', '')) {
    $id = ' id="' . $tagId . '"';
}

// The menu class is deprecated. Use mod-menu instead
?>
<div<?php echo $id; ?> class="linktree_social <?php echo $class_sfx; ?>">
    <?php foreach ($list as $i => &$item) {
        $itemParams = $item->getParams();

        switch ($item->type):
            case 'separator':
            case 'component':
            case 'heading':
            case 'url':
            default:
                require ModuleHelper::getLayoutPath('mod_menu', 'linktreesocial_url');
                break;
        endswitch;
    }
    ?>
    </div>