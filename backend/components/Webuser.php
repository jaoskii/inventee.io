<?php

namespace app\components;
use Yii;

class WebUser extends yii\web\User {


//    public function logout($destroySession=true) {
//        parent::logout($destroySession);
//        if (!$destroySession) {
//            $sessionId = Yii::app()->session->sessionId;
//            $sessionTable = Yii::app()->session->sessionTableName;
//            $sql = "UPDATE {$sessionTable} SET `user_id` = NULL WHERE `id` = '{$sessionId}'";
//            Yii::app()->db->createCommand($sql)->execute();
//        }
//    }
//
//    protected function changeIdentity($id,$name,$states) {
//        parent::changeIdentity($id,$name, $states);
//
//        $sessionId = Yii::app()->session->sessionId;
//        $sessionTable = Yii::app()->session->sessionTableName;
//        $sql = "UPDATE {$sessionTable} SET `user_id` = '$id' WHERE `id` = '{$sessionId}'";
//        Yii::app()->db->createCommand($sql)->execute();
//    }

    

    public static function getPoAccess() {
        $access=Yii::app()->user->access;
        $access_=preg_split('//',$access,-1,PREG_SPLIT_NO_EMPTY);
        //63-72 from db
        $access_po=array('PO');
        for($i=62;$i<72; $i++) {
            array_push($access_po,$access_[$i]);
        }

        $roles=array();
        if( $access_po[1]==1) //allow viewing
        {
            $role='granted';
            array_push($roles,$role);
        }
        else {
            $role='denied';
            array_push($roles,$role);
        }
        if( $access_po[2]==1) //allow Editing
        {
            $role='granted';
            array_push($roles,$role);
        }
        else {
            $role='denied';
            array_push($roles,$role);
        }
        if( $access_po[3]==1) //allow New
        {
            $role='granted';
            array_push($roles,$role);
        }
        else {
            $role='denied';
            array_push($roles,$role);
        }
        if( $access_po[4]==1) //allow Save
        {
            $role='granted';
            array_push($roles,$role);
        }
        else {
            $role='denied';
            array_push($roles,$role);
        }
        if( $access_po[5]==1) //allow Change docno
        {
            $role='granted';
            array_push($roles,$role);
        }
        else {
            $role='denied';
            array_push($roles,$role);
        }
        if( $access_po[6]==1) //allow Delete
        {
            $role='granted';
            array_push($roles,$role);
        }
        else {
            $role='denied';
            array_push($roles,$role);
        }
        if( $access_po[7]==1) //allow Print
        {
            $role='granted';
            array_push($roles,$role);
        }
        else {
            $role='denied';
            array_push($roles,$role);
        }
        if( $access_po[8]==1) //allow Lock
        {
            $role='granted';
            array_push($roles,$role);
        }
        else {
            $role='denied';
            array_push($roles,$role);
        }
        if( $access_po[9]==1) //allow Unlock
        {
            $role='granted';
            array_push($roles,$role);
        }
        else {
            $role='denied';
            array_push($roles,$role);
        }
        if( $access_po[10]==1) //Unallow Change amount
        {
            $role='granted';
            array_push($roles,$role);
        }
        else {
            $role='denied';
            array_push($roles,$role);
        }

        return $roles;

    }

