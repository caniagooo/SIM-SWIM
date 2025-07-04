document.addEventListener('DOMContentLoaded', function () {
    // Select2 for private student dropdown
    $('#student-private-dropdown').select2({
        placeholder: '-- Select Student --',
        allowClear: true,
        width: '100%'
    });

    // Card selection logic
    const typeInput = document.getElementById('type');
    const cards = document.querySelectorAll('.course-type-card');
    function selectCard(selectedType) {
        cards.forEach(card => {
            if (card.dataset.type === selectedType) {
                card.classList.add('selected', 'border-primary');
                card.classList.remove('border-secondary');
            } else {
                card.classList.remove('selected', 'border-primary');
                card.classList.add('border-secondary');
            }
        });
        typeInput.value = selectedType;
        // Show/hide student selection
        if (selectedType === 'private') {
            document.getElementById('students-dropdown-section').style.display = '';
            document.getElementById('students-table-section').style.display = 'none';
            document.getElementById('student-private-dropdown').disabled = false;
            document.querySelectorAll('.student-checkbox').forEach(cb => cb.disabled = true);
        } else {
            document.getElementById('students-dropdown-section').style.display = 'none';
            document.getElementById('students-table-section').style.display = '';
            document.getElementById('student-private-dropdown').disabled = true;
            document.querySelectorAll('.student-checkbox').forEach(cb => cb.disabled = false);
        }
    }
    cards.forEach(card => {
        card.addEventListener('click', function () {
            selectCard(card.dataset.type);
            // Update checkboxes
            document.getElementById('type-private-checkbox').checked = card.dataset.type === 'private';
            document.getElementById('type-group-checkbox').checked = card.dataset.type === 'group';
        });
    });
    // Initial state
    selectCard(typeInput.value);

    // Student search for group
    const searchInput = document.getElementById('student-search');
    if (searchInput) {
        searchInput.addEventListener('input', function () {
            const filter = searchInput.value.toLowerCase();
            document.querySelectorAll('#students-table-body tr').forEach(row => {
                const name = row.children[1].textContent.toLowerCase();
                const email = row.children[2].textContent.toLowerCase();
                row.style.display = (name.includes(filter) || email.includes(filter)) ? '' : 'none';
            });
        });
    }
    // Select all checkbox
    const selectAll = document.getElementById('select-all-students');
    if (selectAll) {
        selectAll.addEventListener('change', function () {
            document.querySelectorAll('.student-checkbox').forEach(cb => {
                cb.checked = selectAll.checked;
            });
        });
    }

    // Stepper logic
    const tabs = ['step1', 'step2', 'step3'];
    let currentTab = 0;
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    const submitBtn = document.getElementById('submitBtn');
    function showTab(index) {
        tabs.forEach((tab, i) => {
            const tabPane = document.getElementById(tab);
            const tabBtn = document.getElementById(tab + '-tab');
            if (i === index) {
                tabPane.classList.add('show', 'active');
                tabBtn.classList.add('active');
                tabBtn.setAttribute('aria-selected', 'true');
            } else {
                tabPane.classList.remove('show', 'active');
                tabBtn.classList.remove('active');
                tabBtn.setAttribute('aria-selected', 'false');
            }
        });
        prevBtn.style.display = index === 0 ? 'none' : '';
        nextBtn.style.display = index === tabs.length - 1 ? 'none' : '';
        submitBtn.style.display = index === tabs.length - 1 ? '' : 'none';
    }
    prevBtn.addEventListener('click', function () {
        if (currentTab > 0) {
            currentTab--;
            showTab(currentTab);
        }
    });
    nextBtn.addEventListener('click', function () {
        if (currentTab < tabs.length - 1) {
            currentTab++;
            showTab(currentTab);
        }
    });
    tabs.forEach((tab, i) => {
        document.getElementById(tab + '-tab').addEventListener('click', function () {
            currentTab = i;
            showTab(currentTab);
        });
    });
    showTab(currentTab);

    // Expiration date auto-calc
    function updateExpiration() {
        const startDate = document.getElementById('start_date').value;
        const duration = parseInt(document.getElementById('duration_days').value, 10);
        const validUntil = document.getElementById('valid_until');
        if (startDate && duration && duration > 0) {
            const date = new Date(startDate);
            date.setDate(date.getDate() + duration - 1);
            const yyyy = date.getFullYear();
            const mm = String(date.getMonth() + 1).padStart(2, '0');
            const dd = String(date.getDate()).padStart(2, '0');
            validUntil.value = `${yyyy}-${mm}-${dd}`;
        } else {
            validUntil.value = '';
        }
    }
    document.getElementById('start_date').addEventListener('change', updateExpiration);
    document.getElementById('duration_days').addEventListener('input', updateExpiration);
    updateExpiration();

    // Material summary
    function updateMaterialSummary() {
        let checked = document.querySelectorAll('.material-checkbox:checked');
        let total = checked.length;
        let totalSessions = 0;
        let totalMinScore = 0;
        checked.forEach(function (el) {
            totalSessions += parseInt(el.dataset.estimatedSessions) || 0;
            totalMinScore += parseFloat(el.dataset.minScore) || 0;
        });
        let avgMinScore = total > 0 ? (totalMinScore / total).toFixed(1) : 0;
        document.getElementById('selected-materials-count').textContent = total;
        document.getElementById('selected-materials-sessions').textContent = totalSessions;
        document.getElementById('selected-materials-minscore').textContent = avgMinScore;
    }
    document.querySelectorAll('.material-checkbox').forEach(function (el) {
        el.addEventListener('change', updateMaterialSummary);
    });
    updateMaterialSummary();
});