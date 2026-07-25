var arrayofschedule = [];
var memberschedules = [];
var myuserid = $('#userid').val();
var currColor = "rgb(68, 68, 68)"; //black by default
var colorCancelled = 'rgb(221, 75, 57)';
var colorFinished = '#00a65a',colorGeneratedAPV = '#898989';
var colorOngoing = 'rgb(243, 156, 18)';
//Color chooser button
var colorChooser = $("#color-chooser-btn");        


String.prototype.nl2br = function(){
    return this.replace(/\n/g, "<br />");
}


$(document).ready(function(){
  var moduleid = $('#moduleid').val();
  
  switch(moduleid){
    case 'scheduler':
    retrieveSchedule(myuserid,'');
    retrieveSchedulerNotifications();
    viewAllDatedReminders();
    break;

    default:
    break;
  }//end swtich

});

function viewAllDatedAnnouncement(){
  $.get(domain+'/scheduler/getdatedannouncements',{},function(data){
    var data = $.parseJSON(data);
      $.each(data.announcements, function(anonindex, anoni) {
        generateAlert('warning','<b>ANNOUNCEMENT: '+anoni['anon_title'].nl2br()+'</b></br>'+anoni['anon_desc'].nl2br(),'ANNOUNCEMENT');
      });//end each
  });//end ajax
}//end if

function viewAllDatedReminders(){
  $.get(domain+'/scheduler/getdatedreminders',{},function(data){
    var data = $.parseJSON(data);
      $.each(data.reminders, function(reminderindex, reminder) {
        generateAlert('information','<b>REMINDER: '+reminder['reminder_title'].nl2br()+'</b></br>'+reminder['reminder_desc'].nl2br(),'REMINDER');
      });//end each
  });//end ajax
}//end 
  
function retrieveSchedule(userid,monthfilter){
  arrayofschedule = [];
  $('#calendar').fullCalendar('removeEvents');
  $('#overlay').css('display','block'); 
  $.post(domain+"/scheduler/retrieveschedules",{id:userid,m:monthfilter},function(result){
        $('#overlay').css('display','none'); 
        //$('#calendar').html('');
        var result = $.parseJSON(result);
        var color = "";
        var tagclass = "";
        $.each(result.schedules, function(schedindex, schedname) {
          switch(result.schedules[schedindex]['event_tagging']){
            case 'FINISHED': // WTODO JAD 06-03-2019
              if(result.schedules[schedindex]['approvedate'] != ''){
                color = colorGeneratedAPV;
              }else{
                color = colorFinished;
              }//end if
              tagclass = "finished ";
            break;

            case 'CANCELLED':
              color = colorCancelled;
              tagclass = "cancelled ";
            break;

            case 'ONGOING':
              color = colorOngoing;
              tagclass = "ongoing ";
            break
          }//end switch case
          arrayofschedule.push({title:result.schedules[schedindex]['sched_desc'],
            start:result.schedules[schedindex]['date1'],
            end:result.schedules[schedindex]['date2'],
            allDay:true,
            id:result.schedules[schedindex]['sched_seq'],
            className: tagclass + 'schedule~'+result.schedules[schedindex]['sched_seq'],
            backgroundColor:color,
            borderColor: "#000000"});
        });//end each
        $('#calendar').fullCalendar('addEventSource', arrayofschedule);         
        $('#calendar').fullCalendar('rerenderEvents');
        calendar_init();
  });//ajax
}//end function


function calendar_init(){
  /* initialize the external events
         -----------------------------------------------------------------*/
        ini_events($('#external-events div.external-event'));
        /* initialize the calendar
         -----------------------------------------------------------------*/
        //Date for the calendar events (dummy data)
        var date = new Date();
        var d = date.getDate(),
                m = date.getMonth(),
                y = date.getFullYear();
        $('#calendar').fullCalendar({
          header: {
            left: 'title',
            center: '',
            right: 'prev,next'
          },
          //Random default events
          events: arrayofschedule,
          editable: true,
          droppable: true, // this allows things to be dropped onto the calendar !!!
          eventLimit: true,
          eventResize: debounce(function(event, delta, revertFunc) { //THIS EVENT TRIGGERS WHEN RESIZING AN EVENT
            if(!checkDragAvailability($(this))){
              generateAlert('error','Cannot update schedules that is tagged FINISHED / CANCELLED. Please create another.','ERROR');
              var month = $('#calendar').fullCalendar('getDate').format('MM');
              retrieveSchedule(myuserid,month);
            }else{
              var seq = $(this).prop('id');
              var datestart = moment(event.start).format('YYYY-MM-DD');
              dateend = moment(event.end).format('YYYY-MM-DD');
              //INSERT JAO FUNCTIONS HERE
              var params = {startdate:datestart,enddate:dateend};
              updateEvent(params,seq,'PLOTTING');
            }//end if
          },300),
          eventDrop: function(event, delta, revertFunc) { //THIS EVENT TRIGGERS WHEN SOMETHING ON THE CALENDAR IS DROPPED ON OTHER DATE
            if(!checkDragAvailability($(this))){
              generateAlert('error','Cannot update schedules that is tagged FINISHED / CANCELLED. Please create another.','ERROR');
              var month = $('#calendar').fullCalendar('getDate').format('MM');
              retrieveSchedule(myuserid,month);
            }else{
              var seq = $(this).prop('id');
              var datestart = moment(event.start).format('YYYY-MM-DD');
              if(event.end == null){
                var dateend = moment(event.start).format('YYYY-MM-DD');
              }else{
                dateend = moment(event.end).format('YYYY-MM-DD');
              }
              //INSERT JAO FUNCTIONS HERE
              var params = {startdate:datestart,enddate:dateend};
              updateEvent(params,seq,'PLOTTING');
            }//end if
          },
          drop: function (date, allDay) { // this function is called when something is dropped
            arrayofschedule = []
            var seq = $(this).prop('id');
            var datestart = moment(date).format('YYYY-MM-DD');
            var dateend = moment(date).format('YYYY-MM-DD');
            var params = {startdate:datestart,enddate:dateend};
            updateEvent(params,seq,'PLOTTING');
            //INSERT JAO FUNCTIONS HERE
            // retrieve the dropped element's stored Event Object
            var originalEventObject = $(this).data('eventObject');
            // we need to copy it, so that multiple events don't have a reference to the same object
            var copiedEventObject = $.extend({}, originalEventObject);

            // assign it the date that was reported
            copiedEventObject.start = date;
            copiedEventObject.allDay = allDay;
            copiedEventObject.backgroundColor = "rgb(243,156,18)";
            copiedEventObject.borderColor = "#000000";
            copiedEventObject.id = seq;
            // render the event on the calendar
            // the last `true` argument determines if the event "sticks" (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)
            $('#calendar').fullCalendar('renderEvent', copiedEventObject, true);
            // is the "remove after drop" checkbox checked?
            
            ///MODIFIED BY JAOSKI
            //if ($('#drop-remove').is(':checked')) {
              // if so, remove the element from the "Draggable Events" list
              $(this).remove();
            //}
            ///MODIFIED BY JAOSKI
          }
        });
}//end function init

/* ADDING EVENTS */

$(document).on('click','#color-chooser > h5 > li > a',function(e){
  e.preventDefault();
  $('#event-type').val($(this).prop('id'));
  //Save color
  currColor = $(this).css("color");
  //Add color effect to button
  $('#add-new-event').css({"background-color": currColor, "border-color": currColor});
});
        
$(document).on('click','#add-new-event',debounce(function(){
  var val = $("#new-event").val(),
      type = $('#event-type').val();
  if (type == "") {
    type = 'OTHERS';
  }//end type = ""
  if(val == "") {
    generateAlert('error','Cannot insert new schedule without description. Try again.','ERROR');
  }else{
    insertEvent(val,type);
  } // end if val length
},300));

$(document).on('click','.fc-day-grid-event',debounce(function(){
  var viewmode = $('#viewmode').val();
  switch(viewmode){
      case 'EDIT':
        var thisid = $(this).prop('id');
        var event_tit = $(this).children().children().html();
        if($(this).hasClass('cancelled') || $(this).hasClass('finished')){
          var updateready = false;
        }else{
          var updateready = true;
        }//end if
        var param = {seq:thisid,event:event_tit,updateready:updateready};
        generateMessagebox("<b>("+event_tit+")</b></br><b>What do you want to do with this event?</b>","CALENDAR_MOD",param);
      break;

      case 'VIEW':
        var thisid = $(this).prop('id');
        var params = {seq:thisid};
        retrieveEventinfo(params);
      break;
  }
},300));

