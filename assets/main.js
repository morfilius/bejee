$('form').on('submit',function (e) {
    var data;

    $self = this;

    data = new FormData(this);
    $.ajax({
        url: $(this).prop('action'),
        data: data,
        processData: false,
        contentType: false,
        type: 'POST',
        success: function(response){
            $($self).find('.invalid-feedback').remove();
            $($self).find('input,textarea').removeClass('is-invalid');
            if(response.status === 'error') {
                for(var input in response.fields) {
                    $($self).find('input[name="'+input+'"],textarea[name="'+input+'"]').addClass('is-invalid').closest('.form-group').append('<div class="invalid-feedback">'+response.fields[input]+'</div>');
                }
            }else {
                window.location.replace("/");
            }
        }
    });
    e.preventDefault();
});