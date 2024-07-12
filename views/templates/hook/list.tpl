<style>
.sitefix_product_container{
    display: flex;
    flex-wrap: wrap;
}
.sitefix_next-prev{
    margin-top: 20px;
    margin-bottom: 20px;
}
.sitefix_categories_name{
    font-size: 14px;
}
</style>

<div class="sitefix_container_product">
    {foreach from=$PRODUCTS item=item key=key name=name}
        <div class="container_sitefix_flex">
            <div class="sitefix_next-prev ">
                <h3 class="sitefix_categories_name"> {$item.categoryName}</h3>
            </div>
            <input type="hidden" value={$controllerLink} name="controllerLink">
            <hr>
            <div class="sitefix_product_container">
            {foreach from=$item.productFromCategories item=$product}
                {include file="catalog/_partials/miniatures/product.tpl" product=$product}
            {/foreach}
            </div>
        </div>
    {/foreach}
</div>

<script>
