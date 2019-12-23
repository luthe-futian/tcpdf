# tcpdf
1.composer require topthink/framework 6.2

2.pdf支持中文

  droidsansfallback.php、droidsansfallback.z以及droidsansfallback.ctg.z放到TCPDF\fonts 下面即可
  
3.配置tcpdf\config\tcpdf_config.php

define ('PDF_FONT_NAME_MAIN', 'stsongstdlight');

4.可选属性

  [
  
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
    ]
    html 一个元素为一页
  
  5. $pdf = new Pdf();
  
  6.$table = [
            'html' => ['html','html'],
            'size' => 'A4',
            'output' => 'F',
            'filename' => '公司汇率表.pdf'
        ];
  
  7.$pdf->pdf($table);
