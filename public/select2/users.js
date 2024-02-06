initCompanySelect();

function initCompanySelect() {
    var optionselect = {
        placeholder: "Select Users",
        // minimumInputLength: 1,
        allowClear: true,
        ajax: {
            url: base_url + "/asset/option/client",
            dataType: "json",
            delay: 250,
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': token,
            },
            data: function (params) {
                return {
                    search: params.term,
                };
            },
            processResults: function (data) {
                var select2Data = $.map(data, function (obj) {
                    obj.id = obj.id;
                    obj.text = `${obj.user_full_name}`;
                    return obj;
                });
                return {
                    results: select2Data,
                };
            },
            cache: true,
        },
    };

    $("#user_id").select2(optionselect);
    $(".user_id").select2(optionselect);

}
