<?php

namespace app\components;
 
use Yii;
use yii\base\Component;
use app\models\Common;

class sbcpdf {

    public $linecounter=0;
    //   width,  height,  background, border,   text-alignment, font,   fontsize, color,     fontweight,    padding,       margin
    
    function begintable($w=null,$h=null, $bg=false,  $b=false, $al='',  $f='', $fs='',$fw='',$fc='',$pad='',$m='') {
        $style=$this->styler($w,$h,$bg,$b,$al,$f,$fs,$fw,$fc,$pad,$m);
        echo  $d='<table id="table_report" style="'.$style.'">';
    }

    function endtable() {
        echo '</table>';
    }

    function startrow($w=null,$h=null, $bg=false,  $b=false, $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='') {
        $style=$this->styler($w, $h, $bg, $b, $al, $f, $fs, $fw, $fc, $pad, $m);
        echo  $d='<tr style="'.$style.'">';
    }

    function endrow() {
        echo '</tr>';
    }

    function col($txt='',$w=null,$h=null, $bg=false,  $b=false, $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='',$len=0) {
        $style=$this->styler($w, $h, $bg, $b, $al, $f, $fs, $fw, $fc, $pad, $m);
        if($len==0){
            //@TODO multiline printing
            echo  $d='<td style="'.$style.'">'.$txt.'</td>'; //ucwords(strtolower($txt))
        }else{
            echo  $d='<td style="'.$style.'">'.substr($txt,0,$len).'</td>'; //ucwords(strtolower(substr($txt,0,$len)))
        }
    }

    function row($cols,$txt) {
        $linecounter=1;
        echo '<tr>';
        foreach($cols as $key => $col) {
            $w=isset($col[0])? $col[0] : null;
            $h=isset($col[1])? $col[1] : null;
            $bg=isset($col[2])? $col[2] : false;
            $b=isset($col[3])? $col[3] : false;
            $b_=isset($col[4])? $col[4] : '';
            $al=isset($col[5])? $col[5] : '';
            $f=isset($col[6])? $col[6] : '';
            $fs=isset($col[7])? $col[7] : '';
            $fw=isset($col[8])? $col[8] : '';
            $fc=isset($col[9])? $col[9] : '';
            $pad=isset($col[10])? $col[10] : '';
            $m=isset($col[11])? $col[11] : '';
            $len=isset($col[12])? $col[12] : 0;

            $style=$this->styler($w,$h,$bg,$b, $b_, $al, $f, $fs,  $fw, $fc, $pad, $m);

            if($len!=0) {
                $this->breakword($txt, $key, $len, $col,$style, $linecounter);
            }
            else {
                echo '<td style="'.$style.'">'.ucwords(strtolower(substr($txt[$key],0,$w/4))).'</td>';
            }

        }
        echo '</tr>';
        $this->linecounter++;
    }
    
    public function letterhead(){
        echo '<span class="header"></span>';
        $this->generateReportHeader();
    }//end letterhead

    public function letterfooter(){
        echo '<span class="footer"></span>';
        // $this->generateReportHeader();
    }//end letterhead

