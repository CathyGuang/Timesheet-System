var worktime1=0;
var worktime2=0;
var worktime3=0;
var worktime4=0;
var worktime5=0;
var worktime6=0;
var worktime7=0;
var worktime8=0;
var worktime9=0;
var worktime10=0;
var worktime11=0;
var worktime12=0;

var worktotal1="";
var worktotal2="";
var worktotal3="";
var worktotal4="";
var worktotal5="";
var worktotal6="";


$("#slider-range").slider({
    range: true,
    min: 0,
    max: 960,
    step: 15,
    values: [450, 500],
    slide: function (e, ui) {
        var hours1 = Math.floor(ui.values[0] / 60);
        var minutes1 = ui.values[0] - (hours1 * 60);
        worktime1=ui.values[0];
        worktime2=ui.values[1];



        if (hours1.length == 1) hours1 = '0' + hours1;
        if (minutes1.length == 1) minutes1 = '0' + minutes1;
        if (minutes1 == 0) minutes1 = '00';
        if (hours1 >= 6) {
            if (hours1 == 6) {
                hours1 = 12;
                minutes1 = minutes1 + " PM";
            } else {
                hours1 = hours1+6 - 12;
                minutes1 = minutes1 + " PM";
            }
        } else {
            hours1 = hours1+6;
            minutes1 = minutes1 + " AM";
        }
        if (hours1 == 0) {
            hours1 = 6;
            minutes1 = minutes1+"AM";
        }



        $('.slider-time').html(hours1 + ':' + minutes1 + ' - ');
        
        
        var hours2 = Math.floor(ui.values[1] / 60);
        var minutes2 = ui.values[1] - (hours2 * 60);


        if (hours2.length == 1) hours2 = '0' + hours2;
        if (minutes2.length == 1) minutes2 = '0' + minutes2;
        if (minutes2 == 0) minutes2 = '00';
        if (hours2 >= 6) {
            if (hours2 == 6) {
                hours2 = hours2+6;
                minutes2 = minutes2 + " PM";
            } else if (hours2 == 16) {
                hours2 = 10;
                minutes2 = "00 PM";
            } else {
                hours2 = hours2+6 - 12;
                minutes2 = minutes2 + " PM";
            }
        } else {
            hours2 = hours2+6;
            minutes2 = minutes2 + " AM";
        }

        $('.slider-time2').html(hours2 + ':' + minutes2);

        var timed1 = hours1 + ':' + minutes1;
        var timed2 = hours2 + ':' + minutes2;


        if(timed1==timed2){

            $('.slider-time2').html('N/A');
            $('.slider-time').html('');
        }

    },
    stop:function(e,ui){
        worktime_reminder();  
    }
});

$("#slider-range1").slider({
    range: true,
    min: 0,
    max: 960,
    step: 15,
    values: [450, 500],
    slide: function (e, ui) {
        var hours1 = Math.floor(ui.values[0] / 60);
        var minutes1 = ui.values[0] - (hours1 * 60);
        worktime3=ui.values[0];
        worktime4=ui.values[1];

       
        if (hours1.length == 1) hours1 = '0' + hours1;
        if (minutes1.length == 1) minutes1 = '0' + minutes1;
        if (minutes1 == 0) minutes1 = '00';
        if (hours1 >= 6) {
            if (hours1 == 6) {
                hours1 = hours1+6;
                minutes1 = minutes1 + " PM";
            } else {
                hours1 = hours1+6 - 12;
                minutes1 = minutes1 + " PM";
            }
        } else {
            hours1 = hours1+6;
            minutes1 = minutes1 + " AM";
        }
        if (hours1 == 0) {
            hours1 = 6;
            minutes1 = minutes1 + "AM";
        }



        $('.slider-time1').html(hours1 + ':' + minutes1 + ' - ');

        var hours2 = Math.floor(ui.values[1] / 60);
        var minutes2 = ui.values[1] - (hours2 * 60);


        if (hours2.length == 1) hours2 = '0' + hours2;
        if (minutes2.length == 1) minutes2 = '0' + minutes2;
        if (minutes2 == 0) minutes2 = '00';
        if (hours2 >= 6) {
            if (hours2 == 6) {
                hours2 = hours2+6;
                minutes2 = minutes2 + " PM";
            } else if (hours2 == 16) {
                hours2 = 10;
                minutes2 = "00 PM";
            } else {
                hours2 = hours2 +6 - 12;
                minutes2 = minutes2 + " PM";
            }
        } else {
            hours2 = hours2+6;
            minutes2 = minutes2 + " AM";
        }

        $('.slider-time3').html(hours2 + ':' + minutes2);

        var timed1 = hours1 + ':' + minutes1;
        var timed2 = hours2 + ':' + minutes2;

        if(timed1==timed2){

            $('.slider-time1').html('N/A');
            $('.slider-time3').html('');
        }
 
    },
    stop:function(e,ui){
        worktime_reminder();    
    }
});

