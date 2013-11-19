<?php

namespace Controlcar\JournalBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DoxgenerationController extends Controller
{
    private $_zipObject; //Для открытия zip-архива
    private $_tmpFilename; //Имя временного файла, создаваемого при работе класса
    private $_docxContent; //Хранит содержимое ./word/document.xml

    public function __construct($filename){
        //Конструтор класса, берет шаблон $filename

        //1) Создаем копию шаблона для безопасной работы

        $this->_tmpFilename = dirname($filename).'/'.time().'.docx'; // Функция dirname извлекает путь к каталогу с файлом filename
        copy($filename, $this->_tmpFilename); // Копируем содержимое шаблона во временный файл

        //2) С помощью встроенного в PHP класса вытаскиваем содержимое
        $this->_zipObject = new \ZipArchive(); //Создали экземпляр класса для работы с Zip-архивом
        $this->_zipObject->open($this->_tmpFilename); //Открыли временный файл архиватором, т.к. docx - это и есть архив
        $this->_docxContent = $this->_zipObject->getFromName('word/document.xml'); //Вытащили текст документа с разметкой из файла ./word/document.xml внутри архива
    }//__construct/

    public function val($search, $replace) {
        //Функция замены меток с названием $search на значение $replace
        $search = '&amp;'.$search.';'; //Прибавляем амперсанд в виде специального символа и точку с запятой
        $replace = htmlspecialchars($replace); //Заменяем все спецсимволы в добавляемом тексте на их веб-эквивалент
        $this->_docxContent = str_ireplace($search, $replace, $this->_docxContent); //Собственно процесс замены это обычная замена подстрок в текстовом документе
    }//val

    public function save($filename){
        //Сохраняет полученный из шаблона файл с именем $filename. Существующие файлы перезаписываются.

        //1) Если файл $filename уже существует, то нужно его удалить
        if(file_exists($filename)){
            unlink($filename);
        }//if file_exists

        //2) Дописываем измененное xml-содержимое в документ
        $this->_zipObject->addFromString('word/document.xml', $this->_docxContent);

        //3) Пытаемся сохранить изменения
        if($this->_zipObject->close() === false){
            throw new Exception('Не удалось сохранить изменения в документе.');
        }//if close
        rename($this->_tmpFilename, $filename);
    }//save

    public function ukr_date($param, $time=0)
    {
        if(intval($time)==0)
            $time=time();
        $MonthNames=array("Січня", "Лютого", "Березня", "Квітня", "Травня", "Червня", "Липня", "Серпня", "Вересня", "Жовтня", "Листопада", "Грудня");
        if(strpos($param,'M')===false)
        {
            return date($param, $time);
        }else
        {
            $mounth = date('n',(int)$time)-1;
            return date(str_replace('M',$MonthNames[$mounth],$param), (int)$time);
        }
    }

    public function num2str($num)
    {
        $nul='ноль';
        $ten=array(
            array("", "один", "два", "три", "чотири", "п'ять", "шість", "сім", "вісім", "дев'ять"),
            array("", "одна", "дві", "три", "чотири", "п'ять", "шість", "сім", "вісім", "дев'ять"),
        );
        $a20=array("десять", "одинадцять", "дванадцять", "тринадцять", "чотирнадцять", "п'ятнадцять", "шістнадцять", "сімнадцять", "вісімнадцять", "дев'ятнадцять");
        $tens=array(2=>"двадцять", "тридцять", "сорок", "п'ятьдесят", "шістьдесят", "сімдесят", "вісімдесят", "дев'яносто");
        $hundred=array('',"сто", "двісті", "триста", "чотиреста", "п'ятсот", "шістсот", "сімсот", "вісімсот", "дев'ятсот");
        $unit=array( // Units
            array('копійка', 'копійки', 'копійок',	 1),
            array('гривня'   ,'гривні'   ,'гривень'    ,0),
            array('тисяча' ,' тисячі ',' тисяч '     ,1),
            array('мільйон', 'мільйона', 'мільйонів' ,0),
            array('мільярд', 'мільярд', 'мільярдів',0),
        );
        //
        list($rub,$kop) = explode('.',sprintf("%015.2f", floatval($num)));
        $out = array();
        if (intval($rub)>0) {
            foreach(str_split($rub,3) as $uk=>$v) { // by 3 symbols
                if (!intval($v)) continue;
                $uk = sizeof($unit)-$uk-1; // unit key
                $gender = $unit[$uk][3];
                list($i1,$i2,$i3) = array_map('intval',str_split($v,1));
                // mega-logic
                $out[] = $hundred[$i1]; # 1xx-9xx
                if ($i2>1) $out[]= $tens[$i2].' '.$ten[$gender][$i3]; # 20-99
                else $out[]= $i2>0 ? $a20[$i3] : $ten[$gender][$i3]; # 10-19 | 1-9
                // units without rub & kop
                if ($uk>1) $out[]= $this->morph($v,$unit[$uk][0],$unit[$uk][1],$unit[$uk][2]);
            } //foreach
        }
        else $out[] = $nul;
        $out[] = $this->morph(intval($rub), $unit[1][0],$unit[1][1],$unit[1][2]); // rub
        $out[] = $kop.' '.$this->morph($kop,$unit[0][0],$unit[0][1],$unit[0][2]); // kop
        return trim(preg_replace('/ {2,}/', ' ', join(' ',$out)));
    }

    /**
     * Склоняем словоформу
     * @ author runcore
     */
    public function morph($n, $f1, $f2, $f5) {
        $n = abs(intval($n)) % 100;
        if ($n>10 && $n<20) return $f5;
        $n = $n % 10;
        if ($n>1 && $n<5) return $f2;
        if ($n==1) return $f1;
        return $f5;
    }
}