

<script type="text/javascript">
    $(document).ready(function() {
        $('.area').change(function() {
            var area = $(this);
            $.get($(this).data('url'), {'parent_id': $(this).val()}, function(options) {
                var html = '';
                for (var value in options) {
                    html += '<option value="' + value + '">' + options[value] + '</option>';
                }
                var childArea = $('.' + area.data('child-area'));
                childArea.html(html);
                childArea.parent().find('span').html('');
                while (childArea.data('child-area')) {
                    childArea = $('.' + childArea.data('child-area'));
                    childArea.parent().find('span').html('');
                    childArea.html('');
                }
            }, 'json');
        });
    });
</script>