    private function generateReportHeader(){
        
        $loggeduser = Yii::$app->session['loggeduser']['name'];
        if(Yii::$app->systemsettings->setCenterSelection()){
            //#####################################################
            //CREATES HEADER BASED ON INFO OF LOGGED CENTER (MULTI-CENTER)
            //#####################################################
            

            switch (Yii::$app->systemsettings->companyConfig()) {
                case 'RTT':
                    //NEEDS TO BE BLANK              
                break;
                
                case 'GAMELINE_POS':
                    echo "<div><img style='width:230px;margin-left:39%;' src='".Yii::$app->homeUrl . "fimages/reportheaders/alldaywholefoods.jpg'><br></div>";
                    Yii::$app->reporter->endrow();
                    Yii::$app->reporter->startrow();
                    Yii::$app->reporter->col(Yii::$app->session['sysconfig']['report_address'],null,null,false,'1px solid ','','c','Century Gothic','12','B','','').'<br />';
                    Yii::$app->reporter->endrow();
                    Yii::$app->reporter->startrow();
                    Yii::$app->reporter->col(Yii::$app->session['sysconfig']['report_contact'],null,null,false,'1px solid ','','c','Century Gothic','12','B','','').'<br />';
                    Yii::$app->reporter->endrow();

                    Yii::$app->reporter->startrow();
                    Yii::$app->reporter->col(strtoupper($loggeduser).' '.date('m/d/Y H:i:s',time()). '&nbsp;'.Yii::$app->session['loggeduser']['center'].'&nbsp;'.Yii::$app->session['ownerconfig']['companyname'],'600',null,false,'1px solid ','','L','Century Gothic','9','','','');
                    Yii::$app->reporter->endrow();
                    Yii::$app->reporter->startrow();
                break;

                default:
                    Yii::$app->reporter->startrow();
                    //WTODO: [KIM][2019.11.22][change font size]
                    Yii::$app->reporter->col(strtoupper($loggeduser).' '.date('m/d/Y H:i:s',time()). '&nbsp;'.Yii::$app->session['loggeduser']['center'].'&nbsp;'.Yii::$app->session['ownerconfig']['companyname'],'600',null,false,'1px solid ','','L','Century Gothic','9','','','');
                    Yii::$app->reporter->endrow();
                    Yii::$app->reporter->startrow();

                    Yii::$app->reporter->col(Yii::$app->session['loggeduser']['centername'],null,null,false,'1px solid ','','c','Century Gothic','13','B','','').'<br />';
                    Yii::$app->reporter->endrow();
                    Yii::$app->reporter->startrow();
                    Yii::$app->reporter->col(Yii::$app->session['loggeduser']['centeradd'],null,null,false,'1px solid ','','c','Century Gothic','12','B','','').'<br />';
                    Yii::$app->reporter->endrow();
                    Yii::$app->reporter->startrow();
                    Yii::$app->reporter->col(Yii::$app->session['loggeduser']['centertel'],null,null,false,'1px solid ','','c','Century Gothic','12','B','','').'<br />';
                    Yii::$app->reporter->endrow();
                break;
            }//END SWITCH

        }else{
            //#####################################################
            //CREATES HEADER BASED ON INFO OF SET COMPANY (DEFAULT) (SINGLE CENTER)
            //#####################################################
            Yii::$app->reporter->startrow();
            switch (Yii::$app->systemsettings->companyConfig()) {
                case 'TENPLUS':
                    # do nothing
                break;
                
                default:
                Yii::$app->reporter->col(strtoupper($loggeduser).' '.date('m/d/Y H:i:s',time()) . '&nbsp;'.Yii::$app->session['loggeduser']['center'] . '&nbsp;'.Yii::$app->session['ownerconfig']['companyname'],'600',null,false,'1px solid ','','L','Helvetica','10','','','');                    
                break;
            }//END SWITCH

            

            switch (Yii::$app->systemsettings->companyConfig()) {
                case 'UNIVERSE':
                Yii::$app->reporter->endrow();
                    Yii::$app->reporter->startrow();
                    Yii::$app->reporter->col("S",null,null,false,'1px solid ','','c','Helvetica','13','B','','').'<br />';
                    Yii::$app->reporter->endrow();
                break;
                
                default:
                    Yii::$app->reporter->endrow();
                    Yii::$app->reporter->startrow();
                    Yii::$app->reporter->col(Yii::$app->session['sysconfig']['report_companyname'],null,null,false,'1px solid ','','c','Century Gothic','13','B','','').'<br />';
                    Yii::$app->reporter->endrow();
                break;
            }

            switch (Yii::$app->systemsettings->companyConfig()) {
            
            case 'RTT':
                //NEEDS TO BE BLANK              
            break;

            case 'UNIVERSE':

            break;
            
            default:
                    Yii::$app->reporter->startrow();
                    Yii::$app->reporter->col(Yii::$app->session['sysconfig']['report_address'],null,null,false,'1px solid ','','c','Century Gothic','12','B','','').'<br />';
                    Yii::$app->reporter->endrow();
                    Yii::$app->reporter->startrow();
                    Yii::$app->reporter->col(Yii::$app->session['sysconfig']['report_contact'],null,null,false,'1px solid ','','c','Century Gothic','12','B','','').'<br />';
                    Yii::$app->reporter->endrow();
                    break;
            }//END SWITCH
        }//end if
    }//end function generate report header

