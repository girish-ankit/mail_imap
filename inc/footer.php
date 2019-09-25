<script>
    $(document).ready(function () {
        var pageId = $("#page-id").attr('data-value');
        console.log(pageId);

        $('#left-menu a').each(function () {
            var href = $(this).attr('href');
            console.log(href);
            $(this).removeClass();
            if (pageId == href) {
                $(this).addClass('active');
            }
        });
    });
</script>

</body>
</html>


