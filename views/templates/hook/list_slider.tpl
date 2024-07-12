<style>
.next-prev button {
    color: #99a3a6;
    background-color: #ecf0ef;
    border: none;
    border-radius: 100%;
    padding: 5px;
    font-weight: bold;
    height: 35px;
    width: 35px;
}
.next-prev button:hover {
    background-color: #0075a7;
    color: white;
}
.overflow_content {
    overflow-x: hidden;
    position: relative;
    scroll-behavior: smooth;
}
.sitefix_container_product .product_container {
    display: flex;
    transition: 2s all;
}
.next-prev {
    display: flex;
    justify-content: space-between;
    margin-top: 50px;
}
.sitefix_categories_name{
    font-size:12px
}
body{
    overflow-x: hidden;
}
.product_container > div{
    min-width: 200px;
    margin-right: 20px;
}
</style>

<div class="sitefix_container_product">
    {foreach from=$PRODUCTS item=item key=key name=name}
        <div class="container_sitefix_flex" id="container_{$key}">
            <div class="next-prev">
                <h3 class="sitefix_categories_name"> {$item.categoryName}</h3>
                <div>
                    <button class="prev" data-target="container_{$key}"> < </button>
                    <button class="next" data-target="container_{$key}"> > </button>
                </div>
            </div>
            <input type="hidden" value={$controllerLink} name="controllerLink">
            <hr>
            <div class="overflow_content">
                <div class="product_container">
                    {foreach from=$item.productFromCategories item=product}
                        {include file="catalog/_partials/miniatures/product.tpl" product=$product}
                    {/foreach}
                </div>
            </div>
        </div>
    {/foreach}
</div>
