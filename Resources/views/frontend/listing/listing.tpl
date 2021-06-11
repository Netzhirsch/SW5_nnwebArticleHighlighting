{extends file="parent:frontend/listing/listing.tpl"}

{block name="frontend_listing_list_inline"}
    {foreach $sArticles as $sArticle}
        {include file="frontend/listing/box_article.tpl" scope="parent"}
    {/foreach}
{/block}