// second row of rangesliders
$("#slider-range2").slider({
    range: true,
    min: 0,
    max: 960,
    step: 15,
    values: [450, 500],
    slide: function (e, ui) {
        var hours1 = Math.floor(ui.values[0] / 60);
        var minutes1 = ui.values[0] - (hours1 * 60);
        worktime5=ui.values[0];
        worktime6=ui.values[1];


        if (hours1.length == 1) hours1 = '0' + hours1;
        if (minutes1.length == 1) minutes1 = '0' + minutes1;
        if (minutes1 == 0) minutes1 = '00';
        if (hours1 >= 6) {
            if (hours1 == 6) {
                hours1 = 12;
                minutes1 = minutes1 + " PM";
            } else {
                hours1 = hours1+6 - 12;
                minutes1 = minutes1 + " PM";
            }
        } else {
            hours1 = hours1+6;
            minutes1 = minutes1 + " AM";
        }
        if (hours1 == 0) {
            hours1 = 6;
            minutes1 = minutes1+"AM";
        }



        $('.slider-time4').html(hours1 + ':' + minutes1 + ' - ');
        
        
        var hours2 = Math.floor(ui.values[1] / 60);
        var minutes2 = ui.values[1] - (hours2 * 60);


        if (hours2.length == 1) hours2 = '0' + hours2;
        if (minutes2.length == 1) minutes2 = '0' + minutes2;
        if (minutes2 == 0) minutes2 = '00';
        if (hours2 >= 6) {
            if (hours2 == 6) {
                hours2 = hours2+6;
                minutes2 = minutes2 + " PM";
            } else if (hours2 == 16) {
                hours2 = 10;
                minutes2 = "00 PM";
            } else {
                hours2 = hours2+6 - 12;
                minutes2 = minutes2 + " PM";
            }
        } else {
            hours2 = hours2+6;
            minutes2 = minutes2 + " AM";
        }

        $('.slider-time5').html(hours2 + ':' + minutes2);

        var timed1 = hours1 + ':' + minutes1;
        var timed2 = hours2 + ':' + minutes2;


    


        if(timed1==timed2){

            $('.slider-time5').html('N/A');
            $('.slider-time4').html('');
        }

    },
    stop:function(e,ui){
        worktime_reminder();  
    }
});

$("#slider-range3").slider({
    range: true,
    min: 0,
    max: 960,
    step: 15,
    values: [450, 500],
    slide: function (e, ui) {
        var hours1 = Math.floor(ui.values[0] / 60);
        var minutes1 = ui.values[0] - (hours1 * 60);
        worktime7=ui.values[0];
        worktime8=ui.values[1];



        if (hours1.length == 1) hours1 = '0' + hours1;
        if (minutes1.length == 1) minutes1 = '0' + minutes1;
        if (minutes1 == 0) minutes1 = '00';
        if (hours1 >= 6) {
            if (hours1 == 6) {
                hours1 = hours1+6;
                minutes1 = minutes1 + " PM";
            } else {
                hours1 = hours1+6 - 12;
                minutes1 = minutes1 + " PM";
            }
        } else {
            hours1 = hours1+6;
            minutes1 = minutes1 + " AM";
        }
        if (hours1 == 0) {
            hours1 = 6;
            minutes1 = minutes1 + "AM";
        }



        $('.slider-time6').html(hours1 + ':' + minutes1 + ' - ');

        var hours2 = Math.floor(ui.values[1] / 60);
        var minutes2 = ui.values[1] - (hours2 * 60);



        if (hours2.length == 1) hours2 = '0' + hours2;
        if (minutes2.length == 1) minutes2 = '0' + minutes2;
        if (minutes2 == 0) minutes2 = '00';
        if (hours2 >= 6) {
            if (hours2 == 6) {
                hours2 = hours2+6;
                minutes2 = minutes2 + " PM";
            } else if (hours2 == 16) {
                hours2 = 10;
                minutes2 = "00 PM";
            } else {
                hours2 = hours2 +6 - 12;
                minutes2 = minutes2 + " PM";
            }
        } else {
            hours2 = hours2+6;
            minutes2 = minutes2 + " AM";
        }

        $('.slider-time7').html(hours2 + ':' + minutes2);

        var timed1 = hours1 + ':' + minutes1;
        var timed2 = hours2 + ':' + minutes2;

        if(timed1==timed2){

            $('.slider-time7').html('N/A');
            $('.slider-time6').html('');
        }

      
    },
    stop:function(e,ui){
        worktime_reminder();    
    }
});

