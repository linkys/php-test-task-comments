$(function() {

    $('#form-add-comment').on('submit', function (e) {
        e.preventDefault();

        var form = $(this);

        clear_errors(form);

        $.ajax({
            method: 'POST',
            url: form.attr('action'),
            data: form.serialize(),
            timeout: 15000,
            success: function(response) {
                if(response.status) {
                    add_new_comment(form, response.data);
                } else {
                    show_errors(form, response.errors);
                }
            },
            error: function(XMLHttpRequest) {
                if (XMLHttpRequest.readyState === 0) {
                    showAjaxFailedAlert()
                }
            }
        });
    });

    function add_new_comment(form, data) {

        form.trigger('reset');

        var comment = '<li style="display: none;" class="media" data-comment-id="' + data.id + '">\n' +
                        '   <div class="media-body mb-4">\n' +
                        '       <h5 class="mt-0 mb-1">' + data.name + '</h5>\n' +
                        '       <h6 class="mt-0 mb-1"><a href="mailto:' + data.email + '">' + data.email + '</a></h6>\n' +
                        '       <p class="mt-0 mb-1"><small class="text-muted">' + data.created_at + '</small></p>\n' +
                        '       ' + data.message + '</div>\n' +
                        '   </li>';

        $('.comments-holder').prepend(comment);
        $('.comments-holder .media').first().slideDown();

        $('.add-comment-success').slideDown();

        setTimeout(function () {
            $('.add-comment-success').slideUp();
        }, 2000);
    }

    function show_errors(form, errors) {
        for (var i in errors) {
            form.find('[name=' + i + ']')
                .siblings('.error-message').text(errors[i])
                .parent().addClass('has-error');
        }
    }
    
    function showAjaxFailedAlert() {
        $('.ajax-failed-alert').slideDown();
        setTimeout(function () {
            $('.ajax-failed-alert').slideUp();
        }, 2000);        
    }

    function clear_errors(form) {
        form.find('.has-error').removeClass('has-error');
    }

    $('#form-search-comment')
        .on('submit', function (e) {
            e.preventDefault();

            var form = $(this);

            $.ajax({
                method: 'GET',
                url: form.attr('action'),
                data: form.serialize(),
                timeout: 15000,
                success: function(response) {
                    show_comments_by_ids(response.ids);
                },
                error: function(XMLHttpRequest) {
                    if (XMLHttpRequest.readyState === 0) {
                        showAjaxFailedAlert()
                    }
                }
            });
        })
        .on('reset', function () {
            $('.comments-holder .media').show();
        });


    function show_comments_by_ids(ids) {
        if(ids.length) {
            ids.forEach(function (e) {
                $('.comments-holder .media').show()
                    .filter(function(i, e) {
                        return ids.indexOf($(e).data('comment-id')) === -1;
                    })
                    .hide();
            });
        } else {
            $('.comments-holder .media').hide();
        }
    }

});