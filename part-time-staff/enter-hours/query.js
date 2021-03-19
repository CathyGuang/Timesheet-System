
function submitted() {

    
    checkName();
    checkJobSelect();

    if(NameReady == false||Jobselected == false){
        console.log("innn");
        if(NameReady == false){

            alert("Please select or enter a name in the staff list");
            
        }
    
        if(Jobselected == false){
    
            alert("Please select at least one job to report");
        }

    }
    
    else{
        

        var totalminString =totalmin.toString();

        var confirmed = confirm('Are you sure you want to submit?');

        if (confirmed == true){

            document.getElementById('myform').submit(function(e){

               

                window.location.href = 'staff-record-hours.php'; 
            });


        
        }


    }

    
    
}


//detecting changes from name input

$("#selected-name").change(function() {
    checkName();
  });
