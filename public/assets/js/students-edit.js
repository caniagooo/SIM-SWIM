$(document).ready(function() {
    // Select2
    $('#user_id_select').select2({
        placeholder: "Pilih user...",
        allowClear: false,
        width: '100%'
    });

    // Show user info & kelompok usia
    function showUserInfo() {
        let val = $('#user_id_select').val();
        if (!val) {
            $('#existing-user-info').hide();
            $('#age_group_input').val('');
            return;
        }
        let selected = $('#user_id_select').find('option:selected');
        $('#existing-user-name').text(selected.data('name'));
        $('#existing-user-birthdate').text(selected.data('birthdate') || '-');
        $('#existing-user-gender').text(selected.data('gender') || '-');
        $('#existing-user-phone').text(selected.data('phone') || '-');
        $('#existing-user-alamat').text(selected.data('alamat') || '-');
        $('#existing-user-info').show();
        setAgeGroup(selected.data('birthdate'));
    }

    $('#user_id_select').on('change', showUserInfo);

    // On page load, show info for selected user
    showUserInfo();

    // Kelompok usia otomatis
    $('#birth_date_input').on('change', function() {
        setAgeGroup(this.value);
    });

    function setAgeGroup(birthDate) {
        let ageGroupInput = document.getElementById('age_group_input');
        if (!ageGroupInput) return;
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

    // Set kelompok usia saat load jika ada birth_date
    if ($('#birth_date_input').val()) {
        setAgeGroup($('#birth_date_input').val());
    }
});