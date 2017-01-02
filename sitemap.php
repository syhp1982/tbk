<?php
header("Content-Type:text/xml ");
//html文件要用下面这个头，不然在某些浏览器会显示空白。
header('Content-type:text/html; charset=utf-8'); 
$f = new SaeFetchurl();
$data = $f->fetch("http://1668s-public.stor.sinaapp.com/sitemap.xml");
echo $data;
?>