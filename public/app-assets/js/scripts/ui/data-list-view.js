/*=========================================================================================
    File Name: data-list-view.js
    Description: List View
    ----------------------------------------------------------------------------------------
    Item Name: Vuexy  - Vuejs, HTML & Laravel Admin Dashboard Template
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

$(document).ready(function() {
    "use strict"
    // init list view datatable
    var dataListView = $(".data-list-view").DataTable({
        responsive: false,
        columnDefs: [{
            orderable: true,
            targets: 0,
            checkboxes: { selectRow: true }
        }],
        select: {
            style: 'os',
            selector: 'td:nth-child(2)'
        },
        dom: '<"top"<"actions action-btns"B><"action-filters"lf>><"clear">rt<"bottom"<"actions">p>',
        oLanguage: {
            sLengthMenu: "_MENU_",
            sSearch: ""
        },
        aLengthMenu: [
            [4, 10, 15, 20],
            [4, 10, 15, 20]
        ],
        select: {
            style: "multi"
        },
        order: [
            [1, "asc"]
        ],
        bInfo: false,
        pageLength: 10,
        buttons: [{
            text: "<i class='feather icon-plus'></i> اضافه کردن",
            action: function() {
                $(this).removeClass("btn-secondary")
                $(".add-new-data").addClass("show")
                $(".overlay-bg").addClass("show")
                $("#data-name, #data-price").val("")
                $("#data-category, #data-status").prop("selectedIndex", 0)
            },
            className: "btn-outline-primary action-add"
        }],
        initComplete: function(settings, json) {
            $(".dt-buttons .btn").removeClass("btn-secondary")
        }
    });

    dataListView.on('draw.dt', function() {
        setTimeout(function() {
            if (navigator.userAgent.indexOf("Mac OS X") != -1) {
                $(".dt-checkboxes-cell input, .dt-checkboxes").addClass("mac-checkbox")
            }
        }, 50);
    });

    // init thumb view datatable
    var dataThumbView = $(".data-thumb-view").DataTable({
        responsive: false,
        columnDefs: [{
            orderable: true,
            targets: 0,
            checkboxes: { selectRow: true }
        }],
        dom: '<"top"<"actions action-btns"B><"action-filters"lf>><"clear">rt<"bottom"<"actions">p>',
        oLanguage: {
            sLengthMenu: "_MENU_",
            sSearch: ""
        },
        aLengthMenu: [
            [4, 10, 15, 20],
            [4, 10, 15, 20]
        ],
        select: {
            style: "multi"
        },
        order: [
            [1, "asc"]
        ],
        bInfo: false,
        pageLength: 4,
        buttons: [{
            text: "<i class='feather icon-plus'></i> اضافه کردن",
            action: function() {
                $(this).removeClass("btn-secondary")
                $(".add-new-data").addClass("show")
                $(".overlay-bg").addClass("show")
            },
            className: "btn-outline-primary"
        }],
        initComplete: function(settings, json) {
            $(".dt-buttons .btn").removeClass("btn-secondary")
        }
    })

    dataThumbView.on('draw.dt', function() {
        setTimeout(function() {
            if (navigator.userAgent.indexOf("Mac OS X") != -1) {
                $(".dt-checkboxes-cell input, .dt-checkboxes").addClass("mac-checkbox")
            }
        }, 50);
    });

    // To append actions dropdown before اضافه کردن button
    var actionDropdown = $(".actions-dropodown")
    actionDropdown.insertBefore($(".top .actions .dt-buttons"))


    // Scrollbar
    if ($(".data-items").length > 0) {
        new PerfectScrollbar(".data-items", { wheelPropagation: false })
    }

    // Close sidebar
    $(".hide-data-sidebar, .cancel-data-btn, .overlay-bg").on("click", function() {
        $(".add-new-data").removeClass("show")
        $(".overlay-bg").removeClass("show")
        $("#data-name, #data-price").val("")
        $("#data-category, #data-status").prop("selectedIndex", 0)
    })

    // // On Edit
    // $('.action-edit').on("click",function(e){
    //   e.stopPropagation();
    //   $('#data-name').val('Altec Lansing - Bluetooth Speaker');
    //   $('#data-price').val('$99');
    //   $(".add-new-data").addClass("show");
    //   $(".overlay-bg").addClass("show");
    // });

    // On Delete
    // $('.action-delete').on("click", function(e) {
    //     e.stopPropagation();
    //     $(this).closest('td').parent('tr').fadeOut();
    // });

    // dropzone init
    Dropzone.options.dataListUpload = {
        complete: function(files) {
            var _this = this
                // checks files in class dropzone and remove that files
            $(".hide-data-sidebar, .cancel-data-btn, .actions .dt-buttons").on(
                "click",
                function() {
                    $(".dropzone")[0].dropzone.files.forEach(function(file) {
                        file.previewElement.remove()
                    })
                    $(".dropzone").removeClass("dz-started")
                }
            )
        }
    }
    Dropzone.options.dataListUpload.complete()

    // mac chrome checkbox fix
    if (navigator.userAgent.indexOf("Mac OS X") != -1) {
        $(".dt-checkboxes-cell input, .dt-checkboxes").addClass("mac-checkbox")
    }

    $('.dt-checkboxes-cell input[type="checkbox"]').each(function(index) {
        $(this).attr('name', 'id[]')
        $(this).val($(this).parents('tr').attr('row'))
    });

    // Handle form submission event 
    $('#form-datatable').on('submit', function(e) { e.preventDefault(); })
    $('#form-datatable [name="type"]').on('click', function(e) {
        e.preventDefault();
        var form_data = new FormData(document.getElementById("form-datatable"));
        var table = $('.data-list-view').DataTable();

        var rows_selected = table.rows('.selected').data();
        $('.hidenselected').remove();
        $.each(rows_selected, function(index, rowId) {
            form_data.append('row[]', rowId[0]);
        });

        form_data.append('type', $(this).val());

        let url = $('#form-datatable').attr('action');
        let type = $('#form-datatable').attr('method');
        let data = $('#form-datatable').serialize();
        $.ajax({
            url: url,
            type: type,
            data: form_data, //$(this).serialize(),
            processData: false,
            async: false,
            contentType: false,
            success: function(response) {
                // console.log(response)
                if (response.status === 'success') {
                    location.reload();
                }
                messageToast(response.title, response.message, response.status, 5000)
            }
        })

    });
})