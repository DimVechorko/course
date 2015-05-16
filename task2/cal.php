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
        $small = ncurses_newwin(11, 26, 7, 26);
        ncurses_wborder($small, 0, 0, 0, 0, 0, 0, 0, 0);
        ncurses_mvwaddstr($small, 1, 9, "$this->year,");
        $month = $this->month;
        ncurses_mvwaddstr($small, 1, 14, "$arrMonths[$month]");
        $j = 0; //позиция в строке
        $pos = 4; //позиция строки
        foreach ($array as $arr) {
            $j += 3;
            ncurses_mvwaddstr($small, 3, $j, "$arr"); //выводим имена дней недели
        }
        $j = 0;
        for ($i = 1; $i <= $this->numberDay - 1; $i++) {
            $j += 3;
            ncurses_mvwaddstr($small, $pos, $j, "  ");
        }
        $c = $this->numberDay; //день недели
        for ($i = 1; $i <= $this->amountDay; $i++) {
            if ($c <= 7) {
                $j += 3;
                ncurses_mvwaddstr($small, $pos, $j, "$i");
            } else {
                $pos += 1;
                $j = 3;
                ncurses_mvwaddstr($small, $pos, $j, "$i");
                $c = 1;
            }
            $c++;
        }
        ncurses_wrefresh($small);
    }
}

class Output extends Calendar
{
    function out_window()
    {
        // начинаем с инициализации библиотеки
        ncurses_init();
        // используем весь экран
        ncurses_newwin(0, 0, 0, 0);
        $lower_win = ncurses_newwin(4, 26, 18, 26);
        ncurses_mvwaddstr($lower_win, 1, 1, "листание года");
        ncurses_mvwaddstr($lower_win, 2, 1, "листание месяца");
        // рисуем рамку вокруг окна
        ncurses_border(0, 0, 0, 0, 0, 0, 0, 0);
        ncurses_refresh(); // рисуем окна
        ncurses_wrefresh($lower_win);
        $this->currentDate();

        while (true) {
            $pressed = ncurses_getch();
            if ($pressed == 27) {
                break;
            }

            switch ($pressed) {
                case NCURSES_KEY_UP:
                    $this->year += 1;
                    break;
                case NCURSES_KEY_DOWN:
                    $this->year -= 1;
                    break;
                case NCURSES_KEY_RIGHT:
                    $this->month += 1;
                    break;
                case NCURSES_KEY_LEFT:
                    $this->month -= 1;
                    break;
            }

            $this->currentDate();
        }
        ncurses_end(); // выходим из режима ncurses, чистим экран
    }
}

$output = new Output();
$out_window = $output->out_window();