    function tableheader($txt='',$rowspan='',$colspan='',$w=null,$h=null, $bg=false,  $b=false,$b_='', $al='', $f='courier', $fs='',$fw='',$fc='',$pad='',$m='') {
        $style=$this->styler($w, $h, $bg, $b, $b_, $al, $f, $fs, $fw, $fc, $pad, $m);
        if($rowspan!=''){
           echo  $d='<th rowspan='.$rowspan.'; style="'.$style.'">'.$txt.'</th>';
        }
        elseif($colspan!=''){
           echo  $d='<th colspan='.$colspan.'; style="'.$style.'">'.$txt.'</th>';
        }
        else{
           echo  $d='<th style="'.$style.'">'.$txt.'</th>';
        }
    }

    function breakword($txt, $key, $len, $col, $style, $linecounter) {

        $val1='';
        $val2='';
        $val3='';
        $val4='';
        $linenum=0;
        $sam=ucwords($txt[$key]);
        if($key>=0) {
            $linenum=ceil(strlen($sam)/ $len) ;
            $line1=substr($sam,0,$len);
            $line2=substr($sam,$len,$len);
            $line3=substr($sam,$len*2,$len);
            $line4=substr($sam,$len*3,$len);

            $len2=strlen($line2);
            $len3=strlen($line3);
            $len4=strlen($line4);
            for($keyfield=0;$keyfield<=$key;$keyfield++) {
                if($keyfield==$key) {
                    if($col!=null) {
                        $val1 .='<td style="'.$style.'">'.$line1.'</td>';
                        $val2 .='<td style="'.$style.'">'.$line2.'</td>';
                        $val3 .='<td style="'.$style.'">'.$line3.'</td>';
                        $val4 .='<td style="'.$style.'">'.$line4.'</td>';
                    }
                }
            }
        }

        for($i=0;$i<1;$i++) {
            if($len>0) {
                $this->multiline($val1,1,$i);
                if($len2>0) {
                    $this->multiline($val2,2,$i);
                    if($len3>0) {
                        $this->multiline($val3,3,$i);
                        if($len4>0) {
                            $this->multiline($val4,4,$i);
                        }
                    }
                }
            }
            $linecounter++;
        }
    }

    function multiline($val,$lines) {
        echo $val;                                                                // output
    }