$(document).on('click','.schedulernotif',debounce(function(){
  var viewmode = $('#viewmode').val('VIEW');
  var thisid = $(this).prop('id').split('~');
  var params = {seq:thisid[0]};
  retrieveEventinfo(params);
  updateNotification(thisid[1]);
  retrieveSchedulerNotifications();
},300));


// WTODO JAD 06-03-2019
function insertEvent(description,type) {
  var ccode = $('.calendarclientcode1').val(),
    projectid = $('.projectidtag').val(),
    loc = $('.event-loc').val(),
    rem = $('.event-rem').val(),
    time = $('.event-txttime').val(),
    jo = $('.event-jo').val(),
    amt = $('.event-amt').val(),
    eventsched = $('.txtreporttypeevent').val();
  if(projectid == "") { projectid = 0; }
  $('#overlay').css('display','block');
  if(ccode == "") {
      generateAlert('error','Please enter Customer code, before creating a new schedule.','ERROR');
      $('#overlay').css('display','none');
  } else {
    $.get(domain+'/scheduler/insertevent',{eventshed:eventsched,prj:projectid,loc:loc,rem:rem,time:time,description:description,type:type,ccode:ccode,jo:jo,amt:amt},function(data){
      $('#overlay').css('display','none');
      var data = $.parseJSON(data);
      if(data.status) {
        var event = $("<div/>");
        event.css({"background-color": "rgb(68, 68, 68)", "border-color": "rgb(68, 68, 68)", "color": "#fff"}).addClass("external-event");
        event.addClass("fc-event").addClass("pendingevent").prop('id',data.seq).html(description);
        $('#external-events').prepend(event);
        ini_events(event);
        $(".projectnametag, #projectidtag, .event-loc, .event-rem, .calendarclientcode1, .event-amt, .new-event, .event-jo").val("");
        $('.event-txttime').val('12:00 AM');
      } else {
        $(".projectnametag, #projectidtag, .event-loc, .event-rem, .calendarclientcode1, .event-amt, .new-event, .event-jo").val("");
        $('.event-txttime').val('12:00 AM');
        generateAlert('error','Error inserting new schedule , Please try again.','ERROR');
      }//end if data.status is true
    }).fail(function (jqXHR, textStatus, error) {
      generateAlert('error','System Error: Status Code ' +jqXHR.status,'ERROR');
    }); //end ajax
  }//end function
}//end insertevent


// WTODO JAD 06-03-2019
function updateEvent(params,seq,type){
  $('#overlay').css('display','block');
  $.post(domain+'/scheduler/updateevent',{params:params,seq:seq,type:type},function(data){
        $('#overlay').css('display','none');
        data = $.parseJSON(data);
        $('#projectidtag').val('');
        $('#projectidtagupdate').val('');
        if(!data.status){
          generateAlert('error',data.msg,'ERROR');
        }else{
          if(type == "TAGGING"){
            $('#modal-createevent').modal('hide');
            $('#'+seq).children().children().text(params['title']);
            var month = $('#calendar').fullCalendar('getDate').format('MM');
            retrieveSchedule(myuserid,month);
          }//END IF TAGGING 
        }//end 
    });
}//end function update event


function clickUnpinEvent(param){
generateMessagebox("<b>Are you sure to UNPIN this event?</b>","CALENDAR_EVENT_UNPIN",param);
}

function clickDeleteEvent(param){
  generateMessagebox("<b>Are you sure to delete this event?</b>","CALENDAR_EVENT_DEL",param);
}

function clickUpdateEvent(param){
  generateMessagebox("<b>Are you sure to delete this event?</b>","CALENDAR_EVENT_DEL",param);
}

function clickCommentEvent(param){
  $('#viewmode').val('VIEW');
  var params = {seq:param['seq']};
  retrieveEventinfo(params);
}//end comment


function deleteEvent(seq){
  var month = $('#calendar').fullCalendar('getDate').format('MM');
  $('#overlay').css('display','block');
  $('.txtsearchsched').val('');
  $('#modal-calendar-schedlisting').modal('hide'); 
  $.post(domain+'/scheduler/deleteevent',{seq:seq,m:month},function(data){
    $('#overlay').css('display','none');
    var data = $.parseJSON(data);
    if(data.status){
      $('.fc-day-grid-event#'+seq).remove();
      re_initialize(data.plotted);
      plotRetrieveUnplottedEvents(data);
    }else{
      generateAlert('error',data.msg,'ERROR');
      plotRetrieveUnplottedEvents(data);
    }//end delete event
  });
}//end delete event

function unpinEvent(seq){
  var month = $('#calendar').fullCalendar('getDate').format('MM');
  $('#overlay').css('display','block');
  $('.txtsearchsched').val('');
  $('#modal-calendar-schedlisting').modal('hide'); 
  $.post(domain+'/scheduler/unpinevent',{seq:seq,m:month},function(data){
    $('#overlay').css('display','none');
    var data = $.parseJSON(data);
    var color = "";
    $('#external-events').html("<img src='"+domain+"/backendassets/img/loading.gif' style='position:absolute;margin-left:45%;margin-top:15%;' width='5%'/>");
    if(data.status){
      $('.fc-day-grid-event#'+seq).remove();
      re_initialize(data.plotted);
      plotRetrieveUnplottedEvents(data);
    }else{
      generateAlert('error',data.msg,'ERROR');
      plotRetrieveUnplottedEvents(data);
    }//end unpin event
  });
}//end unpinevent

function plotRetrieveUnplottedEvents(data){
    $('#external-events').html('');
    $.each(data.unplotted, function(schedindex, schedname) {
          switch(data.unplotted[schedindex]['sched_type']){
            default:
              color = "color: #ffffff;background-color: #444444;border-color: rgba(0, 0, 0, 0.2);";
            break;
          }//end switch case
          $('#external-events').append('<div style="'+color+'" id = "'+data.unplotted[schedindex]['sched_seq']+'" class="external-event fc-event">'+data.unplotted[schedindex]['sched_desc']+'</div>');
    });//end each
    ini_events($('#external-events div.external-event'));
}//end plotretrieve unplotted

function ini_events(ele) {
          ele.each(function () {
            // create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
            // it doesn't need to have a start or end
            var eventObject = {
              title: $.trim($(this).text()) // use the element's text as the event title
            };
            // store the Event Object in the DOM element so we can get to it later
            $(this).data('eventObject', eventObject);

            // make the event draggable using jQuery UI
            $(this).draggable({
              zIndex: 1070,
              revert: true, // will cause the event to go back to its
              revertDuration: 0  //  original position after the drag
            });

          });
}//ini _Events



function re_initialize(schedules){
  arrayofschedule = [];
  $('#calendar').fullCalendar('removeEvents');
        var color = "";
        $.each(schedules, function(schedindex, schedname) {
          switch(schedules[schedindex]['event_tagging']){
            case 'FINISHED':
              color = colorFinished;
            break;

            case 'CANCELLED':
              color = colorCancelled;
            break;

            case 'ONGOING':
              color = colorOngoing;
            break
          }//end switch case

          arrayofschedule.push({title:schedules[schedindex]['sched_desc'],
            start:schedules[schedindex]['date1'],
            end:schedules[schedindex]['date2'],
            allDay:true,
            id:schedules[schedindex]['sched_seq'],
            backgroundColor:color,
            borderColor: "#000000"});
        });//end each
    $('#calendar').fullCalendar('addEventSource', arrayofschedule);         
    $('#calendar').fullCalendar('rerenderEvents');
}//end initialize

