// document.addEventListener("DOMContentLoaded", function () {
//     // Select all checkboxes with the class 'selectgroup-input' and value '1' (Normal)
//     const normalCheckboxes = document.querySelectorAll(
//         'input.selectgroup-input[value="normal"]'
//     );

//     normalCheckboxes.forEach((normalCheckbox) => {
//         normalCheckbox.addEventListener("change", function () {
//             // Find the closest form-group ancestor
//             const formGroup = this.closest(".form-group");
//             if (formGroup) {
//                 // Select checkboxes with values 2 (OK), 4 (LOG), and 5 (Tidak Uji) within the same form-group
//                 const targetCheckboxes = formGroup.querySelectorAll(
//                     'input.selectgroup-input[value="ok"], input.selectgroup-input[value="log"], input.selectgroup-input[value="sld"]'
//                 );
//                 targetCheckboxes.forEach((checkbox) => {
//                     // Set the checked state of OK, LOG, and Tidak Uji to match the Normal checkbox
//                     checkbox.checked = this.checked;
//                 });
//             }
//         });
//     });

//     // Optional: Update Normal checkbox state if all OK, LOG, and Tidak Uji are checked
//     document.querySelectorAll(".form-group").forEach((formGroup) => {
//         const checkboxes = formGroup.querySelectorAll(
//             'input.selectgroup-input[value="ok"], input.selectgroup-input[value="log"], input.selectgroup-input[value="sld"]'
//         );
//         checkboxes.forEach((checkbox) => {
//             checkbox.addEventListener("change", function () {
//                 const normalCheckbox = formGroup.querySelector(
//                     'input.selectgroup-input[value="normal"]'
//                 );
//                 if (normalCheckbox) {
//                     normalCheckbox.checked = [...checkboxes].every(
//                         (cb) => cb.checked
//                     );
//                 }
//             });
//         });
//     });
// });

// Configuration for each form group
    const formGroups = [
        {
            checkAllId: "cb_open_checkAll",
            targetIds: ["cb_open_1", "cb_open_3", "cb_open_4"],
            name: "s_cb[]",
        },
        {
            checkAllId: "cb_close_checkAll",
            targetIds: ["cb_close_1", "cb_close_3", "cb_close_4"],
            name: "s_cb[]",
        },
        {
            checkAllId: "cb2_open_checkAll",
            targetIds: ["cb2_open_1", "cb2_open_3", "cb2_open_4"],
            name: "s_cb2[]",
        },
        {
            checkAllId: "cb2_close_checkAll",
            targetIds: ["cb2_close_1", "cb2_close_3", "cb2_close_4"],
            name: "s_cb2[]",
        },
        {
            checkAllId: "lr_checkAll",
            targetIds: ["lr_local_1", "lr_local_3", "lr_local_4"],
            name: "s_lr[]",
        },
        {
            checkAllId: "door_open_checkAll",
            targetIds: ["door_open_1", "door_open_3", "door_open_4"],
            name: "s_door[]",
        },
        {
            checkAllId: "door_close_checkAll",
            targetIds: ["door_close_1", "door_close_3", "door_close_4"],
            name: "s_door[]",
        },
        {
            checkAllId: "acf_normal_checkAll",
            targetIds: ["acf_acnrml_1", "acf_acnrml_3", "acf_acnrml_4"],
            name: "s_acf[]",
        },
        {
            checkAllId: "acf_failed_checkAll",
            targetIds: ["acf_failed_1", "acf_failed_3", "acf_failed_4"],
            name: "s_acf[]",
        },
        {
            checkAllId: "dcf_normal_checkAll",
            targetIds: ["dcf_dcfnrml_1", "dcf_dcfnrml_3", "dcf_dcfnrml_4"],
            name: "s_dcf[]",
        },
        {
            checkAllId: "dcf_failed_checkAll",
            targetIds: ["dcf_dcffail_1", "dcf_dcffail_3", "dcf_dcffail_4"],
            name: "s_dcf[]",
        },
        {
            checkAllId: "dcd_normal_checkAll",
            targetIds: ["dcd_dcnrml_1", "dcd_dcnrml_3", "dcd_dcnrml_4"],
            name: "s_dcd[]",
        },
        {
            checkAllId: "dcd_failed_checkAll",
            targetIds: ["dcd_dcfail_1", "dcd_dcfail_3", "dcd_dcfail_4"],
            name: "s_dcd[]",
        },
        {
            checkAllId: "hlt_off_checkAll",
            targetIds: ["hlt_hltoff_1", "hlt_hltoff_3", "hlt_hltoff_4"],
            name: "s_hlt[]",
        },
        {
            checkAllId: "hlt_on_checkAll",
            targetIds: ["hlt_hlton_1", "hlt_hlton_3", "hlt_hlton_4"],
            name: "s_hlt[]",
        },
        {
            checkAllId: "sf6_checkAll",
            targetIds: ["sf6_sf6nrml_1", "sf6_sf6nrml_3", "sf6_sf6nrml_4"],
            name: "s_sf6[]",
        },
        {
            checkAllId: "fir_checkAll",
            targetIds: ["fir_firnrml_1", "fir_firnrml_3", "fir_firnrml_4"],
            name: "s_fir[]",
        },
        {
            checkAllId: "fis_checkAll",
            targetIds: ["fis_fisnrml_1", "fis_fisnrml_3", "fis_fisnrml_4"],
            name: "s_fis[]",
        },
        {
            checkAllId: "fit_checkAll",
            targetIds: ["fit_fitnrml_1", "fit_fitnrml_3", "fit_fitnrml_4"],
            name: "s_fit[]",
        },
        {
            checkAllId: "fin_checkAll",
            targetIds: ["fin_finnrml_1", "fin_finnrml_3", "fin_finnrml_4"],
            name: "s_fin[]",
        },
    ];

    // Apply logic to each form group
    formGroups.forEach(group => {
        // Handle "Normal" checkbox click
        const checkAll = document.getElementById(group.checkAllId);
        if (checkAll) {
            checkAll.addEventListener('change', function() {
                const checkboxes = group.targetIds.map(id => document.getElementById(id));
                checkboxes.forEach(checkbox => {
                    if (checkbox) {
                        checkbox.checked = this.checked;
                    }
                });
            });
        }

        // Handle target checkboxes (OK, LOG, SLD) click
        const targetCheckboxes = group.targetIds.map(id => document.getElementById(id));
        targetCheckboxes.forEach(checkbox => {
            if (checkbox) {
                checkbox.addEventListener('change', function() {
                    const allChecked = targetCheckboxes.every(cb => cb && cb.checked);
                    if (checkAll) {
                        checkAll.checked = allChecked;
                    }
                });
            }
        });
    });