//third row of slider
$("#slider-range4").slider({
    range: true,
    min: 0,
    max: 960,
    step: 15,
    values: [450, 500],
    slide: function (e, ui) {
        var hours1 = Math.floor(ui.values[0] / 60);
        var minutes1 = ui.values[0] - (hours1 * 60);
        worktime9=ui.values[0];
        worktime10=ui.values[1];


        if (hours1.length == 1) hours1 = '0' + hours1;
        if (minutes1.length == 1) minutes1 = '0' + minutes1;
        if (minutes1 == 0) minutes1 = '00';
        if (hours1 >= 6) {
            if (hours1 == 6) {
                hours1 = 12;
                minutes1 = minutes1 + " PM";
            } else {
                hours1 = hours1+6 - 12;
                minutes1 = minutes1 + " PM";
            }
        } else {
            hours1 = hours1+6;
            minutes1 = minutes1 + " AM";
        }
        if (hours1 == 0) {
            hours1 = 6;
            minutes1 = minutes1+"AM";
        }



        $('.slider-time8').html(hours1 + ':' + minutes1 + ' - ');
        
        
        var hours2 = Math.floor(ui.values[1] / 60);
        var minutes2 = ui.values[1] - (hours2 * 60);


        if (hours2.length == 1) hours2 = '0' + hours2;
        if (minutes2.length == 1) minutes2 = '0' + minutes2;
        if (minutes2 == 0) minutes2 = '00';
        if (hours2 >= 6) {
            if (hours2 == 6) {
                hours2 = hours2+6;
                minutes2 = minutes2 + " PM";
            } else if (hours2 == 16) {
                hours2 = 10;
                minutes2 = "00 PM";
            } else {
                hours2 = hours2+6 - 12;
                minutes2 = minutes2 + " PM";
            }
        } else {
            hours2 = hours2+6;
            minutes2 = minutes2 + " AM";
        }

        $('.slider-time9').html(hours2 + ':' + minutes2);

        var timed1 = hours1 + ':' + minutes1;
        var timed2 = hours2 + ':' + minutes2;


    


        if(timed1==timed2){

            $('.slider-time9').html('N/A');
            $('.slider-time8').html('');
        }

    },
    stop:function(e,ui){
        worktime_reminder();  
    }
});

$("#slider-range5").slider({
    range: true,
    min: 0,
    max: 960,
    step: 15,
    values: [450, 500],
    slide: function (e, ui) {
        var hours1 = Math.floor(ui.values[0] / 60);
        var minutes1 = ui.values[0] - (hours1 * 60);
        worktime11=ui.values[0];
        worktime12=ui.values[1];

        if (hours1.length == 1) hours1 = '0' + hours1;
        if (minutes1.length == 1) minutes1 = '0' + minutes1;
        if (minutes1 == 0) minutes1 = '00';
        if (hours1 >= 6) {
            if (hours1 == 6) {
                hours1 = hours1+6;
                minutes1 = minutes1 + " PM";
            } else {
                hours1 = hours1+6 - 12;
                minutes1 = minutes1 + " PM";
            }
        } else {
            hours1 = hours1+6;
            minutes1 = minutes1 + " AM";
        }
        if (hours1 == 0) {
            hours1 = 6;
            minutes1 = minutes1 + "AM";
        }



        $('.slider-time10').html(hours1 + ':' + minutes1 + ' - ');

        var hours2 = Math.floor(ui.values[1] / 60);
        var minutes2 = ui.values[1] - (hours2 * 60);


        if (hours2.length == 1) hours2 = '0' + hours2;
        if (minutes2.length == 1) minutes2 = '0' + minutes2;
        if (minutes2 == 0) minutes2 = '00';
        if (hours2 >= 6) {
            if (hours2 == 6) {
                hours2 = hours2+6;
                minutes2 = minutes2 + " PM";
            } else if (hours2 == 16) {
                hours2 = 10;
                minutes2 = "00 PM";
            } else {
                hours2 = hours2 +6 - 12;
                minutes2 = minutes2 + " PM";
            }
        } else {
            hours2 = hours2+6;
            minutes2 = minutes2 + " AM";
        }

        $('.slider-time11').html(hours2 + ':' + minutes2);

        var timed1 = hours1 + ':' + minutes1;
        var timed2 = hours2 + ':' + minutes2;

        if(timed1==timed2){

            $('.slider-time11').html('N/A');
            $('.slider-time10').html('');
        }


    },
    stop:function(e,ui){
        worktime_reminder();    
    }
});
// Initialize a new plugin instance for all
// e.g. $('input[type="range"]') elements.