// WTODO JAD 06-03-2019
function retrieveEventinfo(params){
  $('#overlay').css('display','block');
  var viewmode = $('#viewmode').val();
  $('#modal-calendar-schedlisting').modal('hide');
  $.get(domain+'/scheduler/retrieveeventinfo',{seq:params['seq']},function(data){ 
      var data = $.parseJSON(data);
      switch(viewmode){
          case 'VIEW':
            $('.eventprop-txtcomment').val('');
            $('#modal-calendar-eventprop').modal();
            $('.eventprop-title').html(data.schedinfo[0]['sched_desc']);
            $('.eventprop-loc').html(data.schedinfo[0]['loc']);
            $('.eventprop-time').html(data.schedinfo[0]['starttime']);
            $('.eventprop-createdate').html(data.schedinfo[0]['createdate']);
            $('.eventprop-creater').html(data.schedinfo[0]['name']);
            $('.eventprop-username').html(data.schedinfo[0]['username']);
            $('.eventprop-jo').html(data.schedinfo[0]['jonumber']);
            $('.eventprop-schedulefor').html(data.schedinfo[0]['clientname'] + ' - ' + data.schedinfo[0]['client']);
            $('#prop_eventid').val(data.schedinfo[0]['sched_id']);
            $('#prop_keyid').val(data.schedinfo[0]['userid']);
            if(data.schedinfo[0]['date1'] == '0000-00-00') {
              var date1 = 'No Schedule Yet';
                $('.eventprop-scheduled').html(date1);
            } else {
              var date1 = data.schedinfo[0]['date1'],
                  date2 = data.schedinfo[0]['date2'];
                if(date1 == date2) {
                  $('.eventprop-scheduled').html(date1);
                } else {
                  $('.eventprop-scheduled').html(date2);
                }//end if nested else
            }//end if
            $('.txtreporttypeevent').html('<option>'+data.schedinfo[0]['schedtype']+'</option>');
            $('.eventprop-status').html(data.schedinfo[0]['event_tagging']);
            $('.eventprop-rem').html(data.schedinfo[0]['rem']);
            $('.eventprop-comments').prop('id',data.schedinfo[0]['sched_seq']);
            $('.eventprop-comments').html('View all Comments ('+data.schedinfo[0]['commentcount']+')');
            $('.btncalendar-viewnotes2').text('View all Notes ('+data.schedinfo[0]['notecount']+')');
            if($('#moduleview').val() == 'OWN'){
              $('#viewmode').val('EDIT');
            }else{
              $('#viewmode').val('VIEW');
            }//END
          break;

          case 'EDIT':
            $('#modal-createevent h4.aims-lookup-title').html("Update Event");
            $('.new-event').val(params['event']).prop('readonly',true);
            $('.calendarclientcode1').val(data.schedinfo[0].client);
            $('.event-txttime').val(data.schedinfo[0].starttime);
            $('.sched_seq').val(params['seq']);
            $('.event-rem').val(data.schedinfo[0].rem);
            $('.projectnametag').val(data.schedinfo[0].prjname);
            $('.projectidtag').val(data.schedinfo[0].project_tagging);
            $('.event-jo').val(data.schedinfo[0]['jonumber']);
            $('.event-loc').val(data.schedinfo[0]['loc']);
            $('.txtreporttypeevent').html('<option>'+data.schedinfo[0]['schedtype']+'</option>');
            $('.btncalendar-viewnotes').html('View all Notes ('+data.schedinfo[0].notecount+')');
            $('.event-updatebtn, .tagsched, .eventnotes').show();
            $('.schedtagging, .btncalendar-viewnotes').parent().parent().show();
            $('.add-new-event').hide();
            $(".event-txttime").timepicker({ showInputs: false });
            if(data.schedinfo[0]['approvedate'] != '') {
              $('.event-amt').val(data.schedinfo[0]['amt']).prop('disabled',true);
              $('.schedtagging').html('<option>'+data.schedinfo[0].event_tagging+'</option>').prop('disabled',true);
            } else {
              $('.event-amt').val(data.schedinfo[0]['amt']).prop('disabled',false);
              $('.schedtagging').html('<option>'+data.schedinfo[0].event_tagging+'</option>').prop('disabled',false);
            }//end if
            loadAvailableEventtags();
            loadReportScheduleType();
            $('#modal-createevent').modal().css('zIndex',99999);
          break;
      }//end switch
      $('#overlay').css('display','none');
  }).fail(function (jqXHR, textStatus, error) {
    generateAlert('error','System Error: Status Code ' +jqXHR.status,'ERROR');
  }); //end ajax
}//end

$(document).on('click','.eventprop-comments',debounce(function(){
  var eventid = $('#prop_eventid').val();
  loadEventComments(eventid,'EVENT');
  $('#modal-calendar-eventcomment').modal();
},300));

$(document).on('click','.eventprop-addcomment',debounce(function(){
    var eventid = $('#prop_eventid').val();
    var comment = $('.eventprop-txtcomment').val();
    var userid = $('#prop_keyid').val();
    if(comment == ""){
      generateAlert('error','Please enter a valid comment.','ERROR');
    }else{
      addComment(eventid,comment,userid,'EVENT');
    }
},300));

function addComment(eventid,comments,userid,type){
    $.get(domain+"/scheduler/addcomment",{comment:comments,primary:eventid,xcom:userid,type:type},function(data){
      var data = $.parseJSON(data);
        if(data.status){
            $('.eventprop-comments').html('View all Comments ('+data.commentcount+')');
            generateAlert('information',"Comment added successfully!",'DEFAULT');
            $('.eventprop-txtcomment').val('');
            $('.txtnotecomment').val('');
            
            switch(type){
              case 'NOTES':
              var seq = $('#sched_seq').val();
              loadEventComments(eventid,'NOTES');
              loadScheduleNotes(seq,'REFRESH');
              break;
            }//end switch case
        }else{
            generateAlert('error','Error inserting new comment.','ERROR');
        }//end if status  
    }).fail(function (jqXHR, textStatus, error) {
      generateAlert('error','System Error: Status Code ' +jqXHR.status,'ERROR');
    }); //end ajax
}//end add comment

function loadEventComments(eventid,type){
    $('.commentingarea').html('');
    $.get(domain+"/scheduler/retrievecomments",{primary:eventid,type:type},function(data){
      var data = $.parseJSON(data);
      var strhtml = "";
        $.each(data.comments, function(commentindx, commentinfo) {                
            strhtml = strhtml.concat("<div class='box-comment' style='margin-bottom:3px;'>");
            if(data.comments[commentindx]['picture'] == null || data.comments[commentindx]['picture'] == ""){
              var pic = domain +'/fimages/inventee/png/placeholder.png';
            }else{
              var pic = data.comments[commentindx]['picture'];
            }//end

            strhtml = strhtml.concat("<img class='img-square img-sm' src='"+pic+"' alt='user image'>");
            strhtml = strhtml.concat("<div class='comment-text'>");
            strhtml = strhtml.concat("<span class='username aimslabel'>" + data.comments[commentindx]['name']);
            strhtml = strhtml.concat("<span class='aimslabel text-muted pull-right'>"+data.comments[commentindx]['createdate']+"</span>");
            strhtml = strhtml.concat("</span>");
            strhtml = strhtml.concat("<p class='aimslabel'>"+data.comments[commentindx]['comment'].nl2br()+"</p>");
            strhtml = strhtml.concat("</div></div>");
        });//end each


      switch(type){
        case 'NOTES':
        $('.notecommentview').html(strhtml);
        $('.notecomment-notebody').html(data.comments[0]['notes_body']);
        $('.notecomment-projectname').html(data.comments[0]['project_title']);
        break;

        case 'EVENT':
        $('.commentingarea').html(strhtml);
        break;
      }//end switch

    }).fail(function (jqXHR, textStatus, error) {
      generateAlert('error','System Error: Status Code ' +jqXHR.status,'ERROR');
    }); //end ajax
}//end load eventcomments

// WTODO JAD 06-03-2019
$(document).on('click','.event-updatebtn',debounce(function(){
  var tag = $('#modal-createevent .schedtagging option:selected').text(),
      rem = $('.schedrem').val(),
      seq = $('.sched_seq').val(),
      time = $('.event-txttime').val(),
      location = $('.event-loc').val(),
      title = $('.new-event').val(),
      client = $('.calendarclientcode1').val(),
      prj = $('.projectidtag').val(),
      jo = $('.event-jo').val(),
      amt = $('.event-amt').val(),
      eventsched = $('.txtreporttypeevent').val(),
      params = {eventsched:eventsched,tagging:tag,rem:rem,client:client,loc:location,time:time,title:title,prj:prj,jo:jo,amt:amt};
  updateEvent(params,seq,'TAGGING');
},300));


$(document).on('click','.viewscheds',debounce(function(){
  $('#content_mysched').css('display','none');
  $('#content_viewsched').css('display','block');
  $(this).css('display','none');
  $('.personalscheds').css('display','block');
  $('.scheduleruser').val('');
  $('#viewmode').val('VIEW');
  $('#moduleview').val('OTHERS');
  retrieveMemberSchedule('','');
},300));

$(document).on('click','.personalscheds',debounce(function(){
  $('#content_viewsched').css('display','none');
  $('#content_mysched').css('display','block');
  $(this).css('display','none');
  $('.viewscheds').css('display','block');
  $('#viewmode').val('EDIT');
  $('#moduleview').val('OWN');
  retrieveSchedule(myuserid,'');
},300));

