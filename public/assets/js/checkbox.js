document.addEventListener("DOMContentLoaded", function () {
    // Select all checkboxes with the class 'selectgroup-input' and value '1' (Normal)
    const normalCheckboxes = document.querySelectorAll(
        'input.selectgroup-input[value="1"]'
    );

    normalCheckboxes.forEach((normalCheckbox) => {
        normalCheckbox.addEventListener("change", function () {
            // Find the closest form-group ancestor
            const formGroup = this.closest(".form-group");
            if (formGroup) {
                // Select checkboxes with values 2 (OK), 4 (LOG), and 5 (Tidak Uji) within the same form-group
                const targetCheckboxes = formGroup.querySelectorAll(
                    'input.selectgroup-input[value="2"], input.selectgroup-input[value="4"], input.selectgroup-input[value="5"]'
                );
                targetCheckboxes.forEach((checkbox) => {
                    // Set the checked state of OK, LOG, and Tidak Uji to match the Normal checkbox
                    checkbox.checked = this.checked;
                });
            }
        });
    });

    // Optional: Update Normal checkbox state if all OK, LOG, and Tidak Uji are checked
    document.querySelectorAll(".form-group").forEach((formGroup) => {
        const checkboxes = formGroup.querySelectorAll(
            'input.selectgroup-input[value="2"], input.selectgroup-input[value="4"], input.selectgroup-input[value="5"]'
        );
        checkboxes.forEach((checkbox) => {
            checkbox.addEventListener("change", function () {
                const normalCheckbox = formGroup.querySelector(
                    'input.selectgroup-input[value="1"]'
                );
                if (normalCheckbox) {
                    normalCheckbox.checked = [...checkboxes].every(
                        (cb) => cb.checked
                    );
                }
            });
        });
    });
});
