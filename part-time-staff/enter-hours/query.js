//variable that checks if name entry is ready 
var NameReady = true;
var JobReady = true;

//checks if name is correctly in list
function checkJob(){


    var jobList = [];
    
    var optional = document.getElementById("work-type-list").options
    for(var i=0;i<optional.length;i++){

        jobList[i] = optional[i].value;


    }
    

    var jobEntry =  document.getElementById("selected-job");

    if(nameEntry.value ==""){

        var name_element = document.getElementById("work_select_reminder");
        name_element.innerHTML = "Please select your work!";
        name_element.scrollIntoView(false);
        jobEntry.style="box-shadow: inset 0px 0px 3px #EA7186;"
        JobReady = false;
        

    }

    else if(!nameList.includes(nameEntry.value)){

        var name_element = document.getElementById("work_select_reminder");
        name_element.innerHTML = "Please enter/select a work exactly as in list";
        name_element.scrollIntoView(false);
        nameEntry.style="box-shadow: inset 0px 0px 3px #EA7186;"
        JobReady = false;

    }

    else{

        var name_element = document.getElementById("work_select_reminder");
        name_element.innerHTML = "";
        nameEntry.style="box-shadow: inset 0px 0px 3px #d6dce7;"
        JobReady = true;


    }


}


//checks if name is correctly in list
function checkName(){


    var nameList = [];
    
    var optional = document.getElementById("staff-list").options
    for(var i=0;i<optional.length;i++){

        nameList[i] = optional[i].value;


    }
    

    var nameEntry =  document.getElementById("selected-name");

    if(nameEntry.value ==""){

        var name_element = document.getElementById("name_select_reminder");
        name_element.innerHTML = "Please select your name!";
        name_element.scrollIntoView(false);
        nameEntry.style="box-shadow: inset 0px 0px 3px #EA7186;"
        NameReady = false;
        

    }

    else if(!nameList.includes(nameEntry.value)){

        var name_element = document.getElementById("name_select_reminder");
        name_element.innerHTML = "Please enter/select a name exactly as in list";
        name_element.scrollIntoView(false);
        nameEntry.style="box-shadow: inset 0px 0px 3px #EA7186;"
        NameReady = false;

    }

    else{

        var name_element = document.getElementById("name_select_reminder");
        name_element.innerHTML = "";
        nameEntry.style="box-shadow: inset 0px 0px 0px #d6dce7;"
        NameReady = true;


    }






}



function submitted() {

    
    checkName();
    checkJob();
    //checkJobSelect();

    if(NameReady == false||JobReady == false){
        console.log("innn");
        if(NameReady == false){

            alert("Please select or enter a name in the staff list");
            
        }
    
        if(JobReady == false){
    
            alert("Please select a correct job to report");
        }

    }
    
    else{

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

$("#selected-job").change(function() {
    checkJob();
});