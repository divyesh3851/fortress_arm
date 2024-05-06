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
</script>