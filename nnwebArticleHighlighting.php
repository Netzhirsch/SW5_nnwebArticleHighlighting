<?php
namespace nnwebArticleHighlighting;

use Shopware\Components\Plugin;
use Shopware\Components\Plugin\Context\InstallContext;
use Shopware\Components\Plugin\Context\UninstallContext;

class nnwebArticleHighlighting extends Plugin {

    private $styles = [
        ['value' => 'Slide',  'key' => 'slide'],
        ['value' => 'Shake',  'key' => 'shake'],
        ['value' => 'Pulse',  'key' => 'pulse'],
        ['value' => 'Grow',   'key' => 'grow'],
        ['value' => 'Shrink', 'key' => 'shrink'],
        ['value' => 'Fade',   'key' => 'fade']
    ];

    private $events = [
        ['value' => 'Sobald der Artikel beim Scrollen sichtbar ist.',  'key' => 'visible'],
        ['value' => 'Sobald der Artikel beim Scrollen mittig im Viewport ist.',  'key' => 'centered'],
    ];

    private $repeatings = [
        ['value' => 'Effekt nicht wiederholen.',  'key' => 'none'],
        ['value' => 'Effekt beim erneuten Eintreten des Events wiederholen.',  'key' => 'event'],
        ['value' => 'Effekt intervallmäßig wiederholen.',  'key' => 'interval'],
    ];

    public function install(InstallContext $context) {

        $attributeService = $this->container->get('shopware_attribute.crud_service');
        $this->addArticleFields($attributeService);
        $this->addCategoryFields($attributeService);
        $cacheManager = Shopware()->Container()->get('shopware.cache_manager');
        $cacheManager->clearHttpCache();
        $cacheManager->clearTemplateCache();
        $context->scheduleClearCache(InstallContext::CACHE_LIST_ALL);
    }

    public function uninstall(UninstallContext $context) {

        if($context->keepUserData())
            return;

        $attributeService = $this->container->get('shopware_attribute.crud_service');
        $this->removeArticleFields($attributeService);
        $this->removeCategoryFields($attributeService);

        $context->scheduleClearCache(InstallContext::CACHE_LIST_ALL);
    }

    private function addArticleFields($attributeService) {

        $attributeService->update(
            's_articles_attributes',
            'nn_ah_activated',
            'boolean',
            [
                'displayInBackend' => true,
                'position' => 501,
            ],
            null,
            false,
            '0'
        );

        $attributeService->update(
            's_articles_attributes',
            'nn_ah_style',
            'combobox',
            [
                'displayInBackend' => true,
                'arrayStore' => $this->styles,
                'position' => 502,
            ],
            null,
            false,
            'slide'
        );

        $attributeService->update(
            's_articles_attributes',
            'nn_ah_event',
            'combobox',
            [
                'displayInBackend' => true,
                'arrayStore' => $this->events,
                'position' => 503,
            ],
            null,
            false,
            'visible'
        );

        $attributeService->update(
            's_articles_attributes',
            'nn_ah_repeating',
            'combobox',
            [
                'displayInBackend' => true,
                'arrayStore' => $this->repeatings,
                'position' => 504,
            ],
            null,
            false,
            'none'
        );

        $attributeService->update(
            's_articles_attributes',
            'nn_ah_repeating_interval',
            'integer',
            [
                'displayInBackend' => true,
                'position' => 505,
            ],
            null,
            false,
            '5000'
        );
    }

    private function removeArticleFields($attributeService) {

        if($attributeService->get('s_articles_attributes', 'nn_ah_activated'))
            $attributeService->delete('s_articles_attributes','nn_ah_activated');

        if($attributeService->get('s_articles_attributes', 'nn_ah_style'))
            $attributeService->delete('s_articles_attributes','nn_ah_style');

        if($attributeService->get('s_articles_attributes', 'nn_ah_event'))
            $attributeService->delete('s_articles_attributes','nn_ah_event');

        if($attributeService->get('s_articles_attributes', 'nn_ah_repeating'))
            $attributeService->delete('s_articles_attributes','nn_ah_repeating');

        if($attributeService->get('s_articles_attributes', 'nn_ah_repeating_interval'))
            $attributeService->delete('s_articles_attributes','nn_ah_repeating_interval');

    }

    private function addCategoryFields($attributeService) {

        $attributeService->update(
            's_categories_attributes',
            'nn_ah_activated',
            'boolean',
            [
                'displayInBackend' => true,
                'position' => 501,
            ],
            null,
            false,
            '0'
        );

        $attributeService->update(
            's_categories_attributes',
            'nn_ah_style',
            'combobox',
            [
                'displayInBackend' => true,
                'arrayStore' => $this->styles,
                'position' => 502,
            ],
            null,
            false,
            'slide'
        );

        $attributeService->update(
            's_categories_attributes',
            'nn_ah_event',
            'combobox',
            [
                'displayInBackend' => true,
                'arrayStore' => $this->events,
                'position' => 503,
            ],
            null,
            false,
            'visible'
        );

        $attributeService->update(
            's_categories_attributes',
            'nn_ah_repeating',
            'combobox',
            [
                'displayInBackend' => true,
                'arrayStore' => $this->repeatings,
                'position' => 504,
            ],
            null,
            false,
            'none'
        );

        $attributeService->update(
            's_categories_attributes',
            'nn_ah_repeating_interval',
            'integer',
            [
                'displayInBackend' => true,
                'position' => 505,
            ],
            null,
            false,
            '5000'
        );

    }

    private function removeCategoryFields($attributeService) {

        if($attributeService->get('s_categories_attributes', 'nn_ah_activated'))
            $attributeService->delete('s_categories_attributes','nn_ah_activated');

        if($attributeService->get('s_categories_attributes', 'nn_ah_style'))
            $attributeService->delete('s_categories_attributes','nn_ah_style');

        if($attributeService->get('s_categories_attributes', 'nn_ah_event'))
            $attributeService->delete('s_categories_attributes','nn_ah_event');

        if($attributeService->get('s_categories_attributes', 'nn_ah_repeating'))
            $attributeService->delete('s_categories_attributes','nn_ah_repeating');

        if($attributeService->get('s_categories_attributes', 'nn_ah_repeating_interval'))
            $attributeService->delete('s_categories_attributes','nn_ah_repeating_interval');

    }

}

?>