$('input[type="range"]').rangeslider({

    // Feature detection the default is `true`.
    // Set this to `false` if you want to use
    // the polyfill also in Browsers which support
    // the native <input type="range"> element.
    polyfill: false,

    onInit: function() {

        $(".output_hours").html(0);


    },

    // Callback function:events that happens when you slide the time selector for different types of works
    //values are in minutes, maximum value 720

    onSlide: function(position, value) {



        var num = 0;
        var targetName = this.$element[0].name;
        if(targetName == "range1")
            num = 0;
        else if(targetName == "range2")
            num = 1;
        else if(targetName == "range3")
            num = 2;
        else if(targetName == "range4")
            num = 3;
        else if(targetName == "range5")
            num = 4;
        else if(targetName == "range6")
            num = 5;
        else if(targetName == "range7")
            num = 6;
        else if(targetName == "range8")
            num = 7;

        setEachWorkTime(value,num);
    },   
});

var totalWorktimeSelected = 0;

function setEachWorkTime(value,num){
    var minutes=value%60;
    var hours_whole=(value-minutes)/60;

    if(hours_whole==0){
        $(".output_hours").eq(num).html(minutes+" min");

    }
    else{

        $(".output_hours").eq(num).html(hours_whole+" hrs "+minutes+" min");

    }

    workList[num].time = value;

    totalWorktimeSelected = 0;
    var totalWorkedhours = 0;
    var totalWorkedmin = 0;
    for(var i=0;i<workList.length;i++){

        var oneWork = workList[i];
        var oneWorkTime = oneWork.time;
        console.log(oneWorkTime);   
        totalWorktimeSelected = totalWorktimeSelected + oneWorkTime;
            
    }
    totalWorkedmin = totalWorktimeSelected % 60;
    totalWorkedhours = (totalWorktimeSelected- totalWorkedmin) /60;
    if(workList.length==0){

         $("#job_reminder").text("Please select jobs to report");
        document.getElementById("job_reminder").style.color = "#EA7186";

    }
    else{

         $("#job_reminder").text("You have selected " + workList.length + " jobs totaling " + totalWorkedhours + " hrs " + totalWorkedmin + " min");
        document.getElementById("job_reminder").style.color = "#7A77B9";
    }
       
}

var intersected = false;
var totalmin =0;

// generates the reminder line underneath the reminder title
//calculates whether time-selection has intersected
//and the total amount of work time selected

