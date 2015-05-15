#!/usr/bin/php5
<?php

class Calendar
{
    protected $month;
    protected $year;
    protected $amountDay;
    protected $numberDay;
    protected $countDays;

    function __construct()
    {
        $this->month = date('n');
        $this->year = date('o');
    }

    function currentDate()
    {
        if ($this->month > 12) {
            $this->month = "1";
            $this->year += "1";
        }
        if ($this->month == 0) {
            $this->month = "12";
            $this->year -= "1";
        }
        $this->amountDay = date('t', mktime(0, 0, 0, $this->month, 1, $this->year)); //кол-во дней в месяце
        $this->numberDay = date('N', mktime(0, 0, 0, $this->month, 1, $this->year)); //определяем день недели 1ргр числа текщего месяца
        $array = array("1" => "ПН", "ВТ", "СР", "ЧТ", "ПТ", "СБ", "ВС");
        $arrMonths = array("1" => "Январь", "Февраль", "Март", "Апрель", "Май", "Июнь", "Июль", "Август", "Сентябрь", "Октябрь", "Ноябрь", "Декабрь");
        $small = ncurses_newwin(11, 26, 7, 26);
        $small_2 = ncurses_newwin(4, 26, 18, 26);
        ncurses_wborder($small, 0, 0, 0, 0, 0, 0, 0, 0);
        ncurses_wborder($small_2, 0, 0, 0, 0, 0, 0, 0, 0);
        ncurses_mvwaddstr($small, 1, 9, "$this->year,");
        $month = $this->month;
        ncurses_mvwaddstr($small, 1, 14, "$arrMonths[$month]");
        $i = "";
        foreach ($array as $arr) {
            $i++;
            $i = $i + 2;
            ncurses_mvwaddstr($small, 3, $i, "$arr");
        }
        $daysFirstWeek = array();
        if ($this->numberDay != 1) {
            $pos = "4";
        }
        $j = "";
        for ($i = 1; $i <= $this->numberDay - 1; $i++) {
            $j++;
            $j = $j + 2;
            ncurses_mvwaddstr($small, $pos, $j, "  "); //вывод 1ой недели месяца
        }
        for ($i = 1; $i <= 8 - $this->numberDay; $i++) {
            array_push($daysFirstWeek, $i);
            $j = $j + 3;
            ncurses_mvwaddstr($small, 4, $j, "$i"); //вывод 1ой недели месяца
        }

        $this->countDays = count($daysFirstWeek) + 1;
        $amountItr = array();
        $j = "";
        $pos = "5";
        for ($i = $this->countDays; $i <= $this->amountDay; $i++) {
            array_push($amountItr, $i);
            $countItr = count($amountItr);
            $j++;
            $j = $j + 2;
            if ($countItr % 7 == 0) {
                ncurses_mvwaddstr($small, $pos, $j, "$i"); //вывод последнего дня недели
                $pos = $pos + 1;
                $j = "";
            } else {
                ncurses_mvwaddstr($small, $pos, $j, "$i"); //вывод дней недели
            }
        }
        ncurses_mvwaddstr($small_2, 1, 1, "<- -> -листание месяца $str");
        ncurses_mvwaddstr($small_2, 2, 1, "^  -листание года $str");
        ncurses_wrefresh($small);
        ncurses_wrefresh($small_2);
    }
}

class Output extends Calendar
{
    function out_window()
    {
        // начинаем с инициализации библиотеки
        ncurses_init();
        ncurses_savetty();
        // используем весь экран
        ncurses_newwin(0, 0, 0, 0);
        // рисуем рамку вокруг окна
        ncurses_border(0, 0, 0, 0, 0, 0, 0, 0);
        ncurses_refresh(); // рисуем окна
        parent::currentDate();
        while (true) {
            $pressed = ncurses_getch();
            if ($pressed == 27) {
                break;
            }

            switch ($pressed) {
                case NCURSES_KEY_UP:
                    $this->year += "1";
                    parent::currentDate();
                    break;
                case NCURSES_KEY_DOWN:
                    $this->year -= "1";
                    parent::currentDate();
                    break;
                case NCURSES_KEY_RIGHT:
                    $this->month += "1";
                    parent::currentDate();
                    break;
                case NCURSES_KEY_LEFT:
                    $this->month -= "1";
                    parent::currentDate();
                    break;
            }
        }
        ncurses_end(); // выходим из режима ncurses, чистим экран
    }
}

$output = new Output();
$left_window = $output->out_window();


