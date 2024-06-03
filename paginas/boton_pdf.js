
document.addEventListener('DOMContentLoaded', function() {
    const checkboxes = document.querySelectorAll('.empleado-checkbox');
    const exportButton = document.getElementById('export_pdf_button');

    function toggleExportButton() {
        const anyChecked = Array.from(checkboxes).some(checkbox => checkbox.checked);
        exportButton.disabled = !anyChecked;
    }

    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', toggleExportButton);
    });

    // Initialize button state
    
    toggleExportButton();
});
