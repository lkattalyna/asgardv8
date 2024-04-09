<script>
    $('#confirm-delete').on('show.bs.modal', function (e) {
        var formulario = createForm();
        function createForm() {
            var form =
                $('<form>', {
                    'method': 'POST',
                    'action': $(e.relatedTarget).data('href')
                });

            var token =
                $('<input>', {
                    'type': 'hidden',
                    'name': '_token',
                    'value': '<?php echo csrf_token(); ?>' // hmmmm...
                });

            var hiddenInput =
                $('<input>', {
                    'name': '_method',
                    'type': 'hidden',
                    'value': 'DELETE'
                });

            return form.append(token, hiddenInput).appendTo('body');
        }
        $(this).find('.btn-ok').on('click', function () {
            formulario.submit();
        });
    });
</script>

