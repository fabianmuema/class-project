$(document).ready(function () {

    // validate the category section
    $('#submit').prop('disabled', true);

    $('#msform').change(function () {
        $('#submit').prop('disabled', false);
    })

    // validate the item category details page
    var name = $('#name').val();
    var description = $('#description').val();
    var category = $('#category').val();
    var price = $('#price').val();
    var days = $('#days').val();
    var nameError = descriptionError = categoryError = priceError = daysError = '';

    $('#submit').click(function () {
       
        if (price == '') {
            priceError = 'Item price is required';
        }

        if (description == '') {
            descriptionError = 'Item description is required';
        }

        if (category == '') {
            categoryerror = 'Item category is required';
        }

        if (days == '') {
            daysError = 'Number of days is required';
        }

        $('#name').blur(function () {
            if (!$(this).val()) {
                 nameError = 'Item name is required';
                 $('#name').val(nameError);
            }
        });

    })

    




})