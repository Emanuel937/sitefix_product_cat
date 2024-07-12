{if $PRODUCT_FORM_CATEGORIES_LAYOUT == 1 }
    {include file="./tab.tpl"}
{/if}
{if $PRODUCT_FORM_CATEGORIES_LAYOUT == 2 }
    {include file="./list.tpl"}
{/if}
{if $PRODUCT_FORM_CATEGORIES_LAYOUT == 3 }
    {include file="./list_slider.tpl"}
{/if}

<input  type="hidden" name="controllerLink" value={$controllerLink}>

<script>
document.addEventListener('DOMContentLoaded', function() {

function scrollContainer(container, direction) {
        var scrollAmount = 0;
        function getMaxScrollLeft(container)
            {
               return container.scrollWidth - container.clientWidth;
            }

            if (direction === 'left') {
                container.scrollLeft -= 80;
                if(container.scrollLeft <= 0){
                    container.scrollLeft = getMaxScrollLeft(container);
                }
            } 
            if(direction === 'right'){
                container.scrollLeft += 80;
                if( container.scrollLeft >= getMaxScrollLeft(container) ){
                    container.scrollLeft = 0;
                }
            }
            scrollAmount += 80;
          
        
        }

    document.querySelectorAll('.prev').forEach(function(button) {
        button.addEventListener('click', function() {
            var containerId = this.getAttribute('data-target');
            var container = document.querySelector('#' + containerId + ' .overflow_content');
            scrollContainer(container, 'left');
        });
    });

    document.querySelectorAll('.next').forEach(function(button) {
        button.addEventListener('click', function() {
            var containerId = this.getAttribute('data-target');
            var container = document.querySelector('#' + containerId + ' .overflow_content');
            scrollContainer(container, 'right');
        });
    });
})
</script>