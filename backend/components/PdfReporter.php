<?php
namespace app\components;

use Yii;
use yii\base\Component;
use Dompdf\Dompdf;
use Dompdf\Options;

///RENDERS EXISTING REPORT VIEWS AS DOWNLOADABLE PDF (ALTERNATIVE TO window.print())
///USAGE IN A REPORT ACTION:
///  if(Yii::$app->pdfreporter->wantsPdf()){
///      return Yii::$app->pdfreporter->renderPdf($this, $view, $params, 'SJ-123.pdf');
///  }
class PdfReporter extends Component
{
    //PAPER SETTINGS - LETTER MATCHES THE 800px LAYOUTS, 'legal'/'A4' ALSO VALID
    public $paper = 'letter';
    public $orientation = 'portrait';

    public function wantsPdf(){
        return (($_POST['output'] ?? $_GET['output'] ?? '') === 'pdf');
    }

    public function renderPdf($controller, $view, $params, $filename = 'report.pdf'){
        //CAPTURE THE EXISTING VIEW EXACTLY AS THE BROWSER WOULD RECEIVE IT (NO LAYOUT/JS)
        $body = $controller->renderPartial($view, $params);

        $html = '<!DOCTYPE html><html><head><meta charset="utf-8"><style>
            body { margin: 0; font-family: sans-serif; }
            #print_btn, .btn_a, .noprint { display: none !important; }
            table { border-collapse: collapse; }
        </style></head><body>' . $body . '</body></html>';

        $options = new Options();
        $options->set('isRemoteEnabled', true); //LETTERHEAD IMAGES USE homeUrl SRC
        $options->set('chroot', Yii::getAlias('@app'));

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper($this->paper, $this->orientation);
        $dompdf->render();

        $response = Yii::$app->response;
        $response->format = \yii\web\Response::FORMAT_RAW;
        $response->headers->set('Content-Type', 'application/pdf');
        $response->headers->set('Content-Disposition', 'inline; filename="' . $filename . '"');
        $response->content = $dompdf->output();
        return $response;
    }
}
