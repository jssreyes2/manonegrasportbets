<script type="application/javascript">
    $("body").on('blur', '.get_patient', function () {
        if (!$('.get_patient').val()) {
            return false;
        }
        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type: "POST",
            url: "{{ route('patient.getpatient') }}",
            cache: false,
            dataType: 'json',
            data: {identification_card: $('#identification_card').val()},
            success: function (response) {

                if (response.status == 'success') {

                    $('#patient_name').val(response.patient.patient_name);
                    $('#phone').val(response.patient.phone);
                    $('#phone_home').val(response.patient.phone_home);
                    $('#direction').val(response.patient.direction);
                    $('#patient_id').val(response.patient.id);

                } else {
                    $('#patient_name, #phone, #phone_home, #direction, #patient_id').val('');
                }
            }
        });
    });
</script>
