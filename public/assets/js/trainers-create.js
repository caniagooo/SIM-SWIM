$(document).ready(function() {
    function toggleForm() {
        if ($('#register_new').is(':checked')) {
            $('#form-user-baru').show();
            $('#form-user-existing').hide();
            $('#existing-user-info').hide();
        } else {
            $('#form-user-baru').hide();
            $('#form-user-existing').show();
            $('#user_id_select').val('').trigger('change');
        }
    }
    $('input[name="register_type"]').on('change', toggleForm);
    toggleForm();

    $('#user_id_select').select2({
        placeholder: "Pilih user...",
        allowClear: true,
        width: '100%'
    });

    $('#user_id_select').on('change', function() {
        let val = $(this).val();
        if (!val) {
            $('#existing-user-info').hide();
            return;
        }
        let selected = $(this).find('option:selected');
        $('#existing-user-name').text(selected.data('name'));
        $('#existing-user-birthdate').text(selected.data('birthdate') || '-');
        $('#existing-user-gender').text(selected.data('gender') || '-');
        $('#existing-user-phone').text(selected.data('phone') || '-');
        $('#existing-user-alamat').text(selected.data('alamat') || '-');
        $('#existing-user-info').show();
    });
});