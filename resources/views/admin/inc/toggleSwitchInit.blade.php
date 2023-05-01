<script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
<script>
    $(document).ready(function () {
        let switches = $('.toggleSwitcher');

        for (let i = 0; i < switches.length; i++) {
            $("#" + switches[i].id).bootstrapToggle({
                on: 'I',
                off: 'O'
            });
        }

        switches.on('change', function (e) {
            console.log('changed');
            togglePublishedStatus(e.target);
        });

        $('.table').on('draw', function () {
            console.log('sfsa')
        });

        function togglePublishedStatus(target) {
            $(target).attr('disabled', true);

            $.ajax({
                url: target.dataset.toggleUrl,
                method: 'GET',
                success: function (data) {
                    console.log(data);
                    $(target).attr('disabled', false);
                }
            });
        }
    });
</script>
