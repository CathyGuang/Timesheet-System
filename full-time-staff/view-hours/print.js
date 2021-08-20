

function change(){

    var confirmed = confirm('Are you sure you want to change this data?');

    if (confirmed == true){

        document.getElementById('myform').submit(function(e){    

            window.location.href = 'change_data.php'; 
        });

    
    }



}

// localStorage.setItem('startDate', SelectedStamp);

