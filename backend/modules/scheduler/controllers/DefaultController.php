<?php

namespace backend\modules\scheduler\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\Url;
use app\models\Client;
use yii\base\ErrorException;

class DefaultController extends Controller{


    public $access = array('view' => 22);

    //TO TURN OFF CSRFVALIDATION [SO WE CAN USE AJAX]
    public function beforeAction($action){
        Yii::$app->request->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    //FOR INDEX LOADING OF DATA
    public function actionIndex(){   
        if(!Yii::$app->sbccontroller->verifyuser()){
            return Yii::$app->getResponse()->redirect(Url::to(['/admin/default/login']));
        }else{
            $moduleid = $this->module->id;
            Yii::$app->view->params['moduleid'] = $moduleid;
            $this->layout = "@app/views/layouts/backend/main";
            $userid = Yii::$app->session['loggeduser']['userid'];
            $hastimedin = Yii::$app->backend->memberHasTimeinToday();
            $unplotted = Yii::$app->backend->retrieveUnplottedschedules($userid);
            return $this->render('mycalendar',array('moduleid'=>$moduleid,'unplotted'=>$unplotted,'hastimedin'=>$hastimedin));
        }//end if is logged
    }

    public function actionSchedules(){
        $moduleid = $this->module->id;
        Yii::$app->view->params['moduleid'] = $moduleid;
        $this->layout = "@app/views/layouts/backend/main";
        return $this->render('schedules',array('moduleid'=>$moduleid));
    }//end my calendar

    public function actionRetrieveschedules(){
        $userid = $_POST['id'];
        $month = $_POST['m'];
        $schedules = Yii::$app->backend->retrieveSchedules($userid,$month);
        echo json_encode(array('schedules'=>$schedules));
    }//end function 


    //WTODO JAD 06-03-2019
    public function actionInsertevent(){
        try {
            $description = $_GET['description'];
            $type = $_GET['type'];
            $rem = $_GET['rem'];
            $time = $_GET['time'];
            $loc = $_GET['loc'];
            $prj = $_GET['prj'];
            $jo= $_GET['jo'];
            $eventsched = $_GET['eventshed'];
            $ccid = Yii::$app->backend->requestClientid($_GET['ccode']);
            $userid = Yii::$app->session['loggeduser']['userid'];
            Yii::$app->systemsettings->setDefaultTimeZone();
            $createdate = date("Y-m-d H:i:s A");
            $amt = 0;
            $schedid =  Yii::$app->sbccommon->exec_stored_procedure('CALL create_calendar_sched('.$userid.',"'.$description.'","'.$type.'",'.$ccid.',"'.$rem.'","'.$time.'","'.$loc.'","'.$prj.'","'.$jo.'","'.$createdate.'","'.$amt.'","'.$eventsched.'",@trno)','@trno');
            $updateqry = 'update member_schedule set sched_seq = "'.$userid.'-'.$schedid.'" where sched_id = '.$schedid.'';
            $status =  Yii::$app->sbccommon->execqry($updateqry);
            if($status) { Yii::$app->backend->setSchedulerLog('ADDED NEW EVENT => '.$description); }
            echo json_encode(array('status'=>$status,'seq'=>$userid . '-'.$schedid));
        } catch (ErrorException $e) {
            echo $e;
        }
    }//end aciton

    public function actionUpdateevent(){
        try {
            $logstring = "";
            $client = new Client;
            $params = Yii::$app->backend->sanitize($_POST['params'],'ARRAY');
            $seq = $_POST['seq'];
            $type = $_POST['type'];
            $eventdata = Yii::$app->backend->retrieveSchedInfo($seq);
            if($type == "PLOTTING"){
                $startdate = $params['startdate'];
                $enddate = $params['enddate'];
                $qry = "update member_schedule set date1 = '".$startdate."' , date2 = '".$enddate."', isplotted = 1,event_tagging = 'ONGOING'
                where sched_seq = '".$seq."'";    
                $logstring = "[".$eventdata[0]['sched_desc']."] UPDATED DATES: DATE1 to " .$startdate . " ~ DATE2 to ". $enddate;
            } else {
                $seqarray = explode('-', $seq);
                $schedid = $seqarray[1];
                $tagging = $params['tagging'];
                $time = $params['time'];
                $loc = $params['loc'];
                $title = $params['title'];
                $prj = $params['prj'];
                $jo = $params['jo'];
                $eventsched = $params['eventsched'];
                $clientid = Yii::$app->backend->requestClientid($params['client']);
                $amt = $params['amt'];
                $logloc = "[".$eventdata[0]['sched_desc']."] UPDATED LOCATION to " .$loc;
                $logtime = "[".$eventdata[0]['sched_desc']."] UPDATED TIME to " .$time;
                $logstatus = "[".$eventdata[0]['sched_desc']."] UPDATED STATUS to " .$tagging;
                $logclient = "[".$eventdata[0]['sched_desc']."] UPDATED CUSTOMER to " .$client->getclient($clientid);
                $logjo = "[".$eventdata[0]['sched_desc']."] UPDATED JO # to " .$jo;
                $logamt = "[".$eventdata[0]['sched_desc']."] UPDATED AMOUNT to ".$amt;

                $logeventshed = "[".$eventdata[0]['sched_desc']."] UPDATED SCHEDULE TYPE to ".$eventsched;

                $logstring = array(/*$logtitle,*/$logloc,$logtime,$logstatus,$logclient,$logjo,$amt,$logeventshed);
                $qry = "update member_schedule set sched_desc = '".$title."',starttime = '".$time."',loc = '".$loc."',
                event_tagging = '".$tagging."',clientid = ".$clientid.",jonumber = '".$jo."',
                project_tagging = ".$prj.", amt = ".$amt.",schedtype='".$eventsched."' where sched_seq = '".$seq."'";
                //END ALVIN 12.05.2018
            }//end if
        } catch (ErrorException $e) {
            echo $e;
            return 0;
        }//end try

        $preveventdata = Yii::$app->backend->retrieveSchedInfo($seq);
        if(isset($prj)){
            if ($preveventdata[0]['project_tagging'] != $prj) {
                if (Yii::$app->backend->countEventComments($schedid) != 0 && $eventdata[0]['project_tagging'] != 0 || Yii::$app->backend->countEventNotes($schedid) != 0 && $eventdata[0]['project_tagging'] != 0) {
                    $msg = "Cannot transfer this schedule to another project. Please check comment and note counts.";
                    $status = 0;
                }else{
                    $status =  Yii::$app->sbccommon->execqry($qry);
                    $msg = "";    
                }//end if comment and event counting
            }else{
                $status =  Yii::$app->sbccommon->execqry($qry);
                $msg = "";
            }//end if project_tagging == 
        }else{
            $status =  Yii::$app->sbccommon->execqry($qry);
            $msg = "";
        }//end if isset prj
        
        if($status){
            if(is_array($logstring)){
                foreach ($logstring as $key => $value) {
                    Yii::$app->backend->setSchedulerLog($value);
                }//end for each
            }else{
                Yii::$app->backend->setSchedulerLog($logstring);
            }//end if is_array
        }else{
            if(!isset($msg)){
                $msg = "Error updating schedule , Please refresh the page.";
            }//end if msg isset
        }//end if stataus is success
        echo json_encode(array('status'=>$status,'msg'=>$msg));
    }//end updateevent

    public function actionDeleteevent(){
        $seq = $_POST['seq'];
        $month = $_POST['m'];
        $qry = "delete from member_schedule where sched_seq = '".$seq."'";
        $eventdata = Yii::$app->backend->retrieveSchedInfo($seq);
        $status =  Yii::$app->sbccommon->execqry($qry);
        if($status){
            $qrydeletecomments = "delete from event_comments where eventid = ".$eventdata[0]['sched_id']."";
            $qrydeletenotes = "delete from schedule_notes where eventid = ".$eventdata[0]['sched_id']."";
            Yii::$app->sbccommon->execqry($qrydeletecomments);
            Yii::$app->sbccommon->execqry($qrydeletenotes);
            $unplotted = Yii::$app->backend->retrieveUnplottedschedules(Yii::$app->session['loggeduser']['userid']);
            $plotted = Yii::$app->backend->retrieveSchedules(Yii::$app->session['loggeduser']['userid'],$month);
            $msg = "";
            Yii::$app->backend->setSchedulerLog('DELETED EVENT => ' . $eventdata[0]['sched_desc']);
        }else{
            $unplotted = "";    
            $plotted = "";
            $msg = "Error deleting schedule. please try again.";
        }//end status
        echo json_encode(array('status'=>$status,'msg'=>$msg,'unplotted'=>$unplotted,'plotted'=>$plotted));
    }//end updateevent

    public function actionUnpinevent(){
        $seq = $_POST['seq'];
        $month = $_POST['m'];
        $eventdata = Yii::$app->backend->retrieveSchedInfo($seq);
        $qry = "update member_schedule set date1 = '0000-00-00' , date2 = '0000-00-00', isplotted = 0 , event_tagging = ''
        where sched_seq = '".$seq."'";
        $status =  Yii::$app->sbccommon->execqry($qry);
        if($status){
            $unplotted = Yii::$app->backend->retrieveUnplottedschedules(Yii::$app->session['loggeduser']['userid']);
            $plotted = Yii::$app->backend->retrieveSchedules(Yii::$app->session['loggeduser']['userid'],$month);
            $msg = "";
            Yii::$app->backend->setSchedulerLog('UNPINNED EVENT => '. $eventdata[0]['sched_desc']);
        }else{
            $unplotted = "";    
            $plotted= "";
            $msg = "Error unpinning schedules. please try again.";
        }//end status
        echo json_encode(array('status'=>$status,'msg'=>$msg,'unplotted'=>$unplotted,'plotted'=>$plotted));
    }//end updateevent

    public function actionClientlookupsearch() {
        Yii::$app->backend->AjaxVerification($this);
        $params = $_POST;
        $params['controller'] = $this;
        return Yii::$app->automator->automateClientlookup($params);
    }

      //USED BY SEARCHING OF CUSTOMER ON MODAL GENERATED BY LOOKUP BUTTON
    public function actionCustomerlookupsearch(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_GET;        
        $return=Yii::$app->sbccontroller->sbcSupplierlookupsearch($this,$params);  
        if($return['verifyuser']==1){
           return $this->redirect(Url::to(['/admin/default/login']));
        }elseif($return['verifyaccess']==1){
           return $this->redirect(Url::to(['/admin/default/401']));
        }else{
           echo json_encode(array('searchclient' => $return['data']));
        }                                       
    }

    public function actionGetclientinfo(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $_GET;
        $return=Yii::$app->sbccontroller->sbcGetclientinfo($this,$params);  
        if($return['verifyuser']==1){
           return $this->redirect(Url::to(['/admin/default/login']));
        }elseif($return['verifyaccess']==1){
           return $this->redirect(Url::to(['/admin/default/showmsg']));
        }else{
          echo json_encode(array('clientdata' => $return['data']));
        }               
    }    

    public function actionRetrieveeventinfo(){
        Yii::$app->backend->AjaxVerification($this);
        $seq = Yii::$app->backend->sanitize($_GET['seq'],'DEFAULT');
        $return = Yii::$app->backend->retrieveSchedInfo($seq);
        $return[0]['commentcount'] = Yii::$app->backend->countEventComments($return[0]['sched_id']);
        $return[0]['notecount'] = Yii::$app->backend->countEventNotes($return[0]['sched_id']);
        echo json_encode(array('schedinfo' => $return));
    }//end action

    public function actionMemberschedules(){
   try {
        Yii::$app->backend->AjaxVerification($this);
        $userid = $_POST['userid'];
        $month = $_POST['m'];
        $memberschedule = Yii::$app->backend->retrieveMemberSchedule($userid,$month);
        $unfinished = Yii::$app->backend->retrieveUnfinishedScheds($userid); 
        $unplotted = Yii::$app->backend->retrieveUnplottedschedules($userid);
        echo json_encode(array('memberschedule' => $memberschedule,'unfinished'=>$unfinished,'unplotted'=>$unplotted));
    } catch (ErrorException $e) {
        echo $e;
    }
    }//end action

    public function actionGetusers() {
        Yii::$app->backend->AjaxVerification($this);
        return Yii::$app->automator->automateUsers();
    }

    public function actionGetuser(){
        Yii::$app->backend->AjaxVerification($this);
        $data = Yii::$app->backend->getUsers(); 
        echo json_encode(array('uzer'=>$data));
    }//end action

    public function actionAddcomment(){
        Yii::$app->backend->AjaxVerification($this);
        $comment = Yii::$app->backend->sanitize($_GET['comment'],'DEFAULT');
        $type = Yii::$app->backend->sanitize($_GET['type'],'DEFAULT');
        $ownerid = Yii::$app->backend->sanitize($_GET['xcom'],'DEFAULT');        
        $key = Yii::$app->backend->sanitize($_GET['primary'],'DEFAULT');

        switch ($type) {
            case 'EVENT':
                $qry = "insert into event_comments (eventid,userid,comment,createdate)
                values(".$key.",".Yii::$app->session['loggeduser']['userid'].",'".$comment."',CURRENT_TIMESTAMP)";
                break;
            
            case 'NOTES':
                $qry = "insert into notes_comments (noteid,userid,comment,createdate)
                values(".$key.",".Yii::$app->session['loggeduser']['userid'].",'".$comment."',CURRENT_TIMESTAMP)";
                break;
        }//end switch case 


        $status =  Yii::$app->sbccommon->execqry($qry);
        $commentcount = Yii::$app->backend->countEventComments($key);

        //$eventdata = Yii::$app->backend->retrieveSchedInfo($ownerid.'-'.$key);
       /* if($status){
            Yii::$app->backend->setSchedulerLog('ADDED COMMENT ON => '. $eventdata[0]['sched_desc']);
            //UPDATES ALL USER ON THE COMMENT THREAD TO ZERO
            $qryupdate ="update member_notification set isread = 0 where schedid = ".$key."";
            //CHECKS IF USER IS ON THE COMMENT THREAD
            $qrychecker = "select notifid from member_notification 
            where userid = ".Yii::$app->session['loggeduser']['userid']." and schedid=".$key."";
            $qrychecker2 = "select notifid from member_notification 
            where userid = ".$ownerid." and schedid=".$key."";
            
            $notifid = Yii::$app->sbccommon->datareader($qrychecker);
            $notifid2 = Yii::$app->sbccommon->datareader($qrychecker2);
            
            //DETERMINE WHETHER TO ADD A NEW USER TO THE THREAD OR 
            //UPDATE AND EXISTING NOTIFICATION

            if(empty($notifid)){
                $qrynotif = "insert into member_notification (schedid,userid,isread ,notificationtype,usertoview) 
                values(".$eventid.",".Yii::$app->session['loggeduser']['userid'].",1,
                'THREAD_COMMENT',".Yii::$app->session['loggeduser']['userid'].")";
            }else{
                $qrynotif = "update member_notification set isread = 1 where notifid = ".$notifid."";
            }//end function

            if(empty($notifid2)){
                $qrynotif2 = "insert into member_notification (schedid,userid,isread,notificationtype,usertoview) 
                values(".$eventid.",".$ownerid.",0,'THREAD_COMMENT',".Yii::$app->session['loggeduser']['userid'].")";
            }else{
                $qrynotif2 = "update member_notification set isread = 0 where notifid = ".$notifid."";
            }//end function
            
            //EXECUTES MEMBER NOTIFICATION UPDATE FOR ISREAD
            Yii::$app->sbccommon->execqry($qryupdate);
            //EXECUTES MEMBER NOTIFICATION INSERTION OR UPDATING OF THREAD
            Yii::$app->sbccommon->execqry($qrynotif);
            Yii::$app->sbccommon->execqry($qrynotif2);
        }//end if*/

        echo json_encode(array('status' =>$status,'commentcount'=>$commentcount));
    }//end

    public function actionRetrievecomments(){
        Yii::$app->backend->AjaxVerification($this);
        $key = Yii::$app->backend->sanitize($_GET['primary'],'DEFAULT');
        $type = Yii::$app->backend->sanitize($_GET['type'],'DEFAULT');

        switch ($type) {
            case 'EVENT':
                $qry = "select head.commentid,users.name,itimages.picture,head.comment,head.createdate from event_comments as head
                left join itimages on itimages.codeid = head.userid
                left join useraccess as users on users.userid = head.userid
                where eventid = ".$key." order by head.commentid desc";
                break;
            
            case 'NOTES':
                $qry = "select head.commentid,users.name,itimages.picture,head.comment,head.createdate,
                ifnull(projects.project_title,'NONE') as project_title,notes.notes_body
                from notes_comments as head
                left join schedule_notes as notes on notes.noteid = head.noteid
                left join member_schedule as scheduler on scheduler.sched_id = notes.schedid
                left join sched_projects as projects on projects.projectid  = scheduler.project_tagging
                left join itimages on itimages.codeid = head.userid
                left join useraccess as users on users.userid = head.userid
                where head.noteid = ".$key." order by head.commentid desc";
                break;

        }
        
        $comments = Yii::$app->sbccommon->opentable($qry);

        echo json_encode(array('comments' =>$comments));
    }//end


    public function actionFilteredschedules(){
        try {
            Yii::$app->backend->AjaxVerification($this);
            $type = Yii::$app->backend->sanitize($_GET['type'],'DEFAULT');
            $tagging = Yii::$app->backend->sanitize($_GET['tagging'],'DEFAULT');
            $searchstring = Yii::$app->backend->sanitize($_GET['searchstring'],'DEFAULT');
            $schedules = Yii::$app->backend->retrieveFilteredSchedules($tagging,$type,$searchstring);
            echo json_encode(array('schedules'=>$schedules));
        } catch (ErrorException $e) {
            echo $e;
        }
    }//end function 

    public function actionTimein(){
        Yii::$app->backend->AjaxVerification($this);
        $status = Yii::$app->backend->memberScheduleTimein();
        if($status){
            Yii::$app->backend->setSchedulerLog('TIMED IN');
            $msg = 'Time In Successfull!';
        }else{
            $msg = 'Error occured while timing in. Please try again!';
        }
        echo json_encode(array('status'=>$status,'msg'=>$msg));
    }//end action

    public function actionInsertnote(){
        Yii::$app->backend->AjaxVerification($this);
        $seq = Yii::$app->backend->sanitize($_GET['seq'],'DEFAULT');
        $note = Yii::$app->backend->sanitize($_GET['notes'],'DEFAULT');
        $eventdata = Yii::$app->backend->retrieveSchedInfo($seq);
        Yii::$app->backend->setSchedulerLog('ADDED NOTE ['.$eventdata[0]['sched_desc'].'] => ' . $note);
        $seqx = explode('-',$seq);
        $userid = $seqx[0];
        $schedid = $seqx[1];

        $qry = "insert into schedule_notes (schedid,userid,notes_body,createdate) values(".$schedid.",".$userid.",'".$note."',CURRENT_TIMESTAMP)";
        $status =  Yii::$app->sbccommon->execqry($qry);
        echo json_encode(array('status'=>$status));
    }//end action insert note

    public function actionRetrievenotes(){
        Yii::$app->backend->AjaxVerification($this);
        $seq = Yii::$app->backend->sanitize($_GET['seq'],'DEFAULT');
        $seqx = explode('-',$seq);
        $userid = $seqx[0];
        $schedid = $seqx[1];

        $qry2 = "select schedule_notes.notes_body,schedule_notes.noteid,schedule_notes.createdate,
        (select count(commentid) from notes_comments where notes_comments.noteid = schedule_notes.noteid) as commentcount
        from schedule_notes 
        where userid = ".$userid." and schedid =".$schedid."
        order by noteid desc";
        $notes = Yii::$app->sbccommon->opentable($qry2);
        $notecount = Yii::$app->backend->countEventNotes($schedid);
        echo json_encode(array('notes'=>$notes,'notecount'=>$notecount));
    }//end action retrieve notes

    public function actionRetrievetimedata(){
        Yii::$app->backend->AjaxVerification($this);
        $params = Yii::$app->backend->sanitize($_GET,'ARRAY');
        $timedata = Yii::$app->backend->retrieveTimeIn($params);
        echo json_encode(array('timedata'=>$timedata));
    }//end funciton

    public function actionRetrieveoverallscheds(){
        Yii::$app->backend->AjaxVerification($this);
        $params = Yii::$app->backend->sanitize($_GET,'ARRAY');
        $scheddata = Yii::$app->backend->getFilteredSchedules($params);
        echo json_encode(array('scheduledetails'=>$scheddata));
    }//end functions

    public function actionRetrievenotifs(){
        Yii::$app->backend->AjaxVerification($this);
        $notifs = Yii::$app->backend->retrieveSchedulerNotifications();
        echo json_encode(array('notification' => $notifs));
    }//end function

    public function actionUpdatenotifs(){
        Yii::$app->backend->AjaxVerification($this);
        $qry = "update member_notification set isread = 1 where notifid = ".$_GET['notify']."";
        Yii::$app->sbccommon->execqry($qry);
    }//end function

    public function actionSchedulerlogs(){
        Yii::$app->backend->AjaxVerification($this);
        $logs = Yii::$app->backend->getSchedulerLogs();
        echo json_encode(array('logs'=>$logs));
    }//end function

    //#### UPDATE ANNOUNCEMENTS
    public function actionGetannouncements(){
        Yii::$app->backend->AjaxVerification($this);
        return Yii::$app->automator->automateAnnouncements();
    }//end announcements

    public function actionSaveannon() {
        Yii::$app->backend->AjaxVerification($this);
        $params = Yii::$app->backend->sanitize($_GET,'ARRAY');
        $userid = Yii::$app->session['loggeduser']['userid'];
        if($params['anonid'] == 0) {
            $sql = "insert into scheduler_anon(anon_title, anon_desc, userid, date1, date2, createdate) values('{$params['title']}', '{$params['description']}', '$userid', '{$params['date1']}', '{$params['date2']}', '{$params['createdate']}')";
            Yii::$app->sbccommon->execqry($sql);
            $data = Yii::$app->sbccommon->opentable("select anon.anonid, anon.anon_title as title, anon.anon_desc as description, anon.userid, anon.date1, anon.date2, date(anon.createdate) as createdate, user.name as createdby from scheduler_anon as anon left join useraccess as user on user.userid = anon.userid order by anon.anonid desc limit 1");
        } else {
            $sql = "update scheduler_anon set anon_title = '{$params['title']}', anon_desc = '{$params['description']}', date1 = '{$params['date1']}', date2 = '{$params['date2']}' where anonid = '{$params['anonid']}'";
            Yii::$app->sbccommon->execqry($sql);
            $data = Yii::$app->sbccommon->opentable("select anon.anonid, anon.anon_title as title, anon.anon_desc as description, anon.userid, anon.date1, anon.date2, date(anon.createdate) as createdate, user.name as createdby from scheduler_anon as anon left join useraccess as user on user.userid = anon.userid where anon.anonid = '{$params['anonid']}'");
        }
        return json_encode($data);
    }

    public function actionSavereminder() {
        Yii::$app->backend->AjaxVerification($this);
        $params = Yii::$app->backend->sanitize($_GET,'ARRAY');
        if($params['reminderid'] == 0) {
            $qry = "insert into scheduler_reminder(reminder_title, reminder_desc, userid, date1, date2, createdate) values('{$params['title']}', '{$params['description']}', '{$params['userid']}', '{$params['date1']}', '{$params['date2']}', '{$params['createdate']}')";
        } else {
            $qry = "update scheduler_reminder set reminder_title = '{$params['title']}', reminder_desc = '{$params['description']}', date1 = '{$params['date1']}', date2 = '{$params['date2']}' where reminderid = '{$params['reminderid']}'";
        }
        $status = Yii::$app->sbccommon->execqry($qry);
        if($status) {
            $msg = "Saving Reminder Successfull!";
        } else {
            $msg = "Saving Reminder Failed!, Please try again.";
        }
        echo json_encode(array('status'=>$status,'msg'=>$msg));
    }

    //#### UPDATE ANNOUNCEMENTS
    public function actionGetreminder(){
        Yii::$app->backend->AjaxVerification($this);
        return Yii::$app->automator->automateReminders();
    }

    public function actionManageanon(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $seq = Yii::$app->backend->sanitize($_GET,'ARRAY');
        
        if($params['farcode'] != ""){
            $qry = "update scheduler_anon set anon_title = '".$params['desc']."',anon_desc = '".$params['details']."',
            date1 = '".$params['date1']."',date2 = '".$params['date2']."'
            where anonid = ".$params['farcode']."";
        }else{
            $qry = "insert into scheduler_anon (anon_title,anon_desc,userid,date1,date2,createdate)
                    values('".$params['desc']."','".$params['details']."',".Yii::$app->session['loggeduser']['userid'].",
                    '".$params['date1']."','".$params['date2']."',CURRENT_TIMESTAMP)";
        }//end if

        $status =  Yii::$app->sbccommon->execqry($qry);

        if($status){
            $msg = "Saving Announcement Successfull!";
        }else{
            $msg = "Saving Announcement Failed!, Please try again.";
        }//end if status

        echo json_encode(array('status'=>$status,'msg'=>$msg));
    }//end announcements

    public function actionManagereminders(){
        Yii::$app->backend->AjaxVerification($this);
        $params = $seq = Yii::$app->backend->sanitize($_GET,'ARRAY');
        
        if($params['farcode'] != ""){
            $qry = "update scheduler_reminder set reminder_title = '".$params['desc']."',reminder_desc = '".$params['details']."',
            date1 = '".$params['date1']."',date2 = '".$params['date2']."'
            where reminderid = ".$params['farcode']."";
        }else{
            $qry = "insert into scheduler_reminder (reminder_title,reminder_desc,userid,date1,date2,createdate)
                    values('".$params['desc']."','".$params['details']."',".Yii::$app->session['loggeduser']['userid'].",
                    '".$params['date1']."','".$params['date2']."',CURRENT_TIMESTAMP)";
        }//end if

        $status =  Yii::$app->sbccommon->execqry($qry);

        if($status){
            $msg = "Saving Reminder Successfull!";
        }else{
            $msg = "Saving Reminder Failed!, Please try again.";
        }//end if status

        echo json_encode(array('status'=>$status,'msg'=>$msg));
    }//end announcements

    public function actionGetdatedannouncements(){
        $announcements = Yii::$app->backend->getActiveAnnouncement();
        echo json_encode(array('announcements'=>$announcements));
    }//end action getdated announcements

    public function actionGetdatedreminders(){
        $reminders = Yii::$app->backend->getActiveReminders();
        echo json_encode(array('reminders'=>$reminders));
    }//end action getdated announcements

    public function actionGetannouncementdetails(){
        $anonid = $_GET['xcode'];
        $qry = "select anon_title,anon_desc,userid,date1,date2 from scheduler_anon where anonid = ".$anonid."";
        $data = Yii::$app->sbccommon->opentable($qry);
        echo json_encode(array('details'=>$data));
    }//end action getdated announcements
    //#### END UPDATE ANNOUNEMENTS

    public function actionGetreminderdetails(){
        $reminderid = $_GET['xcode'];
        $qry = "select reminder_title,reminder_desc,userid,date1,date2 from scheduler_reminder where reminderid = ".$reminderid."";
        $data = Yii::$app->sbccommon->opentable($qry);
        echo json_encode(array('details'=>$data));
    }//end action getdated announcements
    //#### END UPDATE ANNOUNEMENTS

    public function actionSaveproject(){
        $params = Yii::$app->backend->sanitize($_GET['params'],'ARRAY');
        if(empty($params['projectid'])){
            $qry = "insert into sched_projects (project_title,project_description,status,createdate,createdby)
                values('".$params['title']."','".$params['description']."','".$params['status']."',
                CURRENT_TIMESTAMP,".Yii::$app->session['loggeduser']['userid'].")";
        }else{
            $qry = "update sched_projects set project_title = '".$params['title']."',
                    project_description = '".$params['description']."' ,status = '".$params['status']."'
                    where projectid = ".$params['projectid']."";
        }//end if empty($params['projectid'])
        
      
        if($params['status'] == "FINISHED"){
            if(Yii::$app->backend->checkOngoingSchedule($params['projectid']) > 0){
                $status = 0;
                $msg = "Cannot tag this project as FINISHED. There are still unfinished schedules.";
            }else{
                $status = Yii::$app->sbccommon->execqry($qry);
            }//end if checkOngoingSchedule
        }else{
            $status = Yii::$app->sbccommon->execqry($qry);
        }//end if

        if($status){
            if(empty($params['projectid'])){
                $msg = "Successfully added new Project!";
            }else{
                $msg = "Successfully Project details!";
            }//end if
        }else{
            if(!isset($msg)){
                $msg = "Error occured , Please try again!";
            }//end if isset $msg
        }//end if
        echo json_encode(array('msg'=>$msg,'status'=>$status));
    }//end action save projects

    public function actionRetrieveprojects(){
        $qry = "select projects.project_title, projects.projectid, projects.status
        FROM member_schedule AS scheduler
        LEFT JOIN sched_projects AS projects ON projects.projectid = scheduler.project_tagging
        WHERE scheduler.userid =".Yii::$app->session['loggeduser']['userid']."
        AND scheduler.project_tagging <> 0
        group by projects.projectid";
        $prj = Yii::$app->sbccommon->opentable($qry);
        echo json_encode(array('projects'=>$prj));
    }//end action retrieve projects

     public function actionRetrieveactiveprojects(){
        $qry = "select project_title,projectid,status,username from (
                select '' as project_title,'' as projectid,'' as status,'' as username
                union all
                select sched_projects.project_title,sched_projects.projectid,sched_projects.status,user.username from sched_projects
                left join useraccess as user on user.userid = sched_projects.createdby
                where sched_projects.status = 'ONGOING') as tbl order by project_title";
        $prj = Yii::$app->sbccommon->opentable($qry);
        echo json_encode(array('projects'=>$prj));
    }//end action retrieve projects

