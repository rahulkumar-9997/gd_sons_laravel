$(document).ready(function () {
    $(document).on('click', 'a[data-ajax-image-popup="true"]', function () {
        var product_id = $(this).data('pid');
        var title = $(this).data('title');
        var size = ($(this).data('size') == '') ? 'md' : $(this).data('size');
        var url = $(this).data('url');
        var data = {
            _token: $('meta[name="csrf-token"]').attr('content'),
            size: size,
            url: url,
            product_id: product_id
        };
        $.ajax({
            url: url,
            type: 'post',
            data: data,
            success: function (data) {
                $('#commanModel .render-data').html(data.form);
                $("#commanModel").modal('show');
            },
            error: function (data) {
                data = data.responseJSON;
            }
        });
        $("#commanModel .modal-title").html(title);
        $("#commanModel .modal-dialog").addClass('modal-' + size);        
    });
    /**Product image display code  */
    var selectedFiles = [];
    $('#commanModel').on('shown.bs.modal', function () {
        $('#product_image').on('change', function() {
            selectedFiles = Array.from(this.files);
            displayImages();
        });
    });
    function displayImages() {
        $('#image-preview').html('');
        selectedFiles.forEach(function(file, index) {
            var reader = new FileReader();
            reader.onload = function(e) {
                var imageContainer = $('<div>').addClass('image-container').css({
                    position: 'relative',
                    display: 'inline-block',
                    margin: '10px'
                });

                var img = $('<img>').attr('src', e.target.result).css({
                    width: '80px',
                    height: '80px',
                    border: '1px solid #ddd'
                });

                var sizeText = $('<p>').text('Size: ' + Math.round(file.size / 1024) + ' KB').css({
                    fontSize: '12px',
                    color: '#666',
                    marginTop: '5px',
                    textAlign: 'center'
                });
                var deleteBtn = $('<button>').html('×').css({
                    position: 'absolute',
                    top: '0',
                    right: '0',
                    backgroundColor: '#ff4444',
                    color: '#fff',
                    border: 'none',
                    width: '20px',
                    height: '20px',
                    fontSize: '16px',
                    cursor: 'pointer',
                    lineHeight: '20px',
                    textAlign: 'center'
                });

                deleteBtn.on('click', function() {
                    selectedFiles.splice(index, 1); 
                    resetInputField();
                    displayImages();
                });
                imageContainer.append(img, sizeText, deleteBtn);
                $('#image-preview').append(imageContainer);
            }

            reader.readAsDataURL(file); 
        });
    }
    function resetInputField() {
        var dataTransfer = new DataTransfer();
        selectedFiles.forEach(function(file) {
            dataTransfer.items.add(file);
        });
        $('#product_image')[0].files = dataTransfer.files;
    }
    /**Product image display code  */
    
});    