function worktime_reminder(){

    worktotal1=$('.slider-time2').html();
    worktotal2=$('.slider-time1').html();
    worktotal3=$('.slider-time5').html();
    worktotal4=$('.slider-time7').html();
    worktotal5=$('.slider-time9').html();
    worktotal6=$('.slider-time11').html();

    worknumber=[];
    worknumber[0]=worktime1/15;
    worknumber[1]=worktime2/15;
    worknumber[2]=worktime3/15;
    worknumber[3]=worktime4/15;
    worknumber[4]=worktime5/15;
    worknumber[5]=worktime6/15;
    worknumber[6]=worktime7/15;
    worknumber[7]=worktime8/15;
    worknumber[8]=worktime9/15;
    worknumber[9]=worktime10/15;
    worknumber[10]=worktime11/15;
    worknumber[11]=worktime12/15;

    
    worknumberlist=[];

    var middlenum=0;
    var intersected_index = 0;

    var workmin1=0;
    var workmin2=0;
    var workmin3=0;
    var workmin4=0;
    var workmin5=0;
    var workmin6=0;




    if(worktotal1=="N/A" && worktotal2=="N/A" && 
    worktotal3=="N/A" && worktotal4=="N/A" && 
    worktotal5=="N/A" && worktotal6=="N/A"){

        $("#worktime_reminder").html("Please select the time you have worked");
        document.getElementById("worktime_reminder").style.color = "#EA7186";
        


    }

    else{

        if(worktotal1 !== "N/A" && intersected == false){

            for(var i=0;i<=worknumber[1]-worknumber[0];i++){

                middlenum=worknumber[0]+i;


                if(worknumberlist.indexOf(middlenum) == -1){

                    worknumberlist.push(middlenum);
                    workmin1=workmin1+15;
                    
                }
                else{
                    
                    intersected = !intersected;
                    intersected_index ++;
                    break;
                }    

            }

        }


        if(worktotal2 !== "N/A" && intersected == false){

            for(var i=0;i<=worknumber[3]-worknumber[2];i++){

                middlenum=worknumber[2]+i;



                if(worknumberlist.indexOf(middlenum) == -1){

                    worknumberlist.push(middlenum);
                    workmin2=workmin2+15;
                
                }
                else{
                    intersected = !intersected;
                    intersected_index ++;
                    break;
                    
                }    

            }

        }

        if(worktotal3 !== "N/A" && intersected == false){

            for(var i=0;i<=worknumber[5]-worknumber[4];i++){

                middlenum=worknumber[4]+i;



                if(worknumberlist.indexOf(middlenum) == -1){

                    worknumberlist.push(middlenum);
                    workmin3=workmin3+15;
                
                }
                else{
                    intersected = !intersected;
                    intersected_index ++;
                    break;
                    
                }    

            }

        }

        if(worktotal4 !== "N/A" && intersected == false){

            for(var i=0;i<=worknumber[7]-worknumber[6];i++){

                middlenum=worknumber[6]+i;


                if(worknumberlist.indexOf(middlenum) == -1){

                    worknumberlist.push(middlenum);
                    workmin4=workmin4+15;
                
                }
                else{
                    intersected = !intersected;
                    intersected_index ++;
                    break;
                    
                }    

            }

        }

        if(worktotal5 !== "N/A" && intersected == false){

            for(var i=0;i<=worknumber[9]-worknumber[8];i++){

                middlenum=worknumber[8]+i;

                if(worknumberlist.indexOf(middlenum) == -1){

                    worknumberlist.push(middlenum);
                    workmin5=workmin5+15;
                
                }
                else{
                    intersected = !intersected;
                    intersected_index ++;
                    break;
                    
                }    

            }

        }

        if(worktotal6 !== "N/A" && intersected == false){

            for(var i=0;i<=worknumber[11]-worknumber[10];i++){

                middlenum=worknumber[10]+i;

                if(worknumberlist.indexOf(middlenum) == -1){

                    worknumberlist.push(middlenum);
                    workmin6=workmin6+15;
                
                }
                else{
                    intersected = !intersected;
                    intersected_index ++;
                    break;
                    
                }    

            }

        }


        if(intersected == true){

            $("#worktime_reminder").html("your work-time has intersected! Please select correctly.");
            document.getElementById("worktime_reminder").style.color = "#EA7186";
        }
        
        if(intersected == false){

            totalmin =0;
            if (workmin1>0){

                totalmin=totalmin + workmin1-15;
            }
            if (workmin2>0){

                totalmin=totalmin + workmin2-15;
            }
            if (workmin3>0){

                totalmin=totalmin + workmin3-15;
            }
            if (workmin4>0){

                totalmin=totalmin + workmin4-15;
            }
            if (workmin5>0){

                totalmin=totalmin + workmin5-15;
            }
            if (workmin6>0){

                totalmin=totalmin + workmin6-15;
            }

        
            var totalminutes = totalmin%60;
            var totalhour = (totalmin-totalminutes)/60;
            
            $("#worktime_reminder").html("You have selected " +totalhour + " hrs "+ totalminutes +" min of worktime");
            document.getElementById("worktime_reminder").style.color = "#7A77B9";


        }

        intersected = false;
    }
    

    







}



