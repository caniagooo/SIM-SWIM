$(document).ready(function() {
    // Toggle form
    function toggleForm() {
        if ($('#register_new').is(':checked')) {
            $('#form-user-baru').show();
            $('#form-user-existing').hide();
            $('#existing-user-info').hide();
            $('#age_group_input').val('');
        } else {
            $('#form-user-baru').hide();
            $('#form-user-existing').show();
            $('#user_id_select').val('').trigger('change');
            $('#age_group_input').val('');
        }
    }
    $('input[name="register_type"]').on('change', toggleForm);
    toggleForm();

    // Select2
    $('#user_id_select').select2({
        placeholder: "Pilih user...",
        allowClear: true,
        width: '100%'
    });

    // Show user info & kelompok usia
    $('#user_id_select').on('change', function() {
        let val = $(this).val();
        if (!val) {
            $('#existing-user-info').hide();
            $('#age_group_input').val('');
            return;
        }
        let selected = $(this).find('option:selected');
        $('#existing-user-name').text(selected.data('name'));
        $('#existing-user-birthdate').text(selected.data('birthdate') || '-');
        $('#existing-user-gender').text(selected.data('gender') || '-');
        $('#existing-user-phone').text(selected.data('phone') || '-');
        $('#existing-user-alamat').text(selected.data('alamat') || '-');
        $('#existing-user-info').show();
        setAgeGroup(selected.data('birthdate'));
    });

    // Kelompok usia otomatis user baru
    $('#birth_date_input').on('change', function() {
        setAgeGroup(this.value);
    });

    function setAgeGroup(birthDate) {
        let ageGroupInput = document.getElementById('age_group_input');
        if (!birthDate) {
            ageGroupInput.value = '';
            return;
        }
        const today = new Date();
        const birth = new Date(birthDate);
        let age = today.getFullYear() - birth.getFullYear();
        const m = today.getMonth() - birth.getMonth();
        if (m < 0 || (m === 0 && today.getDate() < birth.getDate())) {
            age--;
        }
        let group = '';
        if (age < 5) group = 'balita';
        else if (age < 12) group = 'anak-anak';
        else if (age < 18) group = 'remaja';
        else group = 'dewasa';
        ageGroupInput.value = group;
    }
});