//variable for checking form validity

var HoursReady = true;

var HoursEntry =  document.getElementById("quantity");


if(HoursEntry.value ==""){
    HoursReady = false;

}

else if((HoursEntry*100)%25 != 0){
    HoursReady = false;
}


function checkTimeAligned(){

    HoursEntry =  document.getElementById("quantity");

    if((HoursEntry*100)%25 == 0){
        HoursReady = true;
    }

}

//canceled function:

function canceled(){

    var confirmed = confirm('Are you sure you want to cancel? Your input would not be saved');

        if (confirmed == true){

            window.location.href = '/full-time-staff/index.php';
        }


}

//submitted function:
function submitted() {

    checkTimeAligned();

    if(HoursReady == false){

        alert("Please enter a valid hour with 15 minute (.25) interval");
        
    }
    else{
        var confirmed = confirm('Are you sure you want to submit?');

        if (confirmed == true){

            document.getElementById('myform').submit(function(e){    

                window.location.href = 'enter-pto.php'; 
            });

        
        }

    }


}
