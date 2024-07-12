<head>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>

<style>
.sitefix_container_product.product_container{
    display: flex;
    flex-wrap: wrap;
}   
.nav-link{
    font-size: 12px;
    margin-top: 5px;
    margin-bottom: 3px;
}
.nav-pills .nav-link.active{
  color: #fff;
  cursor: default;
  background-color: #0075a7;
  border-radius: 5px;
}
.nav-pills .nav-link.active:hover {
  color: #fff;
  cursor: default;
  background-color: #0075a7;

}
</style>
</head>
<body>
<div class="container mt-5">
<ul class="nav nav-pills d-flex justify-content-center">
 {foreach from=$PRODUCTS item=categories name=categoryLoop}
        <li class="nav-item">
            <a class="nav-link {if $smarty.foreach.categoryLoop.first}active{/if}" href="#{$categories.categoryName|replace:' ':'_'}" data-toggle="tab">{$categories.categoryName}</a>
        </li> 
    {/foreach}
</ul>
<div class="sitefix tab-content bg-white mt-3">
    {foreach from=$PRODUCTS item=item name=productLoop}
        <div class="tab-pane {if $smarty.foreach.productLoop.first}active{/if}" id="{$item.categoryName|replace:' ':'_'}">
            <div class="sitefix_container_product product_container">
            {foreach from=$item.productFromCategories item=product}
                {include file="catalog/_partials/miniatures/product.tpl" product=$product}
            {/foreach}
            </div>
            <!-- You can add more content here -->
        </div>
    {/foreach}
</div>
</div>
</body>