    function styler($w=null,$h=null, $bg=false,  $b=false, $b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='') {
        if($w!=null) {
            $w_=' width:'.$w.'px; ';
        }else {
            $w_='';
        }
        if($h!=null) {
            $h_=' height:'.$h.'px; ';
        }else {
            $h_='';
        }
        if($bg) {
            $bgcolor=' background: '.$bg.'; ';
        }else {
            $bgcolor='';
        }

        $b_=preg_split('//', strtoupper($b_));
        $border='';
        
        foreach($b_ as $bline) {
            switch($bline) {
                case'L': {
                        $border .=' border-left: '.$b.'; ';
                        break;
                    }
                case'R': {
                        $border .=' border-right: '.$b.'; ';
                        break;
                    }
                case'T': {
                        $border .=' border-top: '.$b.'; ';
                        break;
                    }
                case'B': {
                        $border .=' border-bottom: '.$b.'; ';
                        break;
                    }
            }
        }//end for each

        switch(strtoupper($al)) {
            case 'R': {
                    $align='right';
                    break;
                }
            case 'C': {
                    $align='center';
                    break;
                }
            default: {
                    $align='left';
                    break;
                }

        }//end switch
        
        $font= $f!='' ? ' font-family: '.$f.'; ' : '';
        $fontsize = $fs!='' ? ' font-size: '.$fs.'px; ' : '';
        $fontcolor= $fc!='' ? ' color: '.$fc.'; ' : '';
        $fw=$fw!=''? strtoupper($fw) : '' ;
        
        switch($fw) {
            case'B': {
                    $fontweight=' font-weight: bold; ';
                    break;
                }
            case'BI':
            case'IB': {
                    $fontweight=' font-weight:bold; font-style: italic; ';
                    break;
                }
            case'I': {
                    $fontweight=' font-weight:normal; font-style: italic; ';
                    break;
                }
            default: {
                    $fontweight=' font-weight:inherit; ';
                    break;
                }
        }//end if

        $padding=$pad!=''? 'padding : '.$pad.';' : '';
        $margin=$m!=''? 'margin : '.$m.';' : '';
        $style=$w_.$h_.$bgcolor.$border.$font.$fontsize.$fontcolor.$fontweight.$padding.$margin.'text-align:'.$align;
        return $style;
    }
    function page_break() {
        echo '<div class="page-break"></div>';
    }
    function beginreport($w=null,$h=null, $bg=false,  $b=false, $b_='', $al='', $f='', $fs='',$fw='',$fc='',$pad='',$m='') {
        if($w==null) {
            $w='800';
        }
        $style=$this->styler($w, $h, $bg, $b, $b_, $al, $f, $fs, $fw, $fc, $pad, $m);
        echo '<div id="report_content" style=" '. $style .' margin:auto;">';
    }
    function endreport() {
        echo '</div>';
    }
    function addline() {
        $this->linecounter++;
    }
    function header($header=null) {
        $headerlogo=false;
        $headertext=false;
        if($header!=null) {
            $headerheight=isset($header['h'])?$header['h'] : 0 ;
            $b=isset($header['b'])?$header['b'] : '0px';
            $b_=isset($header['b_']) ? $header['b_'] : '';


            $b_=preg_split('//', strtoupper($b_));

        $border='';

        foreach($b_ as $bline) {
            switch($bline) {
                case'L': {
                        $border .=' border-left: '.$b.'; ';
                        break;
                    }
                case'R': {
                        $border .=' border-right: '.$b.'; ';
                        break;
                    }
                case'T': {
                        $border .=' border-top: '.$b.'; ';
                        break;
                    }
                case'B': {
                        $border .=' border-bottom: '.$b.'; ';
                        break;
                    }
            }
        }




            if(isset($header['logo']) && $header['logo']) {
                $headerlogo=isset($header['logo'][0])?$header['logo'][0] : false ;
                $l_width=isset($header['logo'][1])?$header['logo'][1] : '100' ;
                $l_float=isset($header['logo'][2])? strtoupper($header['logo'][2]) : '' ;
                switch($l_float) {
                    case 'R': {
                            $l_float='right';
                            break;
                        }
                    case 'L': {
                            $l_float='left';
                            break;
                        }
                    default: {
                            $l_float='center';
                            break;
                        }
                }
//                $this->l_margin=isset($header['logo'][2])?$header['logo'][2] : '11' ;
                $l_padding=isset($header['logo'][4])? $header['logo'][4] : '0px' ;
            }

            if(isset($header['title']) && $header['title']) {
                $headertitle=isset($header['title'][0])?$header['title'][0] : '' ;
                $t_font=isset($header['title'][1])?$header['title'][1] : '' ;
                $t_fontsize=isset($header['title'][2])?$header['title'][2] : '14' ;
                $t_weight=isset($header['title'][3])?strtoupper($header['title'][3]) : '' ;
                switch($t_weight) {
                    case'B': {
                            $t_fontweight=' bold';
                            break;
                        }
                    case'BI':
                    case'IB': {
                            $t_fontweight=' bold; font-style: italic ';
                            break;
                        }
                    case'I': {
                            $t_fontweight=' normal; font-style: italic ';
                            break;
                        }
                    default: {
                            $t_fontweight=' normal ';
                            break;
                        }
                }
                $t_float=isset($header['title'][4])? strtoupper($header['title'][4]) : '' ;
                switch($t_float) {
                    case 'R': {
                            $t_float='right';
                            break;
                        }
                    case 'L': {
                            $t_float='left';
                            break;
                        }
                    default: {
                            $t_float='center';
                            break;
                        }
                }
                $t_padding=isset($header['title'][5])? $header['title'][5] : '0px' ;
                $t_color=isset($header['title'][6])? $header['title'][6] : 'black' ;
            }

            if(isset($header['string']) && $header['string']) {
                $headerstring=isset($header['string'][0])?$header['string'][0] : '' ;
                $s_font=isset($header['string'][1])?$header['string'][1] : '' ;
                $s_fontsize=isset($header['string'][2])?$header['string'][2] : '11' ;
                $s_weight=isset($header['string'][3])? strtoupper($header['string'][3]) : '' ;
                switch($s_weight) {
                    case'B': {
                            $s_fontweight=' bold';
                            break;
                        }
                    case'BI':
                    case'IB': {
                            $s_fontweight=' bold; font-style: italic ';
                            break;
                        }
                    case'I': {
                            $s_fontweight=' normal; font-style: italic ';
                            break;
                        }
                    default: {
                            $s_fontweight=' normal ';
                            break;
                        }
                }
                $s_float=isset($header['string'][4])? strtoupper($header['string'][4]) : '' ;
                switch($s_float) {
                    case 'R': {
                            $s_float='right';
                            break;
                        }
                    case 'L': {
                            $s_float='left';
                            break;
                        }
                    default: {
                            $s_float='center';
                            break;
                        }
                }
                $s_padding=isset($header['string'][5])? $header['string'][5] : '0px' ;
                $s_color=isset($header['string'][6])? $header['string'][6] : 'black' ;
            }

            if(isset($header['substring']) && $header['substring']) {
                $headersubstring=$header['substring'];
            }
        }



        echo '<div class="header" style="height:'.$headerheight.'px; '.$border.' ">';

        echo '<div class="header_content">';

        if($headerlogo) {
            echo '<div class="rep_logo"
                                        >'.Html::img('images/test.jpeg', ['class'=>'logo','style'=>'
                                                width:'.$l_width.'px;
                                                float:'.$l_float.';
                                                margin:'.$l_padding.';']).'
                                          </div>';
            $headertext='float:left;';
        }


        echo '<div class="header_holder" style="height:'.$headerheight.'px; '.$headertext.'">';
        echo '<div class="rep_title"
                                                                style="
                                                                font-family:'.$t_font.';
                                                                font-weight:'.$t_fontweight.';
                                                                font-size:'.$t_fontsize.'px;
                                                                text-align:'.$t_float.';
                                                                color:'.$t_color.';
                                                                padding:'.$t_padding.';"
                                                >'.$headertitle.'</div>';
        echo '<div class="rep_string"
                                                                style="
                                                                font-family:'.$s_font.';
                                                                font-weight:'.$s_fontweight.';
                                                                font-size:'.$s_fontsize.'px;
                                                                text-align:'.$s_float.';
                                                                color:'.$s_color.';
                                                                padding:'.$s_padding.';">'.$headerstring.'<br />'.$headersubstring.'</div>';
        echo '</div>';
        
        echo '</div>';


        echo '</div>';
        echo '<div class="clear"></div>';

    }

    function printline(){
        echo '<hr>';
    }
    
    function pagenumber($txt=''){
         echo '<td>'.$txt.' <span id="pagenumber"></span></td>';
    }
}