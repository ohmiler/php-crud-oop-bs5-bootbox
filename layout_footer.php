</div>
    
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/6.0.0/bootbox.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // JavaScript for deleting product
        $(document).on('click', '.delete-object', function() {
            console.log('test')
            let id = $(this).attr('delete-id');

            bootbox.confirm({
                message: `<h4>Are you sure you want to delete product id ${id}</h4>`,
                buttons: {
                    confirm: {
                        label: "<i class='bi bi-check'></i> Yes",
                        className: 'btn btn-danger'
                    },
                    cancel: {
                        label: "<i class='bi bi-x'></i> No",
                        className: 'btn btn-primary'
                    }
                },
                callback: function(result) {
                    if (result == true) {
                        $.post('delete_product.php', {
                            object_id: id
                        }, function(data) {
                            location.reload();
                        }).fail(function() {
                            alert("Unable to delete.");
                        })
                    }
                }
            })
        })
    </script>

</body>
</html>