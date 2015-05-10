#!/usr/bin/php5
<?php
class Calendar
{
    protected $month; //текущий месяц
    protected $year; //текущий год
    protected $amountDay; //кол-во дней в месяце от 28 до 31
    protected $numberDay; //определяем день недели 1ого числа текущего месяца
    protected $countDays; //кол-во дней в 1ой неделе
    function __construct()
    {
        $this->month = date('n'); //номер текущего месяца
        $this->year = date('o'); //год
    }

    function currentDate()
    {
        $this->amountDay = date('t', mktime(0, 0, 0, $this->month, 1, $this->year)); //кол-во дней в месяце от 28 до 31
        $this->numberDay = date('N', mktime(0, 0, 0, $this->month, 1, $this->year)); /* определяем день недели 1ого числа текущего месяца*/

        $array = array("1" => "ПН", "ВТ", "СР", "ЧТ", "ПТ", "СБ", "ВС");
        $arrMonths = array("1" => "Январь", "Февраль", "Март", "Апрель", "Май", "Июнь", "Июль", "Август", "Сентябрь", "Октябрь", "Ноябрь", "Декабрь");
        printf("[%s]\n",$this->year);
        echo sprintf("[%s]\n",$arrMonths[$this->month]);
        foreach ($array as $arr) {
            printf ("[%s]",$arr);
        }
        echo "\n";
    }

    function firstWeek()
    {
        $daysFirstWeek = array();
        if ($this->numberDay != 1) {
            for ($i = 1; $i <= $this->numberDay - 1; $i++) {
                printf("[%2.2s]"," ");
            }
            for ($i = 1; $i <= 8 - $this->numberDay; $i++) {
                array_push($daysFirstWeek, $i);
                printf("[%2.2s]",$i);
            }
        }
        $this->countDays = count($daysFirstWeek) + 1; //кол-во дней в 1ой неделе
        echo "\n";
    }

    function nextWeeks()
    {
        $amountItr=array();
        for($i=$this->countDays;$i<=$this->amountDay;$i++){
            array_push($amountItr,$i); //после каждой итерации добавляется 1 элемент в массив $amountItr
            $countItr=count($amountItr); // количество элементов в массиве $amountItr
            if($countItr%7==0){
                printf("[%2.2s]\n",$i);
            }else{
                printf("[%2.2s]",$i);                                                                      //
            }
        }
    }
}

$calendar = new Calendar();
$currentDate = $calendar->currentDate();
$firstWeek = $calendar->firstWeek();
$nextWeeks = $calendar->nextWeeks();
