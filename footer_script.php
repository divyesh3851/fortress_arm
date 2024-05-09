<script>
    var hostUrl = "<?php echo site_url() ?>/assets/";
</script>
<!--begin::Global Javascript Bundle(mandatory for all pages)-->
<script src="<?php echo site_url(); ?>/assets/plugins/global/plugins.bundle.js"></script>
<script src="<?php echo site_url(); ?>/assets/js/scripts.bundle.js"></script>

<script>
    $(".flat_time_pickr").flatpickr({
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i",
    });

    $('.flatpickr').flatpickr({
        enableTime: !1,
        dateFormat: "m/d/Y",
        allowInput: true,
    });

    function change_ymd_to_dmy_text(date = '') {

        if (!date) {
            return;
        }

        if (date == '0000-00-00') {
            return;
        }

        var dateString = date;
        var months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
        var parts = dateString.split('-');
        return formattedDate = parts[1] + '/' + parts[2] + '/' + parts[0];
        //return formattedDate = parts[2] + ', ' + months[parseInt(parts[1]) - 1] + ' ' + parts[0];
    }

    $(document).on("click", ".bookmark_page", function() {

        var bookmark_name = $(this).attr("bookmark_name");
        var bookmark_url = $(this).attr("bookmark_url");

        $("#bookmark_name").val(bookmark_name);
        $("#bookmark_url").val(bookmark_url);


    });

    $(document).on("click", ".bi-bookmarks-fill.bookmark_page", function() {

        var bookmark_url = $(this).attr("bookmark_url");

        $.post(ajax_url, {
            action: 'remove_bookmark',
            url: $('#bookmark_url').val(),
            is_ajax: true,
        }, function(result) {

            location.reload();

        });

    });

    $(document).on("click", "#save_bookmark", function() {

        $.post(ajax_url, {
            action: 'save_bookmark',
            name: $('#bookmark_name').val(),
            url: $('#bookmark_url').val(),
            notes: $('#bookmark_notes').val(),
            is_ajax: true,
        }, function(result) {

            location.reload();

        });
    });

    $(document).ready(function() {

        $('#searchInput').on('input', function() {

            var search_text = $(this).val();

            if (search_text.length >= 3) {

                $.post(ajax_url, {
                    action: 'global_search',
                    search_text: search_text,
                    is_ajax: true,
                }, function(result) {

                    displayResults(result);

                });
            }
        });

        function displayResults(results) {

            results = JSON.parse(results);

            var search_output = '<div data-kt-search-element="content" class="menu menu-sub menu-sub-dropdown py-7 px-7 overflow-hidden w-300px w-md-350px show" data-kt-menu="true" data-popper-placement="bottom-start" style="z-index: 107; position: fixed; inset: 0px auto auto 0px; margin: 0px; transform: translate(280px, 70px);">';
            search_output += '<div data-kt-search-element="wrapper">';
            if (results.links.length > 0) {
                search_output += '<div data-kt-search-element="results" class="">';
                search_output += '<div class="scroll-y mh-200px mh-lg-350px">';
                search_output += '<h3 class="fs-5 text-muted m-0 pb-5" data-kt-search-element="category-title">Important Links</h3>';
                for (var i = 0; i < results.links.length; i++) {

                    search_output += '<a href="' + results.links[i].url + '" class="d-flex text-gray-900 text-hover-primary align-items-center mb-5">';
                    search_output += '<div class="symbol symbol-40px me-4">';
                    search_output += '<span class="symbol-label bg-light">';
                    search_output += '<i class="ki-outline ki-fasten fs-2 text-primary"></i>';
                    search_output += '</span>';
                    search_output += '</div>'; // end::symbol
                    search_output += '<div class="d-flex flex-column justify-content-start fw-semibold">';
                    search_output += '<span class="fs-6 fw-semibold">' + results.links[i].name + '</span>';
                    search_output += '<span class="fs-7 fw-semibold text-muted">' + results.links[i].notes + '</span>';
                    search_output += '</div>'; // end::title
                    search_output += '</a>'; // end::Items
                }
                search_output += '</div>'; // end::scroll
                search_output += '</div>'; // end::result
            } else {
                search_output += '<div data-kt-search-element="empty" class="text-center">';
                search_output += '<div class="pt-5 pb-2">';
                search_output += '<i class="ki-outline ki-search-list fs-3x opacity-50"></i>';
                search_output += '</div>';
                search_output += '<div class="pb-5 fw-semibold">';
                search_output += '<h3 class="text-gray-600 fs-5 mb-2">No result found</h3>';
                search_output += '</div>';
                search_output += '</div>';
            }

            search_output += '</div>'; // end::Wrapper
            search_output += '</div>'; //end::Menu


            $('#searchResults').html(search_output);
        }
    });
</script>