function retrieveMemberSchedule(userid,monthfilter){
  memberschedules = [];
  $('#calendarothers').fullCalendar('removeEvents');
  $('#overlay').css('display','block'); 
  $.post(domain+"/scheduler/memberschedules",{userid:userid,m:monthfilter},function(result){
    $('#overlay').css('display','none'); 
    var result = $.parseJSON(result);
    var color = "";

        $.each(result.memberschedule, function(schedindex, schedname) {
          switch(result.memberschedule[schedindex]['event_tagging']){
            case 'FINISHED':
              color = colorFinished;
            break;

            case 'CANCELLED':
              color = colorCancelled;
            break;

            case 'ONGOING':
              color = colorOngoing;
            break
          }//end switch case

        memberschedules.push({title: "["+result.memberschedule[schedindex]['name']+"] " + result.memberschedule[schedindex]['sched_desc'],
            start:result.memberschedule[schedindex]['date1'],
            end:result.memberschedule[schedindex]['date2'],
            allDay:true,
            id:result.memberschedule[schedindex]['sched_seq'],
            backgroundColor:color,
            borderColor: "#000000"});
        });//end each

        $('#calendarothers').fullCalendar('addEventSource', memberschedules);         
        $('#calendarothers').fullCalendar('rerenderEvents');
        calendar_view_init();
        plotUnfinishedEvents(result.unfinished);
        plotUnplottedEvents(result.unplotted);
  });
}//end retrieve member schedule


function calendar_view_init(){
        /* initialize the calendar
         -----------------------------------------------------------------*/
        //Date for the calendar events (dummy data)
        var date = new Date();
        var d = date.getDate(),
                m = date.getMonth(),
                y = date.getFullYear();
        $('#calendarothers').fullCalendar({
          header: {
            left: 'title',
            center: '',
            right: 'prev,next'
          },
         /* buttonText: {
            today: 'today',
            month: 'month',
            week: 'week',
            day: 'day'
          },*/
          //Random default events
          events: memberschedules,
          editable: false,
          eventLimit: true,
          eventResize: debounce(function(event, delta, revertFunc) { //THIS EVENT TRIGGERS WHEN RESIZING AN EVENT
            var month = $('#calendarothers').fullCalendar('getDate').format('MM');
            retrieveMemberSchedule('',month);
          },300)
        });
        $('.fc-day-grid-event').addClass('clickable');
}//end function init

function plotUnfinishedEvents(data){
  $('#unfinished_scheds').html('');
  $.each(data, function(schedindex, schedname){
    switch(data[schedindex]['event_tagging']){
      case 'FINISHED':
        color = colorFinished;
      break;

      case 'CANCELLED':
        color = colorCancelled;
      break;

      case 'ONGOING':
        color = colorOngoing;
      break
    }//end switch case

    $('#unfinished_scheds').append('<div style="background-color:'+color+';" id = "'+data[schedindex]['sched_seq']+'" class="unfinishedevent external-event fc-event">'+data[schedindex]['sched_desc']+ ' - ' + data[schedindex]['name'] +'</div>');
  });
}//end

function plotUnplottedEvents(data){
  $('#unplotted_scheds').html('');
  $.each(data, function(schedindex, schedname){
    $('#unplotted_scheds').append('<div style="background-color:'+currColor+';" id = "'+data[schedindex]['sched_seq']+'" class="unfinishedevent external-event fc-event">'+data[schedindex]['sched_desc']+ ' - ' + data[schedindex]['name'] +'</div>');
  });
}//end


$(document).on('click','.pendingevent',debounce(function(){
  var param = {seq:$(this).prop('id'),event:$(this).html()};
  generateMessagebox("<b>("+param['event']+")</b></br><b>What do you want to do with this event?</b>","CALENDAR_PENDING_PROP",param);
},300));



$(document).on('click','.createnewevent',debounce(function(){
  $('#modal-createevent h4.aims-lookup-title').html('Create Event');
  $('.tagsched, .eventnotes').hide();
  $('.new-event').prop('readonly',false);
  $('.schedtagging, .btncalendar-viewnotes').parent().parent().hide();
  $('.add-new-event').show();
  $('.event-updatebtn').hide();
  $('.schedtxt').val('');
  $(".event-txttime").timepicker({
      showInputs: false
  });
  $('#modal-createevent').modal();
  loadReportScheduleType(); 
},300));

function loadReportScheduleType(){
  var eventopt = {0:'-',1:'PROVINCE',2:'NON-PROVINCE'};
  $('.txtreporttypeevent option:not(:selected)').remove();
  $.each(eventopt, function(windex, eventoption) {
    if(eventopt[windex] != $('.txtreporttypeevent option:selected').text()){
        if(eventopt[windex]=='-'){
          $('.txtreporttypeevent').append('<option></option>');
        }else{
          $('.txtreporttypeevent').append('<option>'+eventopt[windex]+'</option>');
        }
    }//END IF
  });
}

// WTODO JAD 06-03-2019
$(document).on('click','.unfinishedevent',debounce(function(){
    var thisid = $(this).prop('id');
    var params = {seq:thisid};
    retrieveEventinfo(params);
},300));


$(document).on('click','.ongoingevent',debounce(function(){
    $('#schedtag').val('ONGOING');
    retrieveFilteredSchedules('ONGOING','DEFAULT','');
},300));

$(document).on('keyup','.txtsearchsched',debounce(function(){ 
    var schedtag = $('#schedtag').val();
    retrieveFilteredSchedules(schedtag,'DEFAULT',$(this).val());
},300));

$(document).on('click','.schedulertimein',debounce(function(){
    memberTimein();
},300));


// WTODO JAD 06-03-2019
function retrieveFilteredSchedules(tagging,type,searchstring){
  $('.schedlistdiv').html("<img src='"+domain+"/backendassets/img/loading.gif' style='position:absolute;margin-left:45%;margin-top:10%;' width='5%'/>");
  $.get(domain+'/scheduler/filteredschedules',{type:type,tagging:tagging,searchstring:searchstring},function(data){
    var data = $.parseJSON(data);
    var strhtml = "";
      $('.schedlistdiv').html('');
      $.each(data.schedules, function(schedindex, schedname) {
        switch(tagging){
          case 'ONGOING':
            strhtml = strhtml.concat('<a id="'+data.schedules[schedindex]['sched_seq']+'" class="fc-day-grid-event fc-h-event fc-event fc-start fc-end fc-draggable fc-resizable" style="background-color:rgb(243, 156, 18);border-color:#000000">');
            strhtml = strhtml.concat('<div class="fc-content clickable">');
            strhtml = strhtml.concat('<span class="fc-title">'+data.schedules[schedindex]['sched_desc']+'</span>');
            strhtml = strhtml.concat('</div></a>');
          break;

          case 'CANCELLED':

          break;

          case 'FINISHED':

          break;
        }//end switch case
      });
      $('#modal-calendar-schedlisting').modal();
      $('.schedlistingdiv').append(strhtml);
  }).fail(function (jqXHR, textStatus, error) {
    generateAlert('error','System Error: Status Code ' +jqXHR.status,'ERROR');
  }); //end ajax
}//end function

function memberTimein(){
  $.get(domain+'/scheduler/timein',{},function(data){
      var data = $.parseJSON(data);
      if(data.status){
        generateAlert('information',"<b>"+data.msg+"</b>",'DEFAULT');
        $('.schedulertimein').css('display','none');
      }else{
        generateAlert('error',"<b>"+data.msg+"</b>",'ERROR');
      }
  }).fail(function (jqXHR, textStatus, error) {
    generateAlert('error','System Error: Status Code ' +jqXHR.status,'ERROR');
  }); //end ajax
}//end function


$(document).on('click','.btncalendar-viewnotes',debounce(function(){
  var seq = $('.sched_seq').val();
  loadScheduleNotes(seq,'EDIT');
  $('.noteediting').css('display','block');
  $('.noteviewing').css('display','none');
  // WTODO JAD 06-03-2019
  $('#modal-calendar-notes').modal().zIndex(100000);
},300));

$(document).on('click','.btncalendar-viewnotes2',debounce(function(){
  var seq = $('#prop_keyid').val() + '-' + $('#prop_eventid').val();
  loadScheduleNotes(seq,'VIEW');
  $('.noteediting').css('display','none');
  $('.noteviewing').css('display','block');
  $('#modal-calendar-notes').modal();
},300));


$(document).on('click','.event-addnotebtn',debounce(function(){
  $('#overlay').css('display','block');
  if($('.event-txtnotes').val() == ""){
    generateAlert('error','Cannot add blank notes , please check!','ERROR');
    $('#overlay').css('display','none');
  }else{
    insertNewNote();
  }//end if
},300));

