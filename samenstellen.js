quantityInputs.forEach(function(input) {
    input.addEventListener('change', function() {
        var maxQuantity = parseInt(this.getAttribute('max'));
        var quantity = parseInt(this.value);

        if (quantity > maxQuantity) {
            this.value = maxQuantity;
        }
    });
});

$(document).ready(function() {
    function updateProductList() {
        var searchQuery = $("#search-input").val();
        var firstLetter = searchQuery.charAt(0).toUpperCase();

        $.ajax({
            url: "process_products.php",
            type: "GET",
            data: { search: firstLetter },
            success: function(response) {
                $("#product-list").html(response);
            },
            error: function(xhr, status, error) {
                console.log(error);
            }
        });
    }
    $("#search-input").on("keyup", function() {
        updateProductList();
    });
});
