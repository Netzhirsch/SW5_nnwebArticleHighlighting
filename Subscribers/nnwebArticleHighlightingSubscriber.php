<?php

namespace nnwebArticleHighlighting\Subscribers;

use Enlight\Event\SubscriberInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Enlight_Event_EventArgs;
use Enlight_View_Default;
use Shopware\Components\Theme\LessDefinition;

class nnwebArticleHighlightingSubscriber implements SubscriberInterface {

    public static function getSubscribedEvents() {
        return [
            'Enlight_Controller_Action_PreDispatch_Frontend' => 'onPreDispatch',
            'Enlight_Controller_Action_PostDispatch_Frontend' => 'onPostDispatch',
            'Theme_Compiler_Collect_Plugin_Less' => 'addLessFiles',
            'Theme_Compiler_Collect_Plugin_Javascript' => 'addJavascriptFiles',
        ];
    }

    public function onPreDispatch(Enlight_Event_EventArgs $args) {
        /** @var Enlight_View_Default $view */
        $view = $args->get('subject')->View();
        $view->addTemplateDir(__DIR__ . '/../Resources/views');
    }

    public function onPostDispatch(Enlight_Event_EventArgs $args) {
        $config = Shopware()->Container()->get('shopware.plugin.config_reader')->getByPluginName('nnwebArticleHighlighting');

        /** @var Enlight_View_Default $view */
        $view = $args->get('subject')->View();
        $view->assign('nnwebArticleHighlightingConfiguration', $config);
    }

    public function addLessFiles() {
        $less = new LessDefinition(
            [],
            [__DIR__ . '/../Resources/views/frontend/_public/src/less/all.less'],
            __DIR__ . '/../'
        );

        return new ArrayCollection([$less]);
    }

    public function addJavascriptFiles(){
        $js = [__DIR__ . '/../Resources/views/frontend/_public/src/js/general.js'];
        return new ArrayCollection($js);
    }
}