    public static function getRRAccess() {
        $access=Yii::app()->user->access;
        $access_=preg_split('//',$access,-1,PREG_SPLIT_NO_EMPTY);
        //63-72 from db
        $access_rr=array('RR');
        for($i=78;$i<91; $i++) {
            array_push($access_rr,$access_[$i]);
        }

        $roles=array();
        if( $access_rr[1]==1) //allow viewing
        {
            $role='granted';
            array_push($roles,$role);
        }
        else {
            $role='denied';
            array_push($roles,$role);
        }
        if( $access_rr[2]==1) //allow Editing
        {
            $role='granted';
            array_push($roles,$role);
        }
        else {
            $role='denied';
            array_push($roles,$role);
        }
        if( $access_rr[3]==1) //allow New
        {
            $role='granted';
            array_push($roles,$role);
        }
        else {
            $role='denied';
            array_push($roles,$role);
        }
        if( $access_rr[4]==1) //allow Save
        {
            $role='granted';
            array_push($roles,$role);
        }
        else {
            $role='denied';
            array_push($roles,$role);
        }
        if( $access_rr[5]==1) //allow Change docno
        {
            $role='granted';
            array_push($roles,$role);
        }
        else {
            $role='denied';
            array_push($roles,$role);
        }
        if( $access_rr[6]==1) //allow Delete
        {
            $role='granted';
            array_push($roles,$role);
        }
        else {
            $role='denied';
            array_push($roles,$role);
        }
        if( $access_rr[7]==1) //allow Print
        {
            $role='granted';
            array_push($roles,$role);
        }
        else {
            $role='denied';
            array_push($roles,$role);
        }
        if( $access_rr[8]==1) //allow Lock
        {
            $role='granted';
            array_push($roles,$role);
        }
        else {
            $role='denied';
            array_push($roles,$role);
        }
        if( $access_rr[9]==1) //allow Unlock
        {
            $role='granted';
            array_push($roles,$role);
        }
        else {
            $role='denied';
            array_push($roles,$role);
        }
        if( $access_rr[10]==1) //allow Post
        {
            $role='granted';
            array_push($roles,$role);
        }
        else {
            $role='denied';
            array_push($roles,$role);
        }
        if( $access_rr[11]==1) //allow UnPost
        {
            $role='granted';
            array_push($roles,$role);
        }
        else {
            $role='denied';
            array_push($roles,$role);
        }
        if( $access_rr[12]==1) //No viewing of accounting  transaction RR
        {
            $role='granted';
            array_push($roles,$role);
        }
        else {
            $role='denied';
            array_push($roles,$role);
        }
        if( $access_rr[13]==1) //Unallow Change amount
        {
            $role='granted';
            array_push($roles,$role);
        }
        else {
            $role='denied';
            array_push($roles,$role);
        }

        return $roles;

    }

    public static function getCLAccess() {
        $access= Yii::app()->user->access;
        $access_=preg_split('//',$access,-1,PREG_SPLIT_NO_EMPTY);
        $access_cl=array('CL');
        for($i=21;$i<28; $i++) {
            array_push($access_cl,$access_[$i]);
        }

        $roles=array();
        if( $access_cl[1]==1) //allow viewing
        {
            $role='granted';
            array_push($roles,$role);
        }
        else {
            $role='denied';
            array_push($roles,$role);
        }
        if( $access_cl[2]==1) //allow Editing
        {
            $role='granted';
            array_push($roles,$role);
        }
        else {
            $role='denied';
            array_push($roles,$role);
        }
        if( $access_cl[3]==1) //allow New
        {
            $role='granted';
            array_push($roles,$role);
        }
        else {
            $role='denied';
            array_push($roles,$role);
        }
        if( $access_cl[4]==1) //allow Save
        {
            $role='granted';
            array_push($roles,$role);
        }
        else {
            $role='denied';
            array_push($roles,$role);
        }
        if( $access_cl[5]==1) //allow Change docno
        {
            $role='granted';
            array_push($roles,$role);
        }
        else {
            $role='denied';
            array_push($roles,$role);
        }
        if( $access_cl[6]==1) //allow Delete
        {
            $role='granted';
            array_push($roles,$role);
        }
        else {
            $role='denied';
            array_push($roles,$role);
        }
        if( $access_cl[7]==1) //allow Print
        {
            $role='granted';
            array_push($roles,$role);
        }
        else {
            $role='denied';
            array_push($roles,$role);
        }

        return $roles;

    }






















}


/*
 * <?php

// this file must be stored in:
// protected/components/WebUser.php

class WebUser extends CWebUser {

  // Store model to not repeat query.
  private $_model;

  // Return first name.
  // access it by Yii::app()->user->first_name
  function getFirst_Name(){
    $user = $this->loadUser(Yii::app()->user->id);
    return $user->first_name;
  }

  // This is a function that checks the field 'role'
  // in the User model to be equal to 1, that means it's admin
  // access it by Yii::app()->user->isAdmin()
  function isAdmin(){
    $user = $this->loadUser(Yii::app()->user->id);
    return intval($user->role) == 1;
  }

  // Load user model.
  protected function loadUser($id=null)
    {
        if($this->_model===null)
        {
            if($id!==null)
                $this->_model=User::model()->findByPk($id);
        }
        return $this->_model;
    }
}
 *
 *
 *
*/
?>