$(document).ready(function() {
    $('a.confirm').click(function() {
        return confirm('操作确认');
    });

    $('button#reset').click(function() {
        $('#key').val('');
        this.form.submit();
    });

    $('#searchForm select').change(function() {
        this.form.submit();
    });
});