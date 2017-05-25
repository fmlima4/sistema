
<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class m_pdf {
    
    function index()
    {
        $CI = & get_instance();
        log_message('Debug', 'mPDF class is loaded.');
    }
 
    function load($param=NULL)
    {
        include_once APPPATH.'/third_party/mpdf/mpdf.php';
         
        if ($params == NULL)
        {
            $param = '"UTF-8","A4","","",10,10,10,10,6,3,P';          
        }
         
        return new mPDF($param);
    }
}