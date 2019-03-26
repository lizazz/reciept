<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
    <!--[if gte mso 9]><xml><o:OfficeDocumentSettings><o:AllowPNG/><o:PixelsPerInch>96</o:PixelsPerInch></o:OfficeDocumentSettings></xml><![endif]-->
    <title>tsn-media</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://fonts.googleapis.com/css?family=Comfortaa:400,700&amp;subset=cyrillic,cyrillic-ext" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Fredericka+the+Great" rel="stylesheet">
    <style type="text/css">
        a{
            outline:none;
            color: #50cfcc;
            text-decoration:none;
            cursor: pointer;
        }
        a:hover{text-decoration: underline !important;}
        .h-u a{text-decoration:none;}
        .h-u a:hover{text-decoration:none !important;}
        a[x-apple-data-detectors]{color:inherit !important; text-decoration:none !important;}
        a[href^="tel"]:hover{text-decoration:none !important;}
        .active-i a:hover,
        .active-t:hover{opacity:0.8;}
        .active-i a,
        .active-t{transition:all 0.3s ease;}
        .style-for-bg{    background-position: 50% 100% !important; background-size: cover !important;}
        a img{border:none;}
        b, strong{font-weight:700;}
        th{padding:0;}
        table td{mso-line-height-rule:exactly;}
        .ns span, .ns a{color:inherit !important; text-decoration:none !important; border:none !important;}
        ul{Margin:0 0 0 20px; padding:0;}
        .tpl-content{padding:0 !important;}
        .cke_show_borders{background:#e4e4e4 !important;}
        .tpl-repeatmovewrap > .tpl-repeatmove{top:-15px !important;}
        .ii a[href] {
            color: #50cfcc !important;
        }
        [style*="Comfortaa"]{font-family:Comfortaa, Arial, Helvetica, sans-serif !important;}
        @media only screen and (max-width:375px) and (min-width:374px) {
            .gmail-fix{min-width:374px !important;}
        }
        @media only screen and (max-width:414px) and (min-width:413px) {
            .gmail-fix{min-width:413px !important;}
        }
        @media only screen and (max-width:600px){
            .w-100p{width:100%!important;}
            .tflex{display:block!important;width:100%!important;box-sizing:border-box!important;}
            .ta-c{text-align:center!important;}
            .w-a{width:auto!important;}
            .p-over{padding: 15px !important;}
            .hm {display: none !important;}
        }
    </style>
    <style type="text/css">
        @import url('https://fonts.googleapis.com/css?family=Comfortaa:400,700&amp;subset=cyrillic,cyrillic-ext');
    </style>
</head>
<body style="background:#fff; margin:0; padding:0; -webkit-text-size-adjust:100%; -ms-text-size-adjust:100%;">
<table class="gmail-fix" width="100%" style="background:#fff; min-width:320px;" cellspacing="0" cellpadding="0">
    <tr>
        <td>
            <table class="w-100p" width="600" align="center" style="max-width:600px; margin:0 auto;" cellpadding="0" cellspacing="0">
                @include('emails.parts.header')
                @yield('body')
                @include('emails.parts.footer')
            </table>
        </td>
    </tr>
</table>

</body>
</html>