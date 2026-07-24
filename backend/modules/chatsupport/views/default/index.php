<?php
$this->title = "Chat Support Module";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <!-- This file has been downloaded from Bootsnipp.com. Enjoy! -->
    <title>Chat Whatsapp - Bootsnipp.com</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
    <style type="text/css">
        /*********** BODY **************/
/* Change Body Attributes */
html, body {
    font-family: 'Open Sans', serif;
    background-color: blanchedalmond;
    height: 100%;
}
.fill {
    height: 100%;
    padding-bottom: 5%;
}


/******************** MAIN WRAPPERS *******************/
/* Main Window - Boxed style */
.chat-wrap {
    height: 100%;
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
    background-color: white;
    overflow: hidden;
}
/* Panel Wrapper: Side Menu - Content Window */
.panel-wrap {
    height: 100%;
    padding: 0;
}
/* Section Wrapper: Conversations - Contacts - Messages - Details */
.section-wrap {
    height: 100%;
}
/* Header Wrapper */
.header-wrap {
    height: 10%;
}
/* Content Wrapper */
.content-wrap {
    height: 90%;
    overflow: auto;
}
/* Messages Wrapper */
.content-wrap.messages {
    height: 75%;
}
/* Message Text Wrapper */
.send-wrap {
    height: 15%;
}


/**************** HEADER ****************/
/* Header Item */
.chat-header {
    height: 100%;
    width: 100%;

    background: deepskyblue;
    box-shadow: 0 1px 1px;

    display: table;
}
/* Header Title */
.chat-header h4 {
    display: table-cell;
    vertical-align: middle;

    width: 90%;
}
/* Header Button */
.header-button {
    display: table-cell;
    vertical-align: middle;
    color: #333;
}
/* Header Properties */
.header-button a {
    padding: 0;
}
.chat-header .btn:hover {
    transition: color 0.5s ease;
    color: #333;
}


/************* CONVERSATIONS *************/
/* Conversation Item */
.conversation {
    text-align: left;
    padding: 8px 10px 5px;
    border-bottom: 1px solid #ddd;
    width: 100%;

    transition: background-color 0.5s ease;
}
/* Conversation Properties */
.conversation:hover {
     background-color: whitesmoke;
}

/******************* CONTACTS ***************/
/* Contact Item */
.contact {
    padding: 21px 10px 12px;
    border-bottom: 1px solid #ddd;
    width: 100%;
    display: inline-block;

    transition: background-color 0.5s ease;
}
/* Contact Properties */
.contact.btn:hover {
    background-color: whitesmoke;
}

/**************** MESSAGES *****************/
/* Message Item */
.msg
{
    padding: 8px 10px 5px;
    border-bottom: 1px solid #ddd;
}
/* Message Sender */
.message-wrap .media-heading
{
    color: #2285b3;
    font-weight: 700;
}
/* Message Time */
.time
{
    color:#bfbfbf;
}


/*************** SEND MESSAGE **********************/
/* Send Message Item */
.send-message {
    width: 100%;
    height: 100%;

    background-color: whitesmoke;
    box-shadow: 0 -1px 1px;

    display: table;
}
/* Message Text */
.message-text
{
    padding: 2px;
    display: table-cell;
    vertical-align: middle;
}
/* Send Button */
.send-button
{
    display: table-cell;
    vertical-align: middle;
    text-align: center;

    width: 10%;
}
/* Send Message Properties */
.no-resize-bar
{
    resize: none;
    height: 100% !important;
}
.send-button a {
    padding: 0;
}
.send-message .btn:hover {
    transition: color 0.5s ease;
    color: #0451b7;
}



/*************** OTHER ********************/
/* Remove Bootstrap Button Effect */
.btn.active, .btn:active {
    -webkit-box-shadow: none;
    box-shadow: none;
}

/* Fix Bootstrap Media Body Display */
/* For Conversations and Contacts */
.conversation .media-body, .contact .media-body {
    display: block;
    width: 100%;
}

.container{
    width:100%;
}/*end function*/

.mechatname{
    font-weight: bold;
    margin-right: 5%;
}

.notmechatname{
    font-weight: bold;
}

.prevconvoname{
    font-weight: bold;
}

/* Animate Side Information Menu */
#Messages {
    -webkit-transition: width 0.15s ease, margin 0.15s ease;
    -moz-transition: width 0.15s ease, margin 0.15s ease;
    -o-transition: width 0.15s ease, margin 0.15s ease;
    transition: width 0.15s ease, margin 0.15s ease;
}

