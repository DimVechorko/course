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

    function construction()
    {
        $this->amountDay = date('t', mktime(0, 0, 0, $this->month, 1, $this->year));
        $this->numberDay = date('N', mktime(0, 0, 0, $this->month, 1, $this->year));
        $array = array("1" => "ПН", "ВТ", "СР", "ЧТ", "ПТ", "СБ", "ВС");
        $arrMonths = array("1" => "Январь", "Февраль", "Март", "Апрель", "Май", "Июнь", "Июль", "Август", "Сентябрь", "Октябрь", "Ноябрь", "Декабрь");
        // создаём второе окно
        $small = ncurses_newwin(10, 26, 7, 26);
        // рамка для него
        ncurses_wborder($small, 0, 0, 0, 0, 0, 0, 0, 0);
        // пишем в маленьком окне
        ncurses_mvwaddstr($small, 1, 9, "$this->year,");
        $month = $this->month;
        // пишем в маленьком окне
        ncurses_mvwaddstr($small, 1, 14, "$arrMonths[$month]");
        $i = "";
        foreach ($array as $arr) {
            $i++;
            $i = $i + 2;
            // пишем в маленьком окне
            ncurses_mvwaddstr($small, 3, $i, "$arr");
        }
        $daysFirstWeek = array();
        if ($this->numberDay != 1) {
            $j = "";
            for ($i = 1; $i <= $this->numberDay - 1; $i++) {
                $j++;
                $j = $j + 2;
                ncurses_mvwaddstr($small, 4, $j, "  ");
            }
            for ($i = 1; $i <= 8 - $this->numberDay; $i++) {
                array_push($daysFirstWeek, $i);
                $j = $j + 3;
                ncurses_mvwaddstr($small, 4, $j, "$i");
            }
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
                ncurses_mvwaddstr($small, $pos, $j, "$i");
                $pos = $pos + 1;
                $j = "";
            } else {
                ncurses_mvwaddstr($small, $pos, $j, "$i");
            }
        }
        // обновляем маленькое окно для вывода строки
        ncurses_wrefresh($small);
        //unset($month);
        //unset($year);
    }
}

class Output extends Calendar
{
    function left_window()
    {

        ncurses_init();// начинаем с инициализации библиотеки
        ncurses_newwin(0, 0, 0, 0);// используем весь экран
        ncurses_border(0, 0, 0, 0, 0, 0, 0, 0);// рисуем рамку вокруг окна
        ncurses_refresh(); // рисуем окна
        parent::construction();
        $pressed = ncurses_getch(); // ждём нажатия клавиши
        ncurses_end(); // выходим из режима ncurses, чистим экран
    }
}

$output = new Output();
$left_window = $output->left_window();