    public function actionRetrieveprojectdetails(){
        $projectid = Yii::$app->backend->sanitize($_GET['prcode'],'DEFAULT');
        $qry = "select project_title,projectid,status,project_description from sched_projects where projectid = ".$projectid."";
        $qry2 = "select user.username,scheduler.userid,scheduler.sched_id,scheduler.sched_desc,
                scheduler.date1,scheduler.date2,scheduler.clientid,
                customer.clientname,scheduler.event_tagging,scheduler.sched_seq
                from member_schedule as scheduler
                left join useraccess as user on user.userid = scheduler.userid
                left join client as customer on customer.clientid = scheduler.clientid
                where project_tagging = ".$projectid."";
        $details = Yii::$app->sbccommon->opentable($qry);
        $schedules = Yii::$app->sbccommon->opentable($qry2);

        if(!empty($details)){
            $details = $details[0];
        }else{
            $details = "";
        }//end if

        /*if(!empty($schedules)){
            $schedules = $schedules[0];
        }else{
            $schedules = "";
        }//end if*/
        echo json_encode(array('projectdetails'=>$details,'schedules'=>$schedules));
    }//end function retrieve prjectdetails
    
    public function actionScheduledusers(){
        Yii::$app->backend->AjaxVerification($this);
        $params = Yii::$app->backend->sanitize($_GET,'ARRAY');
        $qry = "select useraccess.username,useraccess.userid from member_schedule
                left join useraccess on useraccess.userid = member_schedule.userid
                where (date1 = '".$params['date1']."' and date2 > '".$params['date1']."') 
                or (date1 = '".$params['date1']."') group by useraccess.userid";

        $users = Yii::$app->sbccommon->opentable($qry);
        echo json_encode(['users'=>$users]);
    }//end function