// initiate multiple job select
var isfirst = true;
var workInfo=[ 
      { value: '1', label: 'Admin' },
      { value: '2', label: 'Riding'},
      { value: '3', label: 'Riding Admin' },
      { value: '4', label: 'Vaulting' },
      { value: '5', label: 'Vaulting Admin' },
      { value: '6', label: 'Rehab Clinical' },
      { value: '7', label: 'Rehab Clinical TH' },
      { value: '8', label: 'Rehab Admin' },
      { value: '9', label: 'EFP Clinical' },
      { value: '10', label: 'EFP Clinical TH' },
      { value: '11', label: 'EFP Supervisor' },
      { value: '12', label: 'EFP Admin' },
      { value: '13', label: 'EFL Admin' },
      { value: '14', label: 'Volunterring Admin' },
      { value: '15', label: 'Volunteering -barn' },
      { value: '16', label: 'Vocational Admin' },
      { value: '17', label: 'Vocational Barn' },
      { value: '18', label: 'Fundraising' },
      { value: '19', label: 'Indirect' },
      { value: '20', label: 'BUILD' },
      { value: '21', label: 'Major Gift' },
    ];
var multipleCancelButton = new Choices(
    '#choices-multiple-remove-button',
    {
      removeItemButton: true,
      placeholder:"true",
      placeholderValue: 'hhhhh',
      allowSearch: true, 
      maxItemCount:8,
      addItemText:function(value){
        listChange(); 
      },


    }

).setChoices(
    workInfo,
    'value',
    'label',
    false,
  );


// alter job select content



var workList=[];
var workList1=[];
function listChange(){
    if(isfirst){

        isfirst=false;
        return;
    }

    var ary = multipleCancelButton.getValue(true);
    var length1 = workList.length;
    var length2 = ary.length;
   


    if(length1==length2){
        return;
    }
    else if(length1<length2){ // 添加
        console.log("添加")
        var num =aryCompare(ary,workList1);
        $(".worktype_hour_slider").eq(length1).show();
        workList1 = ary.concat();
        workList.push({
            num:num,
            time:0,
            label:workInfo[num-1].label
        });
        setWorkInfo();
        

    }
    else if(length1>length2){ // 删除
        console.log("删除")
        var num =aryCompare(workList1,ary);
        $(".worktype_hour_slider").eq(length1-1).hide();
        for(var i=0;i<workList.length;i++){
            if(workList[i].num==num){
                workList.splice(i,1)
            }
        }
        workList1 = ary.concat();
        setWorkInfo();
        
    }
}

function aryCompare(ary1,ary2){
    for(var i=0;i<ary1.length;i++){
        var k = 0;
        for(var j=0;j<ary2.length;j++){
            if(ary1[i]==ary2[j]){
                k=1;
                break;
            }
        }
        if(k==0)
            return ary1[i]
    }    
}

function setWorkInfo(){
    var num=0;
    $(".worktype_hour_slider").each(function(e){
        if(num+1>workList.length)
            return;
        console.log(workList)
        this.children[0].innerHTML=workList[num].label;
        $('input[type="range"]').eq(num).val(workList[num].time).change();
        setEachWorkTime(workList[num].time,num)
        num++;

    })
}



//add and reduce function of the work-time selector

var timeslectionIndex = 1;

function addTimeRange(){

    if (timeslectionIndex<3){

        timeslectionIndex= timeslectionIndex +1;
        timeselectionDisplay();

        
        worktime_reminder();

    }


} 

function minusTimeRange(){

    if (timeslectionIndex>1){

        timeslectionIndex= timeslectionIndex -1;
        timeselectionDisplay();

        
        worktime_reminder();

    }


}


