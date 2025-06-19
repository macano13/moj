<?php
    require $_SERVER['DOCUMENT_ROOT'].'/tcpdf/tcpdf.php';
    if (IS_POST() && isset($_POST['downloadPdfId'])) {

        $downloadPdfId = $_POST['downloadPdfId'];
        $result = db_getInvoiceById($downloadPdfId);

        foreach ($result as $key => $value) {
           $email = $value->email;
           $name = $value->name;
           $expire_date = $value->expire_date;
           $invoice_id = $value->invoice_id;
           $amount = $value->amount;
           $invoiceCreatedAt = $value->invoice_created_date;
       }

        $html = '
        <style>
        table, tr, td {
        padding: 15px;
        }
        </style>
        <table style="background-color: #222222; color: #fff">
        <tbody>
        <tr>
        <td><h1>INVOICE<strong> #'.$invoice_id.'</strong></h1></td>	
        </tr>
        </tbody>
        </table>
        ';
        $html .= '
        <table>
        <tbody>
        <tr>
        <td>Invoice to<br/>
        <strong>'.$name.'</strong><br/>
        <strong>'.$email.'</strong>
        </td>
        <td align="right">
        <strong>Total Due: €'.$amount.'</strong><br/>
        Invoice Date: '.$invoiceCreatedAt.'
        </td>
        </tr>
        </tbody>
        </table>
        ';
        $html .= '
        <table>
        <thead>
        <tr style="font-weight:bold;">
        <th>SL</th>
        <th>Item Name</th>
        <th>Month</th>
        <th>Price</th>
        <th>Total</th>
        </tr>
        </thead>
        <tbody>';
        
        $html .= '
        <tr>
        <td style="border-bottom: 1px solid #222">1</td>
        <td style="border-bottom: 1px solid #222">Monthly Subscriptions</td>
        <td style="border-bottom: 1px solid #222">One (1)</td>
        <td style="border-bottom: 1px solid #222">€'.$amount.'</td>
        <td style="border-bottom: 1px solid #222">€'.$amount.'</td>
        </tr>
        ';
        $html .='
        <tr align="right">
        <td colspan="5"><strong>Grand total: €'.$amount.'</strong></td>
        </tr>
        <tr>
        <td colspan="4">
        <h2>Thank you.</h2><br/>
         <p>vip.translatesubtitles.co</p>
        </td>
        </tr>
        </tbody>
        </table>
        ';

        // create new PDF document
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        // set margins
        $pdf->SetMargins(-1, 0, -1);
        
        // remove default header/footer
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        
        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        
        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        // set default font subsetting mode
        $pdf->setFontSubsetting(true);
        
        $pdf->AddPage();
        
        // Print text using writeHTMLCell()
        $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 0, 0, true, '', true);

        $pdf_name = ''.$name.time().'.pdf';
        ob_end_flush();
        $pdf->Output(dirname(__FILE__).'/invoice/'.$pdf_name.'', 'D');
    }
?>