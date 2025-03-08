$(document).ready(function () {
    $('.filter-checkbox').change(function () {
        var selectedCategories = [];
        $('.filter-checkbox:checked').each(function () {
            selectedCategories.push($(this).val());
        });
        var url = new URL(window.location.href);
        if (selectedCategories.length > 0) {
            url.searchParams.set('category', selectedCategories.join(','));
        } else {
            url.searchParams.delete('category');
        }
        window.location.href = url.href;
    });
    
});