function insertNewNote(){
  var seq = $('.sched_seq').val();
  var notes = $('.event-txtnotes').val();
  $.get(domain+'/scheduler/insertnote',{notes:notes,seq:seq},function(data){
      var data = $.parseJSON(data);
      $('#overlay').css('display','none');
      $('.event-txtnotes').val('');
      loadScheduleNotes(seq,'EDIT');
      }).fail(function (jqXHR, textStatus, error) {
        generateAlert('error','System Error: Status Code ' +jqXHR.status,'ERROR');
      }); //end ajax
}///end insert new note

function loadScheduleNotes(seq,type){
  $.get(domain+'/scheduler/retrievenotes',{seq:seq},function(data){
      var data = $.parseJSON(data);
      $('#overlay').css('display','none');
        var strhtml ="";
        $('.viewnotearea').html('');
        $('.noteviewingdiv').html('');
        $.each(data.notes, function(notesindx, notesinfo) {                
            var pic = domain +'/fimages/inventee/png/placeholder.png';
            strhtml = strhtml.concat("<div class='box-comment' style='margin-bottom:3px;'>");
            strhtml = strhtml.concat("<div class='comment-text'>");
            strhtml = strhtml.concat("<a class='clickable viewnotecomment' id='"+data.notes[notesindx]['noteid']+"'><span style='margin-left:-30px;' class='aimslabel text-muted pull-left'>View Note Comments ("+data.notes[notesindx]['commentcount']+")</span></a>");
            strhtml = strhtml.concat("<span class='aimslabel text-muted pull-right'>"+data.notes[notesindx]['createdate']+"</span>");
            strhtml = strhtml.concat("</span></br>");
            strhtml = strhtml.concat("<p style='margin-left:-25px;' class='aimslabel'>"+data.notes[notesindx]['notes_body'].nl2br()+"</p>");
            strhtml = strhtml.concat("</div></div>");
        });//end each

        switch(type){
          case 'EDIT':
          $('.viewnotearea').append(strhtml);
          break;


          case 'VIEW':
          $('.noteviewingdiv').append(strhtml);
          break;

          case 'REFRESH':
          $('.noteviewingdiv').append(strhtml);
          $('.viewnotearea').append(strhtml);
          break;
        }//end type

        $('.btncalendar-viewnotes').text('View all Notes ('+data.notecount+')');
        $('.btncalendar-viewnotes2').text('View all Notes ('+data.notecount+')');
      }).fail(function (jqXHR, textStatus, error) {
        generateAlert('error','System Error: Status Code ' +jqXHR.status,'ERROR');
      }); //end ajax
}//end function


// WTODO JAD 06-03-2019
$(document).on('click','.btnschedlookup',debounce(function(){
  $('.overallsched-modulebody').html('');
  $('.overallscheduser, .txtdate2, .txtdate1, #useroxd').val('');
  var userid = $('#timeoxd2').val(),
      schedtype = $('.overalltype option:selected').text(),
      date1 = $('.txtdate1').val(),
      date2 = $('.txtdate2').val(),
      params = {userid:userid,schedtype:schedtype,date1:date1,date2:date2};
  $('#modal-calendar-schedulelookup').modal();
},300));


// WTODO JAD 06-03-2019
$(document).on('click','.btnfilterscheds',debounce(function(){
  var userid = $('#useroxd').val(),
      schedtype = $('.overalltype option:selected').text(),
      date1 = $('.txtdate1').val(),
      date2 = $('.txtdate2').val(),
      params = {userid:userid,schedtype:schedtype,date1:date1,date2:date2};
  $('.overallsched-modulebody').html('');
  retrieveAllSchedules(params,function(data){
    var strhtml = generatePlotString(data);
    $('.overallsched-modulebody').append(strhtml); 
  });
  $('#modal-calendar-schedulelookup').modal();
},300));


// WTODO JAD 06-03-2019
$(document).on('click','.btntimeinlist',debounce(function(){
  var userid = $('#userid').val(),
      timetype = $('.timeintype option:selected').text(),
      dateid = $('.txtdateid').val(),
      params = {userid:userid,timetype:timetype,dateid:dateid};
  retireveTimelogdata(params);
  $('#modal-calendar-timeinlist').modal();
},300));

$(document).on('click','.btnfiltertimein',debounce(function(){
  var userid = $('#timeoxd').val();
  var timetype = $('.timeintype option:selected').text();
  var dateid = $('.txtdateid').val();
  var params = {userid:userid,timetype:timetype,dateid:dateid};
  retireveTimelogdata(params);
  $('#modal-calendar-timeinlist').modal();
},300));

// WTODO JAD 06-03-2019
function retrieveAllSchedules(params,callback){
  $.get(domain+'/scheduler/retrieveoverallscheds',{userid:params['userid'],schedtype:params['schedtype'],date1:params['date1'],date2:params['date2']},
  function(data){
    var data = $.parseJSON(data);
    callback(data);  
  }).fail(function (jqXHR, textStatus, error) {
    generateAlert('error','System Error: Status Code ' +jqXHR.status,'ERROR');
  }); //end ajax
}//end function

$(document).on('click','.overallschedview',debounce(function(){
  var viewmode = $('#viewmode').val();
  switch(viewmode){
      case 'EDIT':
        var thisid = $(this).prop('id');
        var event_tit = $('#overallschedviewtitle-'+thisid).html();
        var param = {seq:thisid,event:event_tit};
        generateMessagebox("<b>("+event_tit+")</b></br><b>What do you want to do with this event?</b>","CALENDAR_MOD",param);
      break;

      case 'VIEW':
        var thisid = $(this).prop('id');
        var params = {seq:thisid};
        retrieveEventinfo(params);
      break;
  }
  
},300));

function retireveTimelogdata(params){
  $('.timein-modulebody').html('');
  var strhtml = '';
  $.get(domain+'/scheduler/retrievetimedata',{userid:params['userid'],timetype:params['timetype'],dateid:params['dateid']},
    function(data){ 
      var data = $.parseJSON(data);
      $.each(data.timedata, function(timeindex, timename) {
        strhtml = strhtml.concat('<tr>');
        strhtml = strhtml.concat('<td class="aimslabel">'+data.timedata[timeindex]['logid']+'</td>');
        strhtml = strhtml.concat('<td class="aimslabel">'+data.timedata[timeindex]['username']+'</td>');
        strhtml = strhtml.concat('<td class="aimslabel">'+data.timedata[timeindex]['name']+'</td>');
        strhtml = strhtml.concat('<td class="aimslabel">'+data.timedata[timeindex]['timein']+'</td>');
        strhtml = strhtml.concat('<td class="aimslabel">'+data.timedata[timeindex]['datelog']+'</td>');
        strhtml = strhtml.concat('</tr>');
      });//end each
      $('.timein-modulebody').append(strhtml);
  }).fail(function (jqXHR, textStatus, error) {
    generateAlert('error','System Error: Status Code ' +jqXHR.status,'ERROR');
  }); //end ajax
}//end function

function retrieveSchedulerNotifications(){
  $('.notifyme').html('');
  var strhtml = '';
  $.get(domain+'/scheduler/retrievenotifs',{},function(data){
    var data = $.parseJSON(data);
    $.each(data.notification, function(notifindex, notify) {
        strhtml = strhtml.concat('<div id="'+data.notification[notifindex]['sched_seq']+'~'+data.notification[notifindex]['notifid']+'" class="box-footer schedulernotif btn-info clickable box-comments" style="margin-bottom:3px;">');
        strhtml = strhtml.concat('<div class="box-comment">');
        strhtml = strhtml.concat('<p class="aimslabel" style="margin-left:8px;margin-top:0px;margin-bottom:-5px;">');
          switch(data.notification[notifindex]['notificationtype']){
            case 'THREAD_COMMENT':
              strhtml = strhtml.concat(data.notification[notifindex]['usertoview'] + ' has commennted on your schedule.');
            break;
          }//end switch
        strhtml = strhtml.concat('</p></div></div>');
    });//end each
    $('.notifyme').append(strhtml).fadeIn(100);
  }).fail(function (jqXHR, textStatus, error) {
    generateAlert('error','System Error: Status Code ' +jqXHR.status,'ERROR');
  }); //end ajax
}//end function

function updateNotification(notifid){
  $.get(domain+'/scheduler/updatenotifs',{notify:notifid},function(){
  }).fail(function (jqXHR, textStatus, error) {
    generateAlert('error','System Error: Status Code ' +jqXHR.status,'ERROR');
  }); //end ajax
}//end function

