$(document).ready(function() {
    // Select2
    $('#user_id_select').select2({
        placeholder: "Pilih user...",
        allowClear: false,
        disabled: true,
        width: '100%'
    });

    // Show user info
    function showUserInfo() {
        let val = $('#user_id_select').val();
        if (!val) {
            $('#existing-user-info').hide();
            return;
        }
        let selected = $('#user_id_select').find('option:selected');
        $('#existing-user-name').text(selected.data('name'));
        $('#existing-user-birthdate').text(selected.data('birthdate') || '-');
        $('#existing-user-gender').text(selected.data('gender') || '-');
        $('#existing-user-phone').text(selected.data('phone') || '-');
        $('#existing-user-alamat').text(selected.data('alamat') || '-');
        $('#existing-user-info').show();
    }

    $('#user_id_select').on('change', showUserInfo);

    // On page load, show info for selected user
    showUserInfo();
});