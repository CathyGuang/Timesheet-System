//canceled function:

function canceled(){

    var confirmed = confirm('Are you sure you want to cancel? Your input would not be saved');

        if (confirmed == true){

            window.location.href = '/full-time-staff/index.php';
        }


}

//submitted function:
function submitted() {

    var confirmed = confirm('Are you sure you want to submit?');

        if (confirmed == true){

            document.getElementById('myform').submit(function(e){    

                window.location.href = 'enter-pto.php'; 
            });

    

        
        }

}
