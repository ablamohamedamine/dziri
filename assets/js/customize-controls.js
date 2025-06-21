jQuery(document).ready(function($) {

    // Multiple Checkboxes for Products Tabs

    $('.customize-control-checkbox-multiple input[type="checkbox"]').on('change', function() {
      
        var checkboxValues = $(this).parents('.customize-control').find('input[type="checkbox"]:checked').map(function() {
          return this.value;
        }).get().join(',');
        $(this).parents('.customize-control').find('input[type="hidden"]').val(checkboxValues).trigger('change');
    });

    if (typeof savedHomeProducts !== 'undefined') {
        var selectedValues = savedHomeProducts.split(',');
        $('.customize-control-checkbox-multiple input[type="checkbox"]').each(function() {
            if (selectedValues.indexOf($(this).val()) !== -1) {
                $(this).prop('checked', true);
            } else {
                $(this).prop('checked', false);
            }
        });
    }
    
    wp.customize.bind('change', function() { 
        wp.customize.previewer.refresh();
    });

    // COD or Add To Cart Live Preview

    wp.customize('cod_add_to_cart', function(value) {
        value.bind(function(newValue) {
            
            $.ajax({
                url: ajaxurl, 
                type: 'POST',
                data: {
                    action: 'save_cod_add_to_cart',  
                    cod_add_to_cart: newValue,  
                },
                success: function(response) {
                    console.log(response);
                    wp.customize.previewer.refresh();
                } 
            });
        });
    });
});