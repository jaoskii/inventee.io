<?php
//WTODO: [KIM][2019.11.13][Product Information Sheet]
date_default_timezone_set('Asia/Manila');
$this->title = 'Product Information Sheet';
?>


<div id="print_btn" class="btn_a">
    <button class="btn btn-default form-control" onClick="window.print();"><i class="fa fa-print"></i></button>
</div>

<?php
$count=55;
$page=55;
Yii::$app->reporter->beginreport('800');
  Yii::$app->reporter->begintable('800');
    $header=Yii::$app->reporter->letterhead();
    Yii::$app->reporter->endtable();
   

  Yii::$app->reporter->begintable('800');    
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('',null,null,false,'1px solid ','','C','Century Gothic','12','','','').'<br />';
    Yii::$app->reporter->endrow();
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('PRODUCT INFORMATION SHEET',null,null,false,'1px solid ','','C','Century Gothic','13','B','','').'<br />';
    Yii::$app->reporter->endrow();
  Yii::$app->reporter->endtable();

  echo '<br/>';
  Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('&nbsp','800',null,false,'1px dashed ','B','L','Century Gothic','12','','','');
    Yii::$app->reporter->endrow();
  Yii::$app->reporter->endtable();
  echo '<br/>';

  Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('Product &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp: ','100',null,false,'1px solid ','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col($data[0]['barcode'],'150',null,false,'1px solid ','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col($data[0]['itemname'],'550',null,false,'1px solid ','','L','Century Gothic','12','','','');
    Yii::$app->reporter->endrow();

    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('Customer &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp: ','100',null,false,'1px solid ','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col($data[0]['fg_customer'],'150',null,false,'1px solid ','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col($data[0]['clientname'],'550',null,false,'1px solid ','','L','Century Gothic','12','','','');
    Yii::$app->reporter->endrow();
  Yii::$app->reporter->endtable();
  
  echo '<br/>';
  Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('Job Type &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp: ','100',null,false,'1px solid','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col($data[0]['fg_prodtype'],'700',null,false,'1px solid','','L','Century Gothic','12','','','');
    Yii::$app->reporter->endrow();

    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('Combination &nbsp&nbsp&nbsp: ','100',null,false,'1px solid','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col($data[0]['fg_combi'],'700',null,false,'1px solid','','L','Century Gothic','12','','','');
    Yii::$app->reporter->endrow();

    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('JO Width &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp: ','100',null,false,'1px solid','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col($data[0]['fg_jowidth'].'&nbsp&nbsp'.$data[0]['fg_jowidthuom'],'700',null,false,'1px solid','','L','Century Gothic','12','','','');
    Yii::$app->reporter->endrow();

    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('JO Length &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp: ','100',null,false,'1px solid','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col($data[0]['fg_jolength'].'&nbsp&nbsp'.$data[0]['fg_jolengthuom'],'700',null,false,'1px solid','','L','Century Gothic','12','','','');
    Yii::$app->reporter->endrow();

    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('Thickness &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp: ','100',null,false,'1px solid','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col($data[0]['fg_thickness'].'&nbsp&nbsp'.$data[0]['fg_thicknessuom'],'700',null,false,'1px solid','','L','Century Gothic','12','','','');
    Yii::$app->reporter->endrow();

    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('Actual Wid &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp: ','100',null,false,'1px solid','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col($data[0]['fg_actualwidth'].'&nbsp&nbsp'.$data[0]['fg_actualwidthuom'],'700',null,false,'1px solid','','L','Century Gothic','12','','','');
    Yii::$app->reporter->endrow();

    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('Actual Len &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp: ','100',null,false,'1px solid','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col($data[0]['fg_actuallength'].'&nbsp&nbsp'.$data[0]['fg_actuallengthuom'],'700',null,false,'1px solid','','L','Century Gothic','12','','','');
    Yii::$app->reporter->endrow();

    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('No. of Color &nbsp&nbsp&nbsp&nbsp&nbsp: ','100',null,false,'1px solid','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col($data[0]['fg_colornum'],'700',null,false,'1px solid','','L','Century Gothic','12','','','');
    Yii::$app->reporter->endrow();

    
  Yii::$app->reporter->endtable();

  //color

    $qry = "select distinct color.name as color from fg_colors as color
            left join fgi_colors as colors on color.id=colors.color
            where colors.itemid = " . $data[0]['itemid'] . " order by line";
    $color = Yii::$app->sbccommon->opentable($qry);

  
  Yii::$app->reporter->begintable('800');
      
      foreach ($color as $key => $value) {
        if($key == 0){
          

          Yii::$app->reporter->startrow();
            Yii::$app->reporter->addline();
            Yii::$app->reporter->col('Color &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp:','100',null,false,'1px solid ','','L','Century Gothic','12','','','');
            Yii::$app->reporter->col($value['color'],'700',null,false,'1px solid ','','L','Century Gothic','12','','','');
            
          Yii::$app->reporter->endrow();
        }else{
          Yii::$app->reporter->startrow();
            Yii::$app->reporter->addline();
            Yii::$app->reporter->col(' :&nbsp&nbsp','100',null,false,'1px solid ','','R','Century Gothic','10','','','');
            Yii::$app->reporter->col($value['color'],'700',null,false,'1px solid ','','L','Century Gothic','12','','','');
            
          Yii::$app->reporter->endrow();
        }//
        
      }
    

  Yii::$app->reporter->endtable();


  Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('Repeat Len &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp: ','100',null,false,'1px solid','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col($data[0]['fg_repeatlength'].'&nbsp&nbsp'.$data[0]['fg_repeatlengthuom'],'700',null,false,'1px solid','','L','Century Gothic','12','','','');
    Yii::$app->reporter->endrow();

    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('No. of Outs &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp: ','100',null,false,'1px solid','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col($data[0]['fg_outnum'],'700',null,false,'1px solid','','L','Century Gothic','12','','','');
    Yii::$app->reporter->endrow();

    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('Sealing &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp: ','100',null,false,'1px solid','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col($data[0]['fg_sealing'],'700',null,false,'1px solid','','L','Century Gothic','12','','','');
    Yii::$app->reporter->endrow();

    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('Transformation &nbsp: ','100',null,false,'1px solid','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col($data[0]['fg_transform'],'700',null,false,'1px solid','','L','Century Gothic','12','','','');
    Yii::$app->reporter->endrow();

    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('Add Specs &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp: ','100',null,false,'1px solid','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col($data[0]['fg_addspecs'],'700',null,false,'1px solid','','L','Century Gothic','12','','','');
    Yii::$app->reporter->endrow();

    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('Punch Hole &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp: ','100',null,false,'1px solid','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col($data[0]['fg_punchholesize'],'700',null,false,'1px solid','','L','Century Gothic','12','','','');
    Yii::$app->reporter->endrow();
  Yii::$app->reporter->endtable();
  echo '<br/>';

  Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('BLOWING DETAILS','800',null,false,'1px solid','','L','Century Gothic','12','','','');
    Yii::$app->reporter->endrow();
  Yii::$app->reporter->endtable();

  Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('Plastic Color &nbsp&nbsp&nbsp&nbsp: ','100',null,false,'1px solid','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col($data[0]['fg_plasticcolor'],'700',null,false,'1px solid','','L','Century Gothic','12','','','');
    Yii::$app->reporter->endrow();

    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('B Film Det &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp: ','100',null,false,'1px solid','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col($data[0]['fg_bfilmdet'],'700',null,false,'1px solid','','L','Century Gothic','12','','','');
    Yii::$app->reporter->endrow();

    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('B Film Wid &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp: ','100',null,false,'1px solid','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col($data[0]['fg_bfilmwidth'].'&nbsp&nbsp'.$data[0]['fg_bfilmwidthuom'],'700',null,false,'1px solid','','L','Century Gothic','12','','','');
    Yii::$app->reporter->endrow();

    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('Thickness &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp: ','100',null,false,'1px solid','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col($data[0]['fg_thickness2'].'&nbsp&nbsp'.$data[0]['fg_thickness2uom'],'700',null,false,'1px solid','','L','Century Gothic','12','','','');
    Yii::$app->reporter->endrow();

    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('Treatment &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp: ','100',null,false,'1px solid','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col($data[0]['fg_treatment'],'700',null,false,'1px solid','','L','Century Gothic','12','','','');
    Yii::$app->reporter->endrow();

    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('Grams/Piece &nbsp&nbsp&nbsp: ','100',null,false,'1px solid','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col($data[0]['fg_gramppiece1'].' - '.$data[0]['fg_gramppiece2'].'&nbsp&nbsp'.'Grams','700',null,false,'1px solid','','L','Century Gothic','12','','','');
    Yii::$app->reporter->endrow();
  Yii::$app->reporter->endtable();

  

echo '</br>';


  $qry = "select distinct mat.name as material,mats.width, mats.thickness from fg_material as mat
          left join fgi_material as mats on mat.id = mats.material
          where mats.itemid = ".$data[0]['itemid']."
          order by material";
  $material = Yii::$app->sbccommon->opentable($qry);


  Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('','50',null,false,'1px dashed ','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('Material','150',null,false,'1px dashed ','B','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('','50',null,false,'1px dashed ','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('Width','100',null,false,'1px dashed ','B','C','Century Gothic','12','','','');
      Yii::$app->reporter->col('','50',null,false,'1px dashed ','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('Thickness','150',null,false,'1px dashed ','B','C','Century Gothic','12','','','');
      Yii::$app->reporter->col('','250',null,false,'1px dashed ','','R','Century Gothic','12','','','');
       
      for($i=0;$i<count($material);$i++){
        Yii::$app->reporter->startrow();
          Yii::$app->reporter->addline();
          Yii::$app->reporter->col('','50',null,false,'1px dashed ','','L','Century Gothic','12','','','');
          Yii::$app->reporter->col($material[$i]['material'],'150',null,false,'1px solid ','','L','Century Gothic','12','','','');
          Yii::$app->reporter->col('','50',null,false,'1px dashed ','','L','Century Gothic','12','','','');
      
          Yii::$app->reporter->col($material[$i]['width'],'100',null,false,'1px solid ','','R','Century Gothic','12','','','');
          Yii::$app->reporter->col('','50',null,false,'1px dashed ','','L','Century Gothic','12','','','');
          Yii::$app->reporter->col($material[$i]['thickness'],'150',null,false,'1px solid ','','C','Century Gothic','12','','','');
          Yii::$app->reporter->col('','250',null,false,'1px solid ','','R','Century Gothic','12','','','');
          
        Yii::$app->reporter->endrow();

    if(Yii::$app->reporter->linecounter==$page){
    Yii::$app->reporter->endtable();
    Yii::$app->reporter->begintable('800');
      Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('','50',null,false,'1px dashed ','','L','Century Gothic','12','','','');
        Yii::$app->reporter->col('Material','150',null,false,'1px dashed ','B','L','Century Gothic','12','','','');
        Yii::$app->reporter->col('','50',null,false,'1px dashed ','','L','Century Gothic','12','','','');
        Yii::$app->reporter->col('Width','100',null,false,'1px dashed ','B','C','Century Gothic','12','','','');
        Yii::$app->reporter->col('','50',null,false,'1px dashed ','','L','Century Gothic','12','','','');
        Yii::$app->reporter->col('Thickness','150',null,false,'1px dashed ','B','C','Century Gothic','12','','','');
        Yii::$app->reporter->col('','250',null,false,'1px dashed ','','R','Century Gothic','12','','','');
      Yii::$app->reporter->endrow();
      Yii::$app->reporter->printline();
    } 
  }

  Yii::$app->reporter->endtable();
  echo '</br>';

  $qry ="select distinct cylitem.barcode, cyl.cylinder from fgi_cylinder as cyl
          left join item on cyl.itemid = item.itemid
          left join item as cylitem on cyl.code= cylitem.itemid
          where item.itemid = ".$data[0]['itemid']."
          order by cylinder";

  $cylinder = Yii::$app->sbccommon->opentable($qry);


  Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('','50',null,false,'1px dashed ','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('Cyl S#','150',null,false,'1px dashed ','B','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('','50',null,false,'1px dashed ','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('Description','300',null,false,'1px dashed ','B','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('','250',null,false,'1px dashed ','','L','Century Gothic','12','','','');
      
       
      for($i=0;$i<count($cylinder);$i++){
        Yii::$app->reporter->startrow();
          Yii::$app->reporter->addline();
          Yii::$app->reporter->col('','50',null,false,'1px dashed ','','L','Century Gothic','12','','','');
          Yii::$app->reporter->col($cylinder[$i]['barcode'],'150',null,false,'1px solid ','','L','Century Gothic','12','','','');
          Yii::$app->reporter->col('','50',null,false,'1px dashed ','','L','Century Gothic','12','','','');
      
          Yii::$app->reporter->col($cylinder[$i]['cylinder'],'500',null,false,'1px solid ','','L','Century Gothic','12','','','');
          Yii::$app->reporter->col('','50',null,false,'1px solid ','','R','Century Gothic','12','','','');
          
        Yii::$app->reporter->endrow();

    if(Yii::$app->reporter->linecounter==$page){
    Yii::$app->reporter->endtable();
    Yii::$app->reporter->begintable('800');
      Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('','50',null,false,'1px dashed ','','L','Century Gothic','12','','','');
        Yii::$app->reporter->col('Cyl S#','150',null,false,'1px dashed ','B','L','Century Gothic','12','','','');
        Yii::$app->reporter->col('','50',null,false,'1px dashed ','','L','Century Gothic','12','','','');
        Yii::$app->reporter->col('Description','300',null,false,'1px dashed ','B','L','Century Gothic','12','','','');
        Yii::$app->reporter->col('','250',null,false,'1px dashed ','','L','Century Gothic','12','','','');
      
      Yii::$app->reporter->endrow();
      Yii::$app->reporter->printline();
    } 
  }

  Yii::$app->reporter->endtable();

  echo '</br>';

  // $qry ="select distinct code, process, instructions from fgi_process 
  //        where itemid = ".$data[0]['itemid']." order by process";
  $qry ="select distinct pros.code, pro.name,pros.instructions from fg_process as pro
         left join fgi_process as pros on pro.id = pros.processid
         where pros.itemid = ".$data[0]['itemid']." order by name";  

  $process = Yii::$app->sbccommon->opentable($qry);


  Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('','50',null,false,'1px dashed ','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('Code','150',null,false,'1px dashed ','B','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('','50',null,false,'1px dashed ','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('Process','150',null,false,'1px dashed ','B','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('','50',null,false,'1px dashed ','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('Instructions','150',null,false,'1px dashed ','B','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('','200',null,false,'1px dashed ','','L','Century Gothic','12','','','');
      
       
      for($i=0;$i<count($process);$i++){
        Yii::$app->reporter->startrow();
          Yii::$app->reporter->addline();
          Yii::$app->reporter->col('','50',null,false,'1px dashed ','','L','Century Gothic','12','','','');
          Yii::$app->reporter->col($process[$i]['code'],'150',null,false,'1px solid ','','L','Century Gothic','12','','','');
          Yii::$app->reporter->col('','50',null,false,'1px dashed ','','L','Century Gothic','12','','','');
      
          Yii::$app->reporter->col($process[$i]['name'],'150',null,false,'1px solid ','','L','Century Gothic','12','','','');
          Yii::$app->reporter->col('','50',null,false,'1px dashed ','','L','Century Gothic','12','','','');
          Yii::$app->reporter->col($process[$i]['instructions'],'150',null,false,'1px dashed ','','L','Century Gothic','12','','','');
          Yii::$app->reporter->col('','200',null,false,'1px dashed ','','L','Century Gothic','12','','','');
     
        Yii::$app->reporter->endrow();

    if(Yii::$app->reporter->linecounter==$page){
    Yii::$app->reporter->endtable();
    Yii::$app->reporter->begintable('800');
      Yii::$app->reporter->startrow();
        Yii::$app->reporter->col('','50',null,false,'1px dashed ','','L','Century Gothic','12','','','');
        Yii::$app->reporter->col('Code','150',null,false,'1px dashed ','B','L','Century Gothic','12','','','');
        Yii::$app->reporter->col('','50',null,false,'1px dashed ','','L','Century Gothic','12','','','');
        Yii::$app->reporter->col('Process','150',null,false,'1px dashed ','B','L','Century Gothic','12','','','');
        Yii::$app->reporter->col('','50',null,false,'1px dashed ','','L','Century Gothic','12','','','');
        Yii::$app->reporter->col('Instructions','150',null,false,'1px dashed ','B','L','Century Gothic','12','','','');
        Yii::$app->reporter->col('','200',null,false,'1px dashed ','','L','Century Gothic','12','','','');
      
      Yii::$app->reporter->endrow();
      Yii::$app->reporter->printline();
    } 
  }

  Yii::$app->reporter->endtable();

  echo '</br></br>';



  Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col('Prepared by: ','200',null,false,'1px solid','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('Checked by: ','200',null,false,'1px solid','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('Reviewed by: ','200',null,false,'1px solid','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('Approved by: ','200',null,false,'1px solid','','L','Century Gothic','12','','','');
    Yii::$app->reporter->endrow();
  Yii::$app->reporter->endtable();

  echo '</br>';
  Yii::$app->reporter->begintable('800');
    Yii::$app->reporter->startrow();
      Yii::$app->reporter->col(Yii::$app->session['loggeduser']['username'],'200',null,false,'1px solid','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('Quality Assurance','200',null,false,'1px solid','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('DJA - Admin Manager','200',null,false,'1px solid','','L','Century Gothic','12','','','');
      Yii::$app->reporter->col('ECG - General Manager','200',null,false,'1px solid','','L','Century Gothic','12','','','');
    Yii::$app->reporter->endrow();
  Yii::$app->reporter->endtable();
  Yii::$app->reporter->printline();

Yii::$app->reporter->endtable();
?>