#!/usr/bin/php5
<?php

class Calendar
{
    public $month;
    public $year;
    protected $amountDay;
    protected $numberDay;
    protected $countDays;

    function __construct()
    {
        $this->month = date('n');
        $this->year = date('o');
    }

    function buildCal()
    {
        if ($this->month > 12) {
            $this->month = 1;
            $this->year += 1;
        }
        if ($this->month == 0) {
            $this->month = 12;
            $this->year -= 1;
        }
        $this->amountDay = date('t', mktime(0, 0, 0, $this->month, 1, $this->year)); //кол-во дней в месяце
        $this->numberDay = date('N', mktime(0, 0, 0, $this->month, 1, $this->year)); //определяем день недели 1oгo числа текщего месяца
        $array = array("1" => "ПН", "ВТ", "СР", "ЧТ", "ПТ", "СБ", "ВС");
        $arrMonths = array("1" => "Январь", "Февраль", "Март", "Апрель", "Май", "Июнь", "Июль", "Август", "Сентябрь", "Октябрь", "Ноябрь", "Декабрь");
        $main_win = ncurses_newwin(11, 26, 7, 26);
        ncurses_wborder($main_win, 0, 0, 0, 0, 0, 0, 0, 0);
        ncurses_mvwaddstr($main_win, 1, 9, "$this->year,");
        $month = $this->month;
        ncurses_mvwaddstr($main_win, 1, 14, "$arrMonths[$month]");
        $posinrow = 0; //позиция в строке
        $posstr = 4; //позиция строки
        foreach ($array as $arr) {
            $posinrow += 3;
            ncurses_mvwaddstr($main_win, 3, $posinrow, $arr); //выводим имена дней недели
        }
        $posinrow = 0;
        for ($i = 1; $i <= $this->numberDay - 1; $i++) {
            $posinrow += 3;
            ncurses_mvwaddstr($main_win, $posstr, $posinrow, "  ");
        }
        $weekday = $this->numberDay; //день недели
        for ($i = 1; $i <= $this->amountDay; $i++) {
            if ($weekday <= 7) {
                $posinrow += 3;
                ncurses_mvwaddstr($main_win, $posstr, $posinrow, $i);
            } else {
                $posstr += 1;
                $posinrow = 3;
                ncurses_mvwaddstr($main_win, $posstr, $posinrow, $i);
                $weekday = 1;
            }
            $weekday += 1;
        }
        ncurses_wrefresh($main_win);
    }

    function outputWindows()
    {
        // используем весь экран
        ncurses_newwin(0, 0, 0, 0);
        //создаем нижнее окно под основным
        $lower_win = ncurses_newwin(4, 26, 17, 26);
        ncurses_mvwaddstr($lower_win, 1, 1, "листание года");
        ncurses_mvwaddstr($lower_win, 2, 1, "листание месяца");
        ncurses_mvwaddstr($lower_win, 3, 1, "ESC - выход");
        // рисуем рамку вокруг окна
        ncurses_border(0, 0, 0, 0, 0, 0, 0, 0);
        ncurses_refresh(); // рисуем окна
        ncurses_wrefresh($lower_win); //рисуем нижнее окно
        $this->buildCal();
    }
}

ncurses_init(); //инициализация библиотеки
$calendar = new Calendar();
$calendar->outputWindows();
define ("ESC", 27);
while (true) {
    $pressed = ncurses_getch();
    if ($pressed == ESC) {
        break;
    }

    switch ($pressed) {

        case NCURSES_KEY_UP:
            $calendar->year += 1;
            break;
        case NCURSES_KEY_DOWN:
            $calendar->year -= 1;
            break;
        case NCURSES_KEY_RIGHT:
            $calendar->month += 1;
            break;
        case NCURSES_KEY_LEFT:
            $calendar->month -= 1;
            break;
    }
    $calendar->outputWindows();
}
ncurses_end(); //выходим из режима ncurses, чистим экран


