

function change(obj){

    var valued = obj.value;

    var confirmed = confirm('Are you sure you want to change this data?'+valued);

    if (confirmed == true){

         window.location.href = 'change_data.php';
         localStorage.setItem('Change_Value', valued);

    }

}

// today's date

var today = new Date();
var dd = String(today.getDate()).padStart(2, '0');
var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
var yyyy = today.getFullYear();

today = mm + '/' + dd + '/' + yyyy;


var myTab = document.getElementById('HoursTable');

function genPDF(){

    var doc = new jsPDF();

    doc.setFontSize(16);
    doc.text(someone+"'s Total Hours "+hours,20,20);

    doc.setFontSize(12);
    doc.text("File created on "+today,20,30);

    var amount = 20;
    var column = 20;

    doc.setFontSize(10);


    for (let i in myTab.rows) {
        let row = myTab.rows[i]

        if(i != 0){
            //iterate through rows
            //rows would be accessed using the "row" variable assigned in the for loop
            for (let j in row.cells) {
                let col = row.cells[j]
                //   console.log(col);
                if (j == 0){
                doc.setFontSize(14);
                console.log("COL:");
                console.log(col.textContent);
                doc.setFontType('bold');
                doc.text(col.textContent+": ",column,30+amount); 
                amount = amount + 5;
                }
                if (j==2){
                    doc.setFontSize(12);
                    console.log("COL:");
                    console.log(col.textContent);
                    doc.setFontType("normal");
                    doc.text("hours: "+col.textContent,column,30+amount); 
                    amount = amount + 5;
                }
                if (j==3){
                    doc.setFontSize(12);
                    console.log("COL:");
                    console.log(col.textContent);
                    doc.setFontType("normal");
                    doc.text("total hours: "+col.textContent,column,30+amount); 
                    amount = amount + 5;
                }
                if(j==1){
                doc.setFontSize(12);
                console.log("EEEE:");
                console.log(col.children[0].value);
                doc.setFontType("normal");
                doc.text(col.children[0].value,column,30+amount); 
                amount = amount + 5;
    
                }
                if(amount>200){
                    amount = 10;
                    doc.addPage();
                }
                else{
                amount = amount + 1;
                }

            }
        
        }  
    };
    doc.save(someone+" "+today+" hours.pdf");


};


var inOutTab = document.getElementById('InOutTable');

function genPDFin(){

    var doc = new jsPDF();

    doc.setFontSize(16);
    doc.text(someone+"'s Total Hours "+hours,20,20);

    doc.setFontSize(12);
    doc.text("File created on "+today,20,30);

    var amount = 20;
    var column = 20;

    doc.setFontSize(10);

    for (let i in inOutTab.rows) {
        let row = inOutTab.rows[i]

        if(i != 0){
            //iterate through rows
            //rows would be accessed using the "row" variable assigned in the for loop
            for (let j in row.cells) {
                let col = row.cells[j]
                //   console.log(col);
                if (j == 0){
                doc.setFontSize(14);
                console.log("COL:");
                console.log(col.textContent);
                doc.setFontType('bold');
                doc.text(col.textContent+": ",column,30+amount); 
                amount = amount + 5;
                }
                if (j==1){
                    doc.setFontSize(12);
                    console.log("COL:");
                    console.log(col.textContent);
                    doc.setFontType("normal");
                    doc.text("in-time: "+col.textContent,column,30+amount); 
                    amount = amount + 5;
                }
                if (j==2){
                    doc.setFontSize(12);
                    console.log("COL:");
                    console.log(col.textContent);
                    doc.setFontType("normal");
                    doc.text("out-time: "+col.textContent,column,30+amount); 
                    amount = amount + 5;
                }
                if(amount>200){
                    amount = 10;
                    doc.addPage();
                }
                else{
                amount = amount + 1;
                }

            }
        
        }  
    };
    doc.save(someone+" "+today+" hours.pdf");


};