$(document).on('click','.btnschedulerlogs',function(){
  schedulerlogs();
});

function schedulerlogs(){
  $.get(domain+'/scheduler/schedulerlogs',{},function(data){
    var data = $.parseJSON(data);
    $('.tbl-modulelog').html("");
    $('#modal-modulelog').modal();
    $.each(data.logs, function(logindex,logininfo) {
      $('.tbl-modulelog').append('<tr> \
        <td style="margin-bottom:-5px;word-wrap:break-word;" id="stockbarcode" class="col-xs-3 aimslabelstock">'+data.logs[logindex]['username']+'</td> \
        <td style="margin-bottom:-5px;word-wrap:break-word;" id="stockisqty" class="col-xs-3 aimslabelstock">'+data.logs[logindex]['level']+'</td> \
        <td style="margin-bottom:-5px;word-wrap:break-word;" id="stockuom" class="col-xs-4 aimslabelstock">'+data.logs[logindex]['log_description']+'</td> \
        <td style="margin-bottom:-5px;word-wrap:break-word;" id="stockuom" class="col-xs-2 aimslabelstock">'+data.logs[logindex]['logdate']+'</td> \
        </tr>');
    });//end each
  }).fail(function (jqXHR, textStatus, error) {
    generateAlert('error','System Error: Status Code ' +jqXHR.status,'ERROR');
  }); //end ajax
}//END GETLOGS


function checkDragAvailability(object){
  if(object.hasClass('cancelled') || object.hasClass('finished')){
    return false;
  }else{
    return true;
  }//end if
}//end if

//##### RETRIEVES SCHEDULES BASED ON THE PASSED MONTH PARAMETER (NEXT AND PREV BUTTONS)
$(document).on('click','.fc-prev-button,.fc-next-button',function(){
    if($('#moduleview').val() == 'OWN'){
      var month = $('#calendar').fullCalendar('getDate').format('MM');
      retrieveSchedule(myuserid,month);
    }else{
      var month = $('#calendarothers').fullCalendar('getDate').format('MM');
      retrieveMemberSchedule('',month);
    }//end if
});


$(document).on('click','.btnmanageanon',debounce(function(){
  $('#modal-announcements').modal();
  retrieveAnnouncements();
},300));

$(document).on('click','.btnaddanon',debounce(function(){
  var temprow = tblanon.getTemprowIndex();
  tblanon.addNewRow('annontable',temprow);
  $('.dpYears').datepicker();
  $('.dpMonths').datepicker();
},300));

$(document).on('click','.saveanon',debounce(function(){
  var btnsave = $(this),
    parentrow = btnsave.parent().parent(),
    parentid = btnsave.parent().parent().attr('id'),
    coltype = '', vals = '', newrowid = '';
  if(parentrow.hasClass('temprow') || parentrow.hasClass('edited')) {
    var formval = $('#'+parentid+' .annontextbox').serializeArray();
    $.get(domain+'/scheduler/saveannon',formval,function(data){
      data = $.parseJSON(data);
      newrowid = 'gvrow-'+data[0].line;
      if(parentrow.hasClass('temprow')) {
        $('#'+parentid+'.temprow .annontextbox').each(function(){
          coltype = $(this).attr('coltype');
          vals = data[0][coltype];
          $(this).val(vals);
        });
        $('#'+parentid+'.temprow .gv-options').html(tblanon.availablebtns);
        $('#'+parentid+'.temprow').css('background',tblanon.savedrowcolor).attr('id',newrowid).removeClass();
        generateAlert('success','New Record Added','SUCCESS');
      } else {
        $('#'+parentid+'.edited .annontextbox').each(function(){
          coltype = $(this).attr('coltype');
          vals = data[0][coltype];
          $(this).val(vals);
        });
        $('#'+parentid+'.edited').css('background',tblanon.savedrowcolor).removeClass();
        generateAlert('success','Record Updated','SUCCESS');
      }
    }).fail(function (jqXHR, textStatus, error) {
      generateAlert('error','System Error: Status Code ' +jqXHR.status,'ERROR');
    }); //end ajax
  }
},300));


function retrieveAnnouncements(){
  tblanon = new GridViewGenerator(domain+'/scheduler/getannouncements','.announcementsdiv');
  tblanon.initializeGrid('');
}


$(document).on('click','.anoneditbtn',function(){
  var btnid = $(this).prop('id').split('-');
  var anonid = btnid[1];
  $('#anon-title').val('');
  $('#anon-desc').val('');
  $('.anondate1').val('');
  $('.anondate2').val('');
  $('#anonid').val('');
  $.get(domain+'/scheduler/getannouncementdetails',{xcode:anonid},function(data){
    var data = $.parseJSON(data);

      $('#anonid').val(anonid);
      $('#anon-title').val(data.details[0]['anon_title']);
      $('#anon-desc').val(data.details[0]['anon_desc']);
      $('.anondate1').val(data.details[0]['date1']);
      $('.anondate2').val(data.details[0]['date2']);

      $('.anonlisting').css('display','none');
      $('.anonform').css('display','block');
      $('.anondisable').css('display','none');
      $('.anonenable').css('display','block');  
  });//end ajax
  
});


$(document).on('click','.btnschedulerprojects',function(){
  $('.tbl-taggedscheds').html('');
  $('#modal-schedprojects').modal();
  retrieveProjects();
});

$(document).on('click','.sched-addprojectbtn',function(){
  $('#projectid').val('');
  $('.projtxt').prop('disabled',false);
  $('.txtprojectname').focus();
  loadAvailableEventtags();
  $('.schedaddproj').css('display','block');
  $('.schedprojlist').css('display','none');
  $('.sched-cancelprojectbtn').css('display','block');
  $('.sched-saveprojectbtn').css('display','block');
  $('.sched-addprojectbtn').css('display','none');
  $('.sched-editprojectbtn').css('display','none');
});


$(document).on('click','.sched-editprojectbtn',function(){
  $('.projtxt').prop('disabled',true);
  loadAvailableEventtags();
  $('.projectstatus').css('display','block');
  $('.schedaddproj').css('display','block');
  $('.schedprojlist').css('display','none');
  $('.sched-cancelprojectbtn').css('display','block');
  $('.sched-saveprojectbtn').css('display','block');
  $('.sched-addprojectbtn').css('display','none');
  $('.sched-editprojectbtn').css('display','none');
});

$(document).on('click','.sched-cancelprojectbtn',function(){
  $('.projtxt').prop('disabled',false);
  $('.schedaddproj').css('display','none');
  $('.projectstatus').css('display','none');
  $('.schedprojlist').css('display','block');
  $('.sched-cancelprojectbtn').css('display','none');
  $('.sched-saveprojectbtn').css('display','none');
  $('.sched-addprojectbtn').css('display','block');
  $('.sched-editprojectbtn').css('display','block');
  $('#projectid').val('');
  $('.txtprojectname').val('')
  $('.txtprojectdesc').val('')
  $('.tbl-taggedscheds').html('');
  $('.sched-editprojectbtn').css('display','none');
});


$(document).on('click','.sched-saveprojectbtn',function(){
  var params = {title:$('.txtprojectname').val(),
                description:$('.txtprojectdesc').val(),
                status:$('#projectstatus option:selected').text(),
                projectid:$('#projectid').val()};
  if(params['title'] == ""){
    generateAlert('error','Project Title required. Please try again.','ERROR');
    $('.txtprojectname').focus();
  } else {
    saveProject(params);
  }//end param title
 
});

$(document).on('click','.schedproject',function(){
  var btnid = $(this).prop('id').split('~');
  $('#projectid').val(btnid[1]);
  $('.sched-editprojectbtn').css('display','block');
  retrieveProjectDetails(btnid[1]);
  $('.projtxt').prop('disabled',false);
  $('.schedaddproj').css('display','none');
  $('.projectstatus').css('display','none');
  $('.schedprojlist').css('display','block');
  $('.sched-cancelprojectbtn').css('display','none');
  $('.sched-saveprojectbtn').css('display','none');
  $('.sched-addprojectbtn').css('display','block');
  $('.sched-editprojectbtn').css('display','block')
});

