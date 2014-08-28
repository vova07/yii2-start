<?php

namespace backend\themes\admin\widgets;

use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\helpers\Html;

/**
 * Class Menu
 * @package backend\themes\admin\widgets
 * Theme menu widget.
 */
class Menu extends \yii\widgets\Menu
{
    /**
     * @inheritdoc
     */
    public $linkTemplate = '<a href="{url}">{icon} {label}</a>';

    /**
     * @inheritdoc
     */
    protected function renderItem($item)
    {
        if (isset($item['url'])) {
            $template = ArrayHelper::getValue($item, 'template', $this->linkTemplate);

            $replace = !empty($item['icon']) ? [
                '{url}' => Url::to($item['url']),
                '{label}' => $item['label'],
                '{icon}' => '<i class="fa ' . $item['icon'] . '"></i> '
            ] : [
                '{url}' => Url::to($item['url']),
                '{label}' => $item['label']
            ];

            return strtr($template, $replace);
        } else {
            $template = ArrayHelper::getValue($item, 'template', $this->labelTemplate);

            $replace = !empty($item['icon']) ? [
                '{label}' => $item['label'],
                '{icon}' => '<i class="fa ' . $item['icon'] . '"></i> '
            ] : [
                '{label}' => $item['label'],
            ];

            return strtr($template, $replace);
        }
    }

    /**
     * @inheritdoc
     */
    protected function normalizeItems($items, &$active)
    {
        foreach ($items as $i => $item) {
            if (isset($item['visible']) && !$item['visible']) {
                unset($items[$i]);
                continue;
            }
            if (!isset($item['label'])) {
                $item['label'] = '';
            }
            $encodeLabel = isset($item['encode']) ? $item['encode'] : $this->encodeLabels;
            $items[$i]['label'] = $encodeLabel ? Html::encode($item['label']) : $item['label'];
            $items[$i]['icon'] = isset($item['icon']) ? $item['icon'] : '';
            $hasActiveChild = false;
            if (isset($item['items'])) {
                $items[$i]['items'] = $this->normalizeItems($item['items'], $hasActiveChild);
                if (empty($items[$i]['items']) && $this->hideEmptyItems) {
                    unset($items[$i]['items']);
                    if (!isset($item['url'])) {
                        unset($items[$i]);
                        continue;
                    }
                }
            }
            if (!isset($item['active'])) {
                if ($this->activateParents && $hasActiveChild || $this->activateItems && $this->isItemActive($item)) {
                    $active = $items[$i]['active'] = true;
                } else {
                    $items[$i]['active'] = false;
                }
            } elseif ($item['active']) {
                $active = true;
            }
        }

        return array_values($items);
    }
}
