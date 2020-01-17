$(document).ready(function()
{
    $('a.i-icon').each(function() {
        var me = $(this);
        $(this).qtip({
            content: {
                text: me.parent().next('.tooltiptext')
            },
            position: {
                viewport: $(window)
            },
            style: 'qtip-wiki',
            hide: {
                fixed: true,
                delay: 300
            }
        });
    });
});