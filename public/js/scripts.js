$(() => {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    // $('ul.menu-content a').each()

    $("ul.menu-content a").each(function(index) {
        // console.log(index + ": " + $(this).text());
        if (window.location.href === $(this).attr('href')) {
            $(this).parent().addClass('active hhhh');
        }
    });

    $(document).on('click', '.icon-rotate-cw', function() {
        $(this).parents('.card').find('input').val('')
        $(this).parents('.card').find('select option[value=""]').prop('selected', true)

        var table = $('.data-list-view').DataTable();
        if (table) table.draw();

    })


    $(document).on('submit', '.ajaxForm', function(e) {
        e.preventDefault();
        let url = $(this).attr('action');
        let type = $(this).attr('method');
        let data = $(this).serialize();
        let this_ = $(this);

        $.ajax({
            url: url,
            type: type,
            url: url,
            data: data,
            beforeSend: function() {
                $('.help-block').text('');
                this_.find('button[type="submit"]').html('Ù…Ù†ØªØ¸Ø± Ø¨Ù…Ø§Ù†ÛŒØ¯ <i class="fas fa-compact-disc fa-spin"></i>');
            },
            success: function(response) {
                console.info(response);

                // if (response.status == 'success')
                //     this_.find('button[type="submit"]').html('Ù…ÙˆÙÙ‚');

                messageToast(response.title, response.message, response.status, 5000)

            },
            error: function(request, status, error) {
                this_.find('button[type="submit"]').html(' <i class="panel-control-icon glyphicon glyphicon-remove"></i> ØªÙ„Ø§Ø´ Ø¯ÙˆØ¨Ø§Ø±Ù‡');
                json = $.parseJSON(request.responseText);

                $.each(json.errors, function(key, value) {
                    $('.error-' + key).text(value);
                });
                messageToast('', 'خطاهای پیش آمده را رفع نمایید.', 'error', 5000)

            }

        })
    });

    $(document).on('submit', '.ajaxUpload', function(e) {
        e.preventDefault();


        // var cover = $('#input-cover-file').prop('files')[0];
        var imageUrl = $('.file-upload').prop('files')[0];
        // var slug = $('.ajaxUpload ').val();
        //file-upload


        var form_data = new FormData(this); //new FormData();
        if (document.getElementsByClassName("file-upload").value != "") {
            // you have a file
            form_data.append('imageUrl', imageUrl);
        }


        let url = $(this).attr('action');
        let type = $(this).attr('method');
        let data = $(this).serialize();
        let this_ = $(this);

        $.ajax({
            type: type,
            url: url,
            data: form_data, //$(this).serialize(),
            processData: false,
            async: false,
            contentType: false,
            beforeSend: function() {
                $('.help-block').text('');
                this_.find('button[type="submit"]').html('Ù…Ù†ØªØ¸Ø± Ø¨Ù…Ø§Ù†ÛŒØ¯ <i class="fas fa-compact-disc fa-spin"></i>');
            },
            success: function(data) {

                this_.find('button[type="submit"]').html('Ø§Ø¯Ø§Ù…Ù‡');

                console.log(data.redirectEdit);
                // swal(data.title, data.message, data.status);
                Swal.fire({
                    title: data.title,
                    text: data.message,
                    type: data.status,
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ø§Ø¯Ø§Ù…Ù‡ Ùˆ Ø§ÙØ²ÙˆØ¯Ù† Ø§Ø·Ù„Ø§Ø¹Ø§Øª',
                    cancelButtonText: 'Ù†Ù…Ø§ÛŒØ´ Ù„ÛŒØ³Øª'
                }).then((result) => {
                    if (result.value) {
                        if (data.redirectEdit && typeof data.redirectEdit !== 'undefined') {
                            location.href = data.redirectEdit;
                        } else {
                            $('.wizard-next[data-wizard="next"]').click();
                        }
                    } else {
                        if (data.redirectList && typeof data.redirectList !== 'undefined') {
                            location.href = data.redirectList;
                        } else {

                        }
                    }
                });
                if (data.redirectAuto) {
                    window.location.href = data.redirectAuto;
                }

            },
            error: function(request, status, error) {
                this_.find('button[type="submit"]').html('ØªÙ„Ø§Ø´ Ø¯ÙˆØ¨Ø§Ø±Ù‡ ');
                console.log(request);
                json = $.parseJSON(request.responseText);

                $.each(json.errors, function(key, value) {
                    console.log(key + ": " + value);
                    $('.error-' + key).text(value);
                });
                Swal.fire({
                    type: "error",
                    title: "Ù†Ø§ Ù…ÙˆÙÙ‚",
                    text: "Ù„Ø·ÙØ§ Ù¾Ø³ Ø§Ø² Ø¨Ø±Ø±Ø³ÛŒ Ø®Ø·Ø§Ù‡Ø§ÛŒ Ù¾ÛŒØ´ Ø¢Ù…Ø¯Ù‡ Ø±Ø§ Ø±ÙØ¹ Ù†Ù…Ø§ÛŒÛŒØ¯.",
                });

            }
        });

    });


})

function messageToast(title, message, status, timeOut = 5000) {
    if (status === 'success') {
        toastr.success(message, title, { "timeOut": timeOut, "closeButton": true, positionClass: 'toast-top-right', containerId: 'toast-top-right' })
    } else if (status === 'warning') {
        toastr.warning(message, title, { "timeOut": timeOut, "closeButton": true, positionClass: 'toast-top-right', containerId: 'toast-top-right' })
    } else if (status === 'error') {
        toastr.error(message, title, { "timeOut": timeOut, "closeButton": true, positionClass: 'toast-top-right', containerId: 'toast-top-right' })
    } else if (status === 'info') {
        toastr.info(message, title, { "timeOut": timeOut, "closeButton": true, positionClass: 'toast-top-right', containerId: 'toast-top-right' })
    }
}

function deleteRow(url, id) {
    $.ajax({
        url: url,
        method: 'post',
        method: 'DELETE',
        data: { ajax: 'true', _method: 'delete' },
        success: function(response) {
            console.log(response)
            $('tr[row="' + id + '"]').remove();
            messageToast(response.title, response.message, response.status, 5000)
        },
        error: function(request, status, error) {
            console.log(request);
            // console.log(request.responseText);
        }
    })
    $(this).closest('td').parent('tr').fadeOut();
}