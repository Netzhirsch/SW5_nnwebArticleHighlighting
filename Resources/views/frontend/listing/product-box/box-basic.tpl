{extends file="parent:frontend/listing/product-box/box-basic.tpl"}

{block name="frontend_listing_box_article"}
    {$classes = 'nnweb_article_highlighting'}

    {$active = false}
    {$interval_str = ''}

    {$config = $nnwebArticleHighlightingConfiguration}
    

    {* Artikel aktiviert *}
    {if $sArticle.attributes.core->get('nn_ah_activated')}

        {$active = true}
        {$active_by = 'active_by_article'}
        {$style = $sArticle.attributes.core->get('nn_ah_style')}
        {$event = $sArticle.attributes.core->get('nn_ah_event')}
        {$repeating = $sArticle.attributes.core->get('nn_ah_repeating')}
        {$interval = $sArticle.attributes.core->get('nn_ah_repeating_interval')}

    {* Kategorie aktiviert *}
    {elseif $sCategoryContent.attribute.nn_ah_activated}

        {$active = true}
        {$active_by = 'active_by_category'}
        {$style = $sCategoryContent.attribute.nn_ah_style}
        {$event = $sCategoryContent.attribute.nn_ah_event}
        {$repeating = $sCategoryContent.attribute.nn_ah_repeating}
        {$interval = $sCategoryContent.attribute.nn_ah_repeating_interval}

    {* Global aktiviert *}
    {elseif
        ($config.activate_for_all) ||
        ($config.activate_for_new && $sArticle.attributes.marketing->isNew()) ||
        ($config.activate_for_topSeller && $sArticle.attributes.marketing->isTopseller()) ||
        ($config.activate_for_sale && $sArticle.prices[0].has_pseudoprice)
    }
        {$active = true}
        {$active_by = 'active_by_global'}
        {$style = $config.style}
        {$event = $config.event}
        {$repeating = $config.repeating}
        {$interval = $config.repeating_interval}

    {/if}

    {if $active}
        {$classes = $classes|cat:' '|cat:$active_by}
        {$classes = $classes|cat:' style-'|cat:$style}
        {$classes = $classes|cat:' event-'|cat:$event}
        {$classes = $classes|cat:' repeating-'|cat:$repeating}

        {if $repeating eq 'interval' && $interval > 0}
            {$interval_str = 'data-interval="'|cat:$interval|cat:'"'}
        {/if}

        <span class="{$classes}" {$interval_str}></span>
    {/if}

    {$smarty.block.parent}
{/block}