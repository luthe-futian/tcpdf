<?php

namespace app\index\controller;

use TCPDF;

class Pdf extends Base
{
    /**
     * @param array $param =[
     *  'html'=>[] //三维数组,
     * 'size'=>
     * ]
     */
    public function pdf($param)
    {
        $param = $param + [
                'html' => [],
                'size' => 'A3',
                'author' => '',
                'creator' => '',
                'title' => '',
                'header' => false, //页眉
                'footer' => true,  //页脚
                'subject' => '',
                'keywords' => '',
                'output' => 'F',
                'filename' => '' //默认upload下，可以创建目录 pdf/aaa.pdf
            ];
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, $param['size'], true, 'UTF-8', false);

        // set document information
        $pdf->SetCreator($param['creator']);
        $pdf->SetAuthor($param['author']);
        $pdf->SetTitle($param['title']);
        $pdf->SetSubject($param['subject']);
        $pdf->SetKeywords($param['keywords']);
        $pdf->setPrintHeader($param['header']); //设置打印页眉
        $pdf->setPrintFooter($param['footer']); //设置打印页脚
        // set default header data
        $pdf->SetHeaderData('', PDF_HEADER_LOGO_WIDTH, '' . ' ', '');

        // set header and footer fonts
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        $pdf->SetMargins(10, PDF_MARGIN_TOP, 10);
        //header$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        if (!empty($param['html'])) {
            foreach ($param['html'] as $v) {
                $pdf->AddPage();

                $pdf->writeHTML($v, true, false, false, false, '');
            }
            $pdf->lastPage();
        }
        $root_path = app()->getRootPath();
        $file = $root_path.'upload/pdf/'.$param['filename'];
        try{
            if (file_exists($file)) { //文件已经存在
                unlink($file); //删除旧目录下的文件
                $pdf->Output($file, $param['output']);
            } else {
                $this->createdir('pdf/'.$param['filename']);
                $pdf->Output($file, $param['output']);
            }
            return true;
        }catch(\Exception $e){
            return false;
        }
    }
    /**
     * 创建文件夹
     * 指向根路径
     */
    function createdir($path, $oi = 1)
    {
        $zpath = explode('/', $path);
        $len = count($zpath);
        $mkdir = '';
        for ($i = 0; $i < $len - $oi; $i++) {
            if (!$this->isempt($zpath[$i])) {
                $mkdir .= '/' . $zpath[$i] . '';
                $wzdir = app()->getRootPath() . 'upload' . '' . $mkdir;
                if (!is_dir($wzdir)) {
                    mkdir($wzdir);
                }
            }
        }
    }
    function isempt($str)
    {
        $bool = false;
        if (($str == '' || $str == NULL || empty($str)) && (!is_numeric($str))) $bool = true;
        return $bool;
    }

}