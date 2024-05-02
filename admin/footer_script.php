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
</script>