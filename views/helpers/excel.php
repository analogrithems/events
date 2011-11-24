<?php 
//App::import('Lib','PHPExcel',array('file' => 'excel/PHPExcel.php'));
//App::import('Lib','PHPExcelWriter',array('file' => 'excel/PHPExcel/Writer/Excel5.php'));

App::import('Lib','PHPExcel',array('file' => 'excel/PHPExcel.php'));
App::import('Lib','PHPExcelWriter',array('file' => 'excel/PHPExcel/Writer/Excel2007.php'));

class ExcelHelper extends AppHelper {
    
    var $xls;
    var $sheet;
    var $data;
    var $blacklist = array();
    
    function excelHelper() {
        $this->xls = new PHPExcel();
        $this->sheet = $this->xls->getActiveSheet();
        $this->sheet->getDefaultStyle()->getFont()->setName('Verdana');
    }
                 
    function generate(&$data, $title = 'Report') {
         $this->data =& $data;
         $this->_title($title);
         $this->_headers();
         $this->_rows();
         $this->_output($title);
         return true;
    }
    
    function _title($title) {
        $this->sheet->setCellValue('A2', $title);
        $this->sheet->getStyle('A2')->getFont()->setSize(14);
        $this->sheet->getRowDimension('2')->setRowHeight(23);
    }

    function _headers() {
        $i=0;
        foreach ($this->data[0] as $field => $value) {
	    $this->log("setting column field: {$field}",'debug');
            if (!in_array($field,$this->blacklist)) {
                $columnName = Inflector::humanize($field);
                $this->sheet->setCellValueByColumnAndRow($i++, 4, $columnName);
            }
        }
        $this->sheet->getStyle('A4')->getFont()->setBold(true);
        $this->sheet->getStyle('A4')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
        $this->sheet->getStyle('A4')->getFill()->getStartColor()->setRGB('969696');
        $this->sheet->duplicateStyle( $this->sheet->getStyle('A4'), 'B4:'.$this->sheet->getHighestColumn().'4');
        for ($j=1; $j<$i; $j++) {
            $this->sheet->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($j))->setAutoSize(true);
        }
    }
        
    function _rows() {
        $i=5;
        foreach ($this->data as $row) {
            $j=0;
            foreach ($row as $field => $value) {
                if(!in_array($field,$this->blacklist)) {
                    $this->sheet->setCellValueByColumnAndRow($j++,$i, $value);
                }
            }
            $i++;
        }
    }
            
	//Replace the _output function with this one:
	function _output($title) {
	    header('Content-Type: application/vnd.openXMLformats-officedocument.spreadsheetml.sheet');
	    header('Content-Disposition: attachment;filename="'.$title.'.xlsx"');
	    header('Cache-Control: max-age=0');
	    $objWriter = new PHPExcel_Writer_Excel2007($this->xls);
	    $objWriter->save('php://output');
	} 
}
?> 
