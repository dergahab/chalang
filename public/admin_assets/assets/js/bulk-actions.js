$(document).ready(function () {
    // Select All functionality
    $('#select-all').on('change', function () {
        $('.bulk-item').prop('checked', $(this).prop('checked'));
        toggleBulkButton();
    });

    // Individual item selection
    $(document).on('change', '.bulk-item', function () {
        let allChecked = $('.bulk-item:checked').length === $('.bulk-item').length;
        $('#select-all').prop('checked', allChecked);
        toggleBulkButton();
    });

    // Toggle Delete Button visibility
    function toggleBulkButton() {
        let count = $('.bulk-item:checked').length;
        if (count > 0) {
            $('#bulk-delete-btn').fadeIn().find('.count').text(count);
        } else {
            $('#bulk-delete-btn').fadeOut();
        }
    }

    // Bulk Delete Action
    $('#bulk-delete-btn').on('click', function () {
        let ids = [];
        $('.bulk-item:checked').each(function () {
            ids.push($(this).val());
        });

        let model = $(this).data('model');

        if (ids.length === 0) return;

        if (confirm('Selected ' + ids.length + ' item(s) will be deleted. Continue?')) {
            const bulkDeleteUrl = $(this).data('bulkDeleteUrl') || $(this).data('url') || '/admin/bulk-delete';
            $.ajax({
                url: bulkDeleteUrl,
                type: 'POST',
                data: {
                    ids: ids,
                    model: model,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    toastr.success(response.message);
                    // Remove deleted rows
                    $('.bulk-item:checked').each(function () {
                        $(this).closest('tr').remove();
                    });
                    $('#select-all').prop('checked', false);
                    toggleBulkButton();
                },
                error: function (xhr) {
                    const message = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : 'Bulk delete failed.';
                    toastr.error(message);
                }
            });
        }
    });
});