function timeselectionDisplay(){
    

    var myE1 = document.getElementById("range1");
    var myE2 = document.getElementById("range2");
    var myE3 = document.getElementById("range3");
    var myE4 = document.getElementById("range4");
    var myE5 = document.getElementById("range5");
    var myE6 = document.getElementById("range6");


    

    if (timeslectionIndex==1){

       

        myE1.style.display = "inline-block";
        myE2.style.display = "inline-block";


        myE3.style.display = "none";
        $("#slider-range2").slider({
            values: [450, 500]
        });    
        $('.slider-time5').html('N/A');
        $('.slider-time4').html('');


        myE4.style.display = "none";
        $("#slider-range3").slider({
            values: [450, 500]
        }); 
        $('.slider-time7').html('N/A');
        $('.slider-time6').html('');

        myE5.style.display = "none";
        $("#slider-range4").slider({
            values: [450, 500]
        }); 
        $('.slider-time9').html('N/A');
        $('.slider-time8').html('');

        myE6.style.display = "none";
        $("#slider-range5").slider({
            values: [450, 500]
        }); 
        $('.slider-time11').html('N/A');
        $('.slider-time10').html('');

        document.getElementById("delete_button").disabled=true;
        document.getElementById("add_button").disabled=false;
    

    }

    if (timeslectionIndex==2){
    

        myE1.style.display = "inline-block";
        myE2.style.display = "inline-block";

        myE3.style.display = "inline-block";
        myE4.style.display = "inline-block";

        myE5.style.display = "none";
        $("#slider-range4").slider({
            values: [450, 500]
        }); 
        $('.slider-time9').html('N/A');
        $('.slider-time8').html('');



        myE6.style.display = "none";
        $("#slider-range5").slider({
            values: [450, 500]
        }); 
        $('.slider-time11').html('N/A');
        $('.slider-time10').html('');

        document.getElementById("delete_button").disabled=false;
        document.getElementById("add_button").disabled=false;
    
    }

    if (timeslectionIndex==3){

        

        myE1.style.display = "inline-block";
        myE2.style.display = "inline-block";

        myE3.style.display = "inline-block";
        myE4.style.display = "inline-block";
        myE5.style.display = "inline-block";
        myE6.style.display = "inline-block";

        document.getElementById("delete_button").disabled=false;
        document.getElementById("add_button").disabled=true;
    
    }
}

timeselectionDisplay();

//variables to check if everything is ready to submit:

//variable that checks if name entry is ready 
var NameReady = true;


//true if selected at least one job to report
var Jobselected = true;


//true if selected at least one job to report
var Timealigned = true;

//true if selected 0 job time
var ZeroJobTime = false;

//true if selected 0 total time
var ZeroTotalTime = false;


function checkTotalAndJobTime(){

    zeroJobTime = false;
    ZeroTotalTime = false;

    

    if (totalmin == 0){

        ZeroTotalTime = true;

    }

    if(totalWorktimeSelected == 0){

        ZeroJobTime = true;
    }



}


//check if time aligned
function checkTimeAligned(){

    if(totalmin ==totalWorktimeSelected ){

        Timealigned = true;


    }

    else{

        Timealigned = false;
    }


}


//check if at least one job was selected
function checkJobSelect(){

    if(workList.length>=1){

        Jobselected = true;
    }

    else{

        Jobselected = false;
    }
}



//checks if name is correctly in list
function checkName(){

    var nameList = ["Lily", "Cathy"];

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
        nameEntry.style="box-shadow: inset 0px 0px 3px #d6dce7;"
        NameReady = true;


    }



    console.log(nameEntry);


}





//reminders while submition:

function canceled(){

    var confirmed = confirm('Are you sure you want to cancel?');

        if (confirmed == true){

            window.location.href = '/staff/index.php';
        }


}

function submitted() {

    checkName();
    checkJobSelect();
    checkTimeAligned();
    checkTotalAndJobTime();

    if(NameReady == false||Jobselected == false|| Timealigned == false|| ZeroJobTime == true||ZeroTotalTime == true ){

        if(NameReady == false){

            alert("Please select or enter a name in the staff list");
            
        }
    
        if(Jobselected == false){
    
            alert("Please select at least one job to report");
        }
    
        if(Timealigned == false){
    
            alert("please make sure that total work time equals total time reported in jobs!");
        }
    
        if(ZeroJobTime == true){
    
            alert("please select the time you've worked at each job!");
    
        }
    
        if(ZeroTotalTime == true){
    
            alert("please select your worktime!");
    
    
        }

    }

    
    else{

        var confirmed = confirm('Are you sure you want to submit?');

        if (confirmed == true){

            window.location.href = 'full-time.php?a=12';
        }


    }

    
    
}


//detecting changes from name input

$("#selected-name").change(function() {
    checkName();
  });
