$(function(){
   
    $(document).on('change', '#ajax-asigned-dropdown, #ajax-status-dropdown', function(e){
        
        e.preventDefault();

        const status = $('#ajax-status-dropdown').val();
        const asigned = $('#ajax-asigned-dropdown').val();
        const form = $('#task-ajax-form');
        const id = $('#task-id').val();

       $.LoadingOverlay('show');

        $.ajax({
            type: 'POST',
            url: form.attr('action'),
            data:{
                status: status,
                asigned: asigned,
                id: id,
            },
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Mentve!',
                        text: response.msg,
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true
                    });
                    
                    $('#taskModal').modal('hide');

                    if (window.mainCalendar) {
                        window.mainCalendar.refetchEvents();
                    }
                } else {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Hiba!',
                        text: response.msg
                    });
                }
            },
            error: function(xhr, status, error) {
                let errorMessage = "Ismeretlen hiba történt a mentés során.";
                
                if (xhr.status === 403) {
                    errorMessage = "Nincs jogosultságod a művelethez!";
                } else if (xhr.status === 404) {
                    errorMessage = "Az erőforrás nem található.";
                } else if (xhr.status >= 500) {
                    errorMessage = "Szerver hiba történt, próbáld újra később.";
                }

                console.error("AJAX Error:", error, xhr.responseText);
                Swal.fire({
                    icon: 'error',
                    title: 'Hoppá...',
                    text: errorMessage,
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'Értem'
                });
            },
            complete: function() {
                $.LoadingOverlay('hide');
            }
        });

        return false;

    });

});