function retrieveProjectDetails(projectid){
  $.get(domain+'/scheduler/retrieveprojectdetails',{prcode:projectid},function(data){
    var strhtml = "";
    data = $.parseJSON(data);
    $('#projectstatus').html('');
    $('.txtprojectname').val(data.projectdetails['project_title']);
    $('.txtprojectdesc').val(data.projectdetails['project_description']);
    $('.tbl-taggedscheds').html('');
    $('#projectstatus').append('<option>'+data.projectdetails['status']+'</option>');

    $.each(data.schedules, function(schedindex, sched) {

      switch(sched['event_tagging']){
        case 'ONGOING':
        strhtml = strhtml.concat('<tr class="bg-warning">');
        break;

        case 'CANCELLED':
        strhtml = strhtml.concat('<tr class="bg-danger">');
        break;

        case 'FINISHED':
        strhtml = strhtml.concat('<tr class="bg-success">');
        break;

        default:
        strhtml = strhtml.concat('<tr class="bg-grey">');
        break;
      }//end switch case
      strhtml = strhtml.concat('<td class="aimslabel col-min"><button id = "'+sched['sched_seq']+'" data-toggle="tooltip" title="Show Details" class="projectsched btn btn-social-icon btn-github" style="width:18px;height:18px;margin-top:-2px;"><i style="font-size:12px; margin-top:-8px;" class="fa fa-eye"></i></button></td>');
      strhtml = strhtml.concat('<td class="aimslabel col-codes">'+sched['username']+'</td>');
      strhtml = strhtml.concat('<td class="aimslabel col-description">'+sched['sched_desc']+'</td>');
      strhtml = strhtml.concat('<td class="aimslabel col-min">'+sched['event_tagging']+'</td>');
      strhtml = strhtml.concat('</tr>');
    });//end each
    $('.tbl-taggedscheds').append(strhtml);
  });
}//end function 

function saveProject(params){
  $.get(domain+'/scheduler/saveproject',{params:params},function(data){
    data = $.parseJSON(data);
    if(data.status){
      $('.projectstatus').css('display','none');
      $('.schedaddproj').css('display','none');
      $('.schedprojlist').css('display','block');
      $('.sched-cancelprojectbtn').css('display','none');
      $('.sched-saveprojectbtn').css('display','none');
      $('.sched-addprojectbtn').css('display','block');
      $('.sched-editprojectbtn').css('display','block');
      $('#projectid').val('');
      $('.txtprojectname').val('')
      $('.txtprojectdesc').val('')
      $('.tbl-taggedscheds').html('');
      $('.sched-editprojectbtn').css('display','none');
      retrieveProjects();
    }else{
      generateAlert('error',data.msg,'ERROR');
    }//end if data status
  });
}//end function save project

function retrieveProjects(){
  $.get(domain+'/scheduler/retrieveprojects',{},function(data){
    var strhtml = "";
    data = $.parseJSON(data);

    strhtml = strhtml.concat('<ul class="nav nav-pills nav-stacked">');
    
    $('.projectlist').html('');

    $.each(data.projects, function(prjindex, prj) {
        switch(prj['status']){
          case 'ONGOING':
          strhtml = strhtml.concat('<li id = "schedproject~'+prj['projectid']+'" class="bg-warning schedproject"><a href="#">'+prj['project_title']+'</a></li>');
          break;

          case 'CANCELLED':
          strhtml = strhtml.concat('<li id = "schedproject~'+prj['projectid']+'" class="bg-danger schedproject"><a href="#">'+prj['project_title']+'</a></li>');
          break;

          case 'FINISHED':
          strhtml = strhtml.concat('<li id = "schedproject~'+prj['projectid']+'" class="bg-success schedproject"><a href="#">'+prj['project_title']+'</a></li>');
          break;
        }//end switch
    });

    strhtml = strhtml.concat('</ul>');
    $('.projectlist').append(strhtml);
  });
}//END FUNCTION RETRIEVE ACTIVE PROJECTS


function retrieveActiveprojects(){
  $.get(domain+'/scheduler/retrieveactiveprojects',{},function(data){
    var strhtml = "";
    data = $.parseJSON(data);
    $('.tbl-projects').html('');
    $.each(data.projects, function(prjindex, prj) {
      /*switch(prj['status']){
        case 'ONGOING':
        strhtml = strhtml.concat('<tr class="bg-warning">');
        break;

        case 'CANCELLED':
        strhtml = strhtml.concat('<tr class="bg-danger">');
        break;

        case 'FINISHED':
        strhtml = strhtml.concat('<tr class="">');
        break;
      }//end switch case*/
      strhtml = strhtml.concat('<tr class="">');
      strhtml = strhtml.concat('<td class="aimslabel col-min"><button id = "'+prj['projectid']+'" class="pickproject btn btn-social-icon btn-github" style="width:18px;height:18px;margin-top:-2px;"><i style="font-size:12px; margin-top:-8px;" class="fa fa-sign-in"></i></button></td>');
      strhtml = strhtml.concat('<td class="aimslabel col-codes" id="projecttitle-'+prj['projectid']+'">'+prj['project_title']+'</td>');
      strhtml = strhtml.concat('<td class="aimslabel col-description">'+prj['status']+'</td>');
      strhtml = strhtml.concat('<td class="aimslabel col-min">'+prj['username']+'</td>');
      strhtml = strhtml.concat('</tr>');
    });//end each
    $('.tbl-projects').append(strhtml);
  });
}//end function retrieve active projects

$(document).on('click','.projectsched',function(){
  var viewmode = $('#viewmode').val('VIEW');
  var thisid = $(this).prop('id');
  var params = {seq:thisid};
  retrieveEventinfo(params);
});

$(document).on('click','.projectlookup',function(){
  retrieveActiveprojects();
  $('#modal-projects').modal();
  $('#modal-projects').css('z-index','10000');
}); 

$(document).on('click','.pickproject',function(){
  var thisid = $(this).prop('id');
  var txtvalue = $('#projecttitle-'+thisid).html();
  $('#projectidtag').val(thisid);
  $('#projectidtagupdate').val(thisid);
  $('.projectnametag').val(txtvalue);
  $('.projectnametagupdate').val(txtvalue);
  $('#modal-projects').modal('hide');
});

$(document).on('click','.viewnotecomment',function(){
$('#notecommentid').val($(this).prop('id'));
$('#modal-notecomment').modal();
$('#modal-notecomment').css('z-index','10001');
loadEventComments($(this).prop('id'),'NOTES');
}); 

$(document).on('click','.noteaddcomment',function(){
    var noteid = $('#notecommentid').val();
    var comment = $('.txtnotecomment').val();
    var userid = $('#prop_keyid').val();
    if(comment == ""){
      generateAlert('error','Please enter a valid comment.','ERROR');
    }else{
      addComment(noteid,comment,userid,'NOTES');
    }//end comment === ""
});


$(document).on('click','.schedreminders',function(){
  // $('#modal-calendar-reminder').modal();
  $('#modal-reminders').modal();
  retrieveReminders();
});

$(document).on('click','.btnaddreminder',debounce(function(){
  $('#reminderid').val('');
  $('#reminder-title').val('');
  $('#reminder-desc').val('');
  $('.reminderdate1').val('');
  $('.reminderdate2').val('');
  $('.reminderlisting').css('display','none');
  $('.reminderform').css('display','block');
  $('.reminderdisable').css('display','none');
  $('.reminderenable').css('display','block');
},300));  

$(document).on('click','.btncancelreminder',debounce(function(){
  $('#reminderid').val('');
  $('#reminder-title').val('');
  $('#reminder-desc').val('');
  $('.reminderdate1').val('');
  $('.reminderdate2').val('');
  $('.reminderlisting').css('display','block');
  $('.reminderform').css('display','none');
  $('.reminderdisable').css('display','inline');
  $('.reminderenable').css('display','none');
},300));

$(document).on('click','.btnsavereminder',debounce(function(){
  saveReminder();
},300));

function saveReminder(){
  var reminderid = $('#reminderid').val();
  var reminder_desc = $('#reminder-title').val();
  var reminder_details = $('#reminder-desc').val();
  var reminder_date1 = $('.reminderdate1').val();
  var reminder_date2 = $('.reminderdate2').val();

  $.get(domain+'/scheduler/managereminders',{farcode:reminderid,desc:reminder_desc,details:reminder_details,date1:reminder_date1,date2:reminder_date2},function(data){
    var data = $.parseJSON(data);
    
    if(data.status){
      generateAlert('information',data.msg,'DEFAULT');
        $('#reminderid').val('');
        $('#reminder-title-title').val('');
        $('#reminder-desc').val('');
        $('.reminder_date1').val('');
        $('.reminder_date2').val('');
      retrieveReminders();
    }else{
      generateAlert('error','<b>'+data.msg+'</b>','ERROR');
    }//end if status

    $('.reminderlisting').css('display','block');
    $('.reminderform').css('display','none');
    $('.reminderdisable').css('display','inline');
    $('.reminderenable').css('display','none');
  });//end ajax
}//end function

