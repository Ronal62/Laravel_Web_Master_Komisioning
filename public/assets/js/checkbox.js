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
        checkAllId: "lr_local_checkAll",
        targetIds: ["lr_local_1", "lr_local_3", "lr_local_4"],
        name: "s_lr[]",
    },
    {
        checkAllId: "lr_remote_checkAll",
        targetIds: ["lr_remote_1", "lr_remote_3", "lr_remote_4"],
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
        checkAllId: "sf6_normal_checkAll",
        targetIds: ["sf6_sf6nrml_1", "sf6_sf6nrml_3", "sf6_sf6nrml_4"],
        name: "s_sf6[]",
    },
    {
        checkAllId: "sf6_failed_checkAll",
        targetIds: ["sf6_sf6fail_1", "sf6_sf6fail_3", "sf6_sf6fail_4"],
        name: "s_sf6[]",
    },
    {
        checkAllId: "fir_normal_checkAll",
        targetIds: ["fir_firnrml_1", "fir_firnrml_3", "fir_firnrml_4"],
        name: "s_fir[]",
    },
    {
        checkAllId: "fir_failed_checkAll",
        targetIds: ["fir_firfail_1", "fir_firfail_3", "fir_firfail_4"],
        name: "s_fir[]",
    },
    {
        checkAllId: "fis_normal_checkAll",
        targetIds: ["fis_fisnrml_1", "fis_fisnrml_3", "fis_fisnrml_4"],
        name: "s_fis[]",
    },
    {
        checkAllId: "fis_failed_checkAll",
        targetIds: ["fis_fisfail_1", "fis_fisfail_3", "fis_fisfail_4"],
        name: "s_fis[]",
    },
    {
        checkAllId: "fit_normal_checkAll",
        targetIds: ["fit_fitnrml_1", "fit_fitnrml_3", "fit_fitnrml_4"],
        name: "s_fit[]",
    },
    {
        checkAllId: "fit_failed_checkAll",
        targetIds: ["fit_fitfail_1", "fit_fitfail_3", "fit_fitfail_4"],
        name: "s_fit[]",
    },
    {
        checkAllId: "fin_normal_checkAll",
        targetIds: ["fin_finnrml_1", "fin_finnrml_3", "fin_finnrml_4"],
        name: "s_fin[]",
    },
    {
        checkAllId: "fin_failed_checkAll",
        targetIds: ["fin_finfail_1", "fin_finfail_3", "fin_finfail_4"],
        name: "s_fin[]",
    },
    {
        checkAllId: "ccb_open_checkAll_ok",
        targetIds: ["ccb_open_1", "ccb_open_3", "ccb_open_4"],
        name: "c_cb[]",
    },
    {
        checkAllId: "ccb_close_checkAll_ok",
        targetIds: ["ccb_close_1", "ccb_close_3", "ccb_close_4"],
        name: "c_cb[]",
    },
    {
        checkAllId: "ccb2_open_checkAll_ok",
        targetIds: ["ccb2_open_1", "ccb2_open_3", "ccb2_open_4"],
        name: "c_cb2[]",
    },
    {
        checkAllId: "ccb2_close_checkAll_ok",
        targetIds: ["ccb2_close_1", "ccb2_close_3", "ccb2_close_4"],
        name: "c_cb2[]",
    },
    {
        checkAllId: "chlt_off_checkAll_ok",
        targetIds: ["chlt_off_1", "chlt_off_3", "chlt_off_4"],
        name: "c_hlt[]",
    },
    {
        checkAllId: "chlt_on_checkAll_ok",
        targetIds: ["chlt_on_1", "chlt_on_3", "chlt_on_4"],
        name: "c_hlt[]",
    },
    {
        checkAllId: "crst_on_checkAll_ok",
        targetIds: ["crst_on_1", "crst_on_3", "crst_on_4"],
        name: "c_rst[]",
    },
    {
        checkAllId: "s_ocr_dis_checkAll",
        targetIds: ["s_ocrd_1", "s_ocrd_3", "s_ocrd_4"],
        name: "s_ocr[]",
    },
    {
        checkAllId: "s_ocr_app_checkAll",
        targetIds: ["s_ocra_1", "s_ocra_3", "s_ocra_4"],
        name: "s_ocr[]",
    },
    {
        checkAllId: "s_ocri_dis_checkAll",
        targetIds: ["s_ocrid_1", "s_ocrid_3", "s_ocrid_4"],
        name: "s_ocri[]",
    },
    {
        checkAllId: "s_ocri_app_checkAll",
        targetIds: ["s_ocria_1", "s_ocria_3", "s_ocria_4"],
        name: "s_ocri[]",
    },
    {
        checkAllId: "s_dgr_dis_checkAll",
        targetIds: ["s_dgrd_1", "s_dgrd_2", "s_dgrd_4"],
        name: "s_dgr[]",
    },
    {
        checkAllId: "s_dgr_app_checkAll",
        targetIds: ["s_dgra_1", "s_dgra_2", "s_dgra_4"],
        name: "s_dgr[]",
    },
    {
        checkAllId: "s_cbtr_dis_checkAll",
        targetIds: ["s_cbtrd_1", "s_cbtrd_2", "s_cbtrd_4"],
        name: "s_cbtr[]",
    },
    {
        checkAllId: "s_cbtr_app_checkAll",
        targetIds: ["s_cbtra_1", "s_cbtra_2", "s_cbtra_4"],
        name: "s_cbtr[]",
    },
    {
        checkAllId: "s_ar_dis_checkAll",
        targetIds: ["s_ard_1", "s_ard_2", "s_ard_4"],
        name: "s_ar[]",
    },
    {
        checkAllId: "s_ar_app_checkAll",
        targetIds: ["s_ara_1", "s_ara_2", "s_ara_4"],
        name: "s_ar[]",
    },
    {
        checkAllId: "s_aru_dis_checkAll",
        targetIds: ["s_arud_1", "s_arud_2", "s_arud_4"],
        name: "s_aru[]",
    },
    {
        checkAllId: "s_aru_app_checkAll",
        targetIds: ["s_arua_1", "s_arua_2", "s_arua_4"],
        name: "s_aru[]",
    },
    {
        checkAllId: "s_tc_dis_checkAll",
        targetIds: ["s_tcd_1", "s_tcd_2", "s_tcd_4"],
        name: "s_tc[]",
    },
    {
        checkAllId: "s_tc_app_checkAll",
        targetIds: ["s_tca_1", "s_tca_2", "s_tca_4"],
        name: "s_tc[]",
    },
    {
        checkAllId: "c_aru_use_checkAll",
        targetIds: ["c_aruu_1", "c_aruu_2", "c_aruu_4"],
        name: "c_aru[]",
        c_aru_use: "no",
        c_aru: "yes",
    },
    {
        checkAllId: "c_aru_unuse_checkAll",
        targetIds: ["c_aruun_1", "c_aruun_2", "c_aruun_4"],
        name: "c_aru[]",
        c_aru_unuse: "no",
        c_aru: "yes",
    },
    {
        checkAllId: "c_reset_on_checkAll",
        targetIds: ["c_rrctrl_on_1", "c_rrctrl_on_2", "c_rrctrl_on_4"],
        name: "c_reset_on[]",
    },
    {
        checkAllId: "c_tc_raiser_checkAll",
        targetIds: ["c_tcrai_1", "c_tcrai_2", "c_tcrai_4"],
        name: "c_tc_raiser[]",
    },
    {
        checkAllId: "c_tc_lower_checkAll",
        targetIds: ["c_tclow_1", "c_tclow_2", "c_tclow_4"],
        name: "c_tc_lower[]",
    },
];

// Apply logic to each form group
formGroups.forEach((group) => {
    // Handle "Normal" checkbox click
    const checkAll = document.getElementById(group.checkAllId);
    if (checkAll) {
        checkAll.addEventListener("change", function () {
            const checkboxes = group.targetIds.map((id) =>
                document.getElementById(id)
            );
            checkboxes.forEach((checkbox) => {
                if (checkbox) {
                    checkbox.checked = this.checked;
                }
            });
        });
    }

    // Handle target checkboxes (OK, LOG, SLD) click
    const targetCheckboxes = group.targetIds.map((id) =>
        document.getElementById(id)
    );
    targetCheckboxes.forEach((checkbox) => {
        if (checkbox) {
            checkbox.addEventListener("change", function () {
                const allChecked = targetCheckboxes.every(
                    (cb) => cb && cb.checked
                );
                if (checkAll) {
                    checkAll.checked = allChecked;
                }
            });
        }
    });
});

// Multi-select dropdown logic