    public function actionLoadappreimb() {
        $type = 'scheduler';
        $params['from'] = $_POST['from'];
        $params['to'] = $_POST['to'];
        $params['app'] = $_POST['app'];
        $sql = Yii::$app->backend->retrieveVoucherRelease($params,$type);
        $params = [
            'sql' => $sql,
            'tableid' => 'appreimbgrid',
            'key' => 'sched_id',
            'txtclass' => 'bodytextbox',
            'template'=> ['checkbox','buttons','columns'],
            'actionheader'=>'&nbsp&nbsp&nbsp&nbsp&nbsp&nbspOptions&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp',
            'column' => [
                [
                    'name' => 'date1',
                    'label' => 'Start Date',
                    'class'=>'col-codes',
                ],[
                    'name' => 'date2',
                    'label' => 'End Date',
                    'class'=>'col-codes',
                ],[
                    'name' => 'amt',
                    'label' => 'Amount',
                    'class' => 'col-currency'
                ],[
                    'name' => 'clientname',
                    'label' => 'Client',
                    'class' => 'col-description'
                ],[
                    'name' => 'username',
                    'label' => 'User',
                    'class' => 'col-codes'
                ],[
                    'name' => 'sched_desc',
                    'label' => 'Description',
                    'class' => 'col-description'
                ],[
                    'name' => 'approvedby',
                    'label' => 'Approved By',
                    'class' => 'col-codes'
                ],[
                    'name' => 'approvedate',
                    'label' => 'Approved Date',
                    'class' => 'col-codes'
                ],[
                    'name' => 'cutdate',
                    'label' => 'Cut Date',
                    'class' => 'col-codes'
                ],[
                    'name' => 'apvdoc',
                    'label' => 'APV Document',
                    'class' => 'col-codes'
                ],[
                    'name' => 'sched_id',
                    'hidden' => true,
                    'default'=>'0',
                ]
            ],
            'buttons' => [
                [
                    'name' => '',
                    'caption' => '<i class="fa fa-pencil" style="font-size:12px;margin-top:-8px;"></i>',
                    'style' => 'width:18px;height:18px;margin-left:2px;margin-right:2px;',
                    'class' => 'btnviewappreimbeach gvbtns btn btn-social-icon btn-bitbucket',
                    'attributes' => [['name'=>'sched_id','value'=>'sched_id'],['name'=>'sched_desc','value'=>'sched_desc'],['name'=>'sched_seq','value'=>'sched_seq']]
                ],
            ]
        ];
        
        return Yii::$app->tblgenerator->generateGrid($params);
    }//end if


    public function actionGetreimbutotal(){
        $type = 'scheduler';
        $params['from'] = $_GET['from'];
        $params['to'] = $_GET['to'];
        $params['app'] = $_GET['app'];
       
        $total = Yii::$app->backend->retrieveVoucherReleaseTotal($params,$type);
        echo json_encode(['total'=>$total]);
    }//end f

}//end controller