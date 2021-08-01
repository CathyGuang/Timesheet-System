//variable for checking form validity

var HoursReady;
var HoursEntry;

function checkTimeCorrect(){

    HoursEntry =  document.getElementById("quantity");

    if(HoursEntry.value ==""){
        HoursReady = false;
        console.log("None");
    
    }
    else if((HoursEntry*100)%25 != 0){
        HoursReady = false;
        console.log("Math_Incoorect");
        console.log(HoursEntry);
    }
    else{
        HoursReady = true;
        console.log("okay");
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

    checkTimeCorrect();

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