$(document).on('click','.savereminder',function(){
  var row = $(this).parent().parent().prop('id');
  if($(this).parent().parent().hasClass('temprow')) {
    var formvalues = $('#'+row+'.temprow .reminderstxt').serializeArray();
    $.get(domain+'/scheduler/savereminder',formvalues,function(data){
      var data = $.parseJSON(data);
      if(data.status) {
        generateAlert('information',data.msg,'DEFAULT');
        $('#'+row+' .gv-options').html(reminderslookup.availablebtns);
        $('#'+row+'.temprow').css('background',reminderslookup.savedrowcolor).removeClass();
      } else {
        generateAlert('error','<b>'+data.msg+'</b>','ERROR');
      }
    });
  }
  if($(this).parent().parent().hasClass('edited')) {
    var formvalues = $('#'+row+'.edited .reminderstxt').serializeArray();
    $.get(domain+'/scheduler/savereminder',formvalues,function(data){
      var data = $.parseJSON(data);
      if(data.status) {
        generateAlert('information',data.msg,'DEFAULT');
        $('#'+row+'.edited').css('background',reminderslookup.savedrowcolor).removeClass();
      } else {
        generateAlert('error','<b>'+data.msg+'</b>','ERROR');
      }
    });
  }
});

$(document).on('click','.btnnewreminder',function(){
  var row = reminderslookup.getTemprowIndex();
  reminderslookup.addNewRow('reminderslookup',row);
  $('.dpYears').datepicker();
  $('.dpMonths').datepicker();
});

function retrieveReminders(){
  reminderslookup = new GridViewGenerator(domain+'/scheduler/getreminder','.remindersdiv');
  reminderslookup.initializeGrid();
  // $('.reminder-modulebody').html("<img src='"+domain+"/backendassets/img/loading.gif' style='position:absolute;margin-left:45%;margin-top:15%;' width='5%'/>");
  // $.get(domain+'/scheduler/getreminder',{},function(data){
  //   var data = $.parseJSON(data);
  //   var strhtml = "";
  //   $('.reminder-modulebody').html('');
  //     $.each(data.reminders, function(reminderindex, reminder) {
  //       strhtml = strhtml.concat('<tr>');
  //       strhtml = strhtml.concat('<td class="col-min">');
  //       strhtml = strhtml.concat('<button id="remindereditbtn-'+reminder['reminderid']+'" class="remindereditbtn btn btn-social-icon btn-bitbucket" style="width:18px;height:18px;margin-top:-2px;"><i style="font-size:12px;margin-top:-8px;" class="fa fa-pencil"></i></button>&nbsp');
  //       strhtml = strhtml.concat('</td>');
  //       strhtml = strhtml.concat('<td class="aimslabel col-codes">'+reminder['createdby']+'</td>');
  //       strhtml = strhtml.concat('<td class="aimslabel col-description">'+reminder['title']+'</td>');
  //       strhtml = strhtml.concat('<td class="aimslabel col-description">'+reminder['date1']+' to '+reminder['date2']+'</td>');
  //       strhtml = strhtml.concat('<td class="aimslabel col-codes">'+reminder['createdate']+'</td>');
  //       strhtml = strhtml.concat('</tr>');
  //     });//end each
  //   $('.reminder-modulebody').append(strhtml);
  // });//end ajax
}//end function retrieve reminder

$(document).on('click','.remindereditbtn',function(){
  var btnid = $(this).prop('id').split('-');
  var reminderid = btnid[1];
  $('#reminder-title').val('');
  $('#reminder-desc').val('');
  $('.reminderdate1').val('');
  $('.reminderdate2').val('');
  $('#reminderid').val('');
  $.get(domain+'/scheduler/getreminderdetails',{xcode:reminderid},function(data){
    var data = $.parseJSON(data);

      $('#reminderid').val(reminderid);
      $('#reminder-title').val(data.details[0]['reminder_title']);
      $('#reminder-desc').val(data.details[0]['reminder_desc']);
      $('.reminderdate1').val(data.details[0]['date1']);
      $('.reminderdate2').val(data.details[0]['date2']);

      $('.reminderlisting').css('display','none');
      $('.reminderform').css('display','block');
      $('.reminderdisable').css('display','none');
      $('.reminderenable').css('display','block');  
  });//end ajax
  
});



// WTODO JAD 06-03-2019
$(document).on('click','.viewappreimb',debounce(function(){
  $('#modal-approvedreimbursements').modal().zIndex(99988);
  $('.dpYears').datepicker();
  $('.dpMonths').datepicker();
},300));

$(document).on('click','.btnviewappreimbeach',debounce(function(){
  var thisid = $(this).attr('sched_seq'),
      event_tit = $(this).attr('sched_desc'),
      param = {seq:thisid,event:event_tit,updateready:true};
  generateMessagebox("<b>("+event_tit+")</b></br><b>What do you want to do with this event?</b>","CALENDAR_MOD",param);
},300));

$(document).on('click','.btnviewappreimb',debounce(function(){
  var from = $('.txtappreimbfrom').val(),
      to = $('.txtappreimbto').val(),
      app = $('.cbxapproved').val(),
      addedparams = [];
  if(from != '' && to != '') {
    addedparams.push({name:'from',value:from});
    addedparams.push({name:'to',value:to});
    addedparams.push({name:'app',value:app});
    var appreimb = new GridViewGenerator(domain+'/scheduler/loadappreimb','.appreimbdiv');
    appreimb.initializeGrid('','',addedparams,true,function(data){
      $('.appreimbdiv').html(data);
      getReimbursetotal(from,to,app);
    });
  } else {
    generateAlert('error','Please enter date.','WARNING');
  }
},300));

function getReimbursetotal(from,to,app){
  $.get(domain+'/scheduler/getreimbutotal',{from:from,to:to,app:app},function(data){
      var data = $.parseJSON(data);
      $('.appreimbdiv').append('<br><br><div class="row"><div class="modal-body"><label class="pull-right">Total: '+$.number(data.total,2)+'</label></div></div>');
  }).fail(function (jqXHR, textStatus, error) {
    generateAlert('error','System Error: Status Code ' +jqXHR.status,'ERROR');
  }); //end ajax
}//end function


// WTODO JAD 06-03-2019
function generatePlotString(data){
    var strhtml = "";
    $.each(data.scheduledetails, function(schedindex, schedname) {
        if(data.scheduledetails[schedindex]['isplotted'] == 0){
          strhtml = strhtml.concat('<tr class="unplottedrow">');
        }else{
          switch(data.scheduledetails[schedindex]['event_tagging']){
            case 'ONGOING':
            strhtml = strhtml.concat('<tr class="ongoingrow">');
            break;

            case 'CANCELLED':
            strhtml = strhtml.concat('<tr class="cancelledrow">');
            break;

            case 'FINISHED':
            strhtml = strhtml.concat('<tr class="finishedrow">');
            break;
          }//end switch
        }//end if
        strhtml = strhtml.concat('<td class="aimslabel col-min"><button id="'+data.scheduledetails[schedindex]['sched_seq']+'" class="overallschedview btn btn-social-icon btn-github" style="width:60px;height:18px;margin-top:-2px;"><span style="font-size:12px;margin-top:-10px;font-weight:bold;">View</span></button></td>');
        strhtml = strhtml.concat('<td class="aimslabel col-codes">'+data.scheduledetails[schedindex]['username']+'</td>');
        strhtml = strhtml.concat('<td class="aimslabel col-description">'+data.scheduledetails[schedindex]['clientname']+'</td>');
        strhtml = strhtml.concat('<td id="overallschedviewtitle-'+data.scheduledetails[schedindex]['sched_seq']+'" class="aimslabel col-description">'+data.scheduledetails[schedindex]['sched_desc']+'</td>');
        strhtml = strhtml.concat('<td class="aimslabel col-codes">'+data.scheduledetails[schedindex]['date1']+'</td>');
        strhtml = strhtml.concat('<td class="aimslabel col-codes">'+data.scheduledetails[schedindex]['date2']+'</td>');
        strhtml = strhtml.concat('<td class="aimslabel col-codes">'+data.scheduledetails[schedindex]['createdate']+'</td>');
        if(data.scheduledetails[schedindex]['isplotted'] == 1){
          strhtml = strhtml.concat('<td class="aimslabel col-codes">'+data.scheduledetails[schedindex]['event_tagging']+'</td>');
        }else{
          strhtml = strhtml.concat('<td class="aimslabel col-codes">UNPLOTTED</td>');
        }//end if
        strhtml = strhtml.concat('</tr>');
      });//end each

    return strhtml;
}//end function