/* Scrollbar Attributes */
body::-webkit-scrollbar {
    width: 12px;
}
::-webkit-scrollbar {
    width: 6px;
}
::-webkit-scrollbar-track {
    -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
}
::-webkit-scrollbar-thumb {
    background:#ddd;
    -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.5);
}
</style>

    
<script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
</head>
<body>
<!--3rd Party Fonts & Icons-->
<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Open+Sans"/>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">

<div class="container fill">
    <div class="row chat-wrap">

        <!-- Contacts & Conversations -->
        <div class="col-sm-3 panel-wrap">
            <!--Left Menu / Conversation List-->
            <div class="col-sm-12 section-wrap">

                <!--Header-->
                <div class="row header-wrap">
                    <div class="chat-header col-sm-12">
                        <h4 id="username">Chats</h4>
                        <div class="header-button">
                        </div>
                    </div>
                </div>

                <!--Conversations-->
                <div class="row content-wrap">
                    
                    <div class="conversation btn">
                        <div class="media-body">
                            <h5 class="prevconvoname media-heading" id="contactName">192.168.0.1 / name / name</h5>
                            <small class="pull-right time">Last seen 12:10am</small>
                        </div>
                    </div>

                    

                    <div class="conversation btn">
                        <div class="media-body">
                            <h5 class="prevconvoname media-heading" id="contactName">192.168.0.1 / name</h5>
                            <small class="pull-right time">Last seen 12:10am</small>
                        </div>
                    </div>

                    <div class="conversation btn">
                        <div class="media-body">
                            <h5 class="prevconvoname media-heading" id="contactName">192.168.0.1 / name</h5>
                            <small class="pull-right time">Last seen 12:10am</small>
                        </div>
                    </div>

                    <div class="conversation btn">
                        <div class="media-body">
                            <h5 class="prevconvoname media-heading" id="contactName">192.168.0.1 / name</h5>
                            <small class="pull-right time">Last seen 12:10am</small>
                        </div>
                    </div>

                    <div class="conversation btn">
                        <div class="media-body">
                            <h5 class="prevconvoname media-heading" id="contactName">192.168.0.1 / name</h5>
                            <small class="pull-right time">Last seen 12:10am</small>
                        </div>
                    </div>

                    <div class="conversation btn">
                        <div class="media-body">
                            <h5 class="prevconvoname media-heading" id="contactName">192.168.0.1 / name</h5>
                            <small class="pull-right time">Last seen 12:10am</small>
                        </div>
                    </div>

                    <div class="conversation btn">
                        <div class="media-body">
                            <h5 class="prevconvoname media-heading" id="contactName">192.168.0.1 / name</h5>
                            <small class="pull-right time">Last seen 12:10am</small>
                        </div>
                    </div>

                    <div class="conversation btn">
                        <div class="media-body">
                            <h5 class="prevconvoname media-heading" id="contactName">192.168.0.1 / name</h5>
                            <small class="pull-right time">Last seen 12:10am</small>
                        </div>
                    </div>

                    <div class="conversation btn">
                        <div class="media-body">
                            <h5 class="prevconvoname media-heading" id="contactName">192.168.0.1 / name</h5>
                            <small class="pull-right time">Last seen 12:10am</small>
                        </div>
                    </div>

                    <div class="conversation btn">
                        <div class="media-body">
                            <h5 class="prevconvoname media-heading" id="contactName">192.168.0.1 / name</h5>
                            <small class="pull-right time">Last seen 12:10am</small>
                        </div>
                    </div>

                    <div class="conversation btn">
                        <div class="media-body">
                            <h5 class="prevconvoname media-heading" id="contactName">192.168.0.1 / name</h5>
                            <small class="pull-right time">Last seen 12:10am</small>
                        </div>
                    </div>

                    <div class="conversation btn">
                        <div class="media-body">
                            <h5 class="prevconvoname media-heading" id="contactName">192.168.0.1 / name</h5>
                            <small class="pull-right time">Last seen 12:10am</small>
                        </div>
                    </div>

                    <div class="conversation btn">
                        <div class="media-body">
                            <h5 class="prevconvoname media-heading" id="contactName">192.168.0.1 / name</h5>
                            <small class="pull-right time">Last seen 12:10am</small>
                        </div>
                    </div>

                    <div class="conversation btn">
                        <div class="media-body">
                            <h5 class="prevconvoname media-heading" id="contactName">192.168.0.1 / name</h5>
                            <small class="pull-right time">Last seen 12:10am</small>
                        </div>
                    </div>
                </div>

            </div>

        </div>

        <!-- Messages & Info -->
        <div class="col-sm-9 panel-wrap">

            <!--Main Content / Message List-->
            <div class="col-sm-12 section-wrap" id="Messages">

                <!--Header-->
                <div class="row header-wrap">
                    <div class="chat-header col-sm-12">
                        <h4>Chat Support Module</h4>
                        <div class="header-button">
                        </div>
                    </div>
                </div>

                <!--Messages-->
                <div class="row content-wrap messages">
                    <div class="msg">
                        <div class="media-body">
                            <small class="pull-right time"><i class="fa fa-clock-o"></i> 12:10am</small>
                            <h5 class="notmechatname media-heading">Walter White</h5>
                            <small class="col-sm-11">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec eu pulvinar magna. Phasellus semper scelerisque purus, et semper nisl lacinia sit amet. Praesent venenatis turpis vitae purus semper, eget sagittis velit venenatis. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos...</small>
                        </div>
                    </div>
                    <div class="msg">
                        <div class="media-body">
                            <small class="pull-right time"><i class="fa fa-clock-o"></i> 12:10am</small>

                            <h5 class="pull-right mechatname media-heading">Walter White</h5>
                            <small class="col-sm-11">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec eu pulvinar magna. Phasellus semper scelerisque purus, et semper nisl lacinia sit amet. Praesent venenatis turpis vitae purus semper, eget sagittis velit venenatis. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos...</small>
                        </div>
                    </div>
                    <div class="msg">
                        <div class="media-body">
                            <small class="pull-right time"><i class="fa fa-clock-o"></i> 12:10am</small>

                            <h5 class="notmechatname media-heading">Walter White</h5>
                            <small class="col-sm-11">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec eu pulvinar magna. Phasellus semper scelerisque purus, et semper nisl lacinia sit amet. Praesent venenatis turpis vitae purus semper, eget sagittis velit venenatis. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos...</small>
                        </div>
                    </div>
                    <div class="msg">
                        <div class="media-body">
                            <small class="pull-right time"><i class="fa fa-clock-o"></i> 12:10am</small>

                            <h5 class="pull-right mechatname media-heading">Walter White</h5>
                            <small class="col-sm-11">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec eu pulvinar magna. Phasellus semper scelerisque purus, et semper nisl lacinia sit amet. Praesent venenatis turpis vitae purus semper, eget sagittis velit venenatis. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos...</small>
                        </div>
                    </div>

                    <div class="msg">
                        <div class="media-body">
                            <small class="pull-right time"><i class="fa fa-clock-o"></i> 12:10am</small>

                            <h5 class="notmechatname media-heading">Walter White</h5>
                            <small class="col-sm-11">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec eu pulvinar magna. Phasellus semper scelerisque purus, et semper nisl lacinia sit amet. Praesent venenatis turpis vitae purus semper, eget sagittis velit venenatis. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos...</small>
                        </div>
                    </div>
                    <div class="msg">
                        <div class="media-body">
                            <small class="pull-right time"><i class="fa fa-clock-o"></i> 12:10am</small>

                            <h5 class="pull-right mechatname media-heading">Walter White</h5>
                            <small class="col-sm-11">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec eu pulvinar magna. Phasellus semper scelerisque purus, et semper nisl lacinia sit amet. Praesent venenatis turpis vitae purus semper, eget sagittis velit venenatis. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos...</small>
                        </div>
                    </div>

                </div>

                <!--Message box & Send Button-->
                <div class="row send-wrap">
                    <div class="send-message">
                        <div class="message-text">
                            <textarea class="no-resize-bar form-control" rows="2" placeholder="Write a message..."></textarea>
                        </div>
                        <div class="send-button">
                            <a class="btn">Send <i class="fa fa-send"></i></a>
                        </div>
                    </div>
                </div>

            </div>


        </div>
    </div>
</div>

<script type="text/javascript">
/!* Slide Members Info *!/
$('.info-btn').on('click', function () {
    $("#Messages").toggleClass('col-sm-12 col-sm-9');
});

</script>
</body>
</html>
