<?php
//функция возврата отформатированной даты на русском языке
function getRussianDate ($engDate) {
        
    $monthsRus = ["January" => "января", "February" => "февраля", "March" => "марта", 
    "April" => "апреля", "May" => "мая", "June" => "июня", "July" => "июля", "August" => "августа", 
    "September" => "сентября", "October" => "октября", "November" => "ноября", "December" => "декабря"];

        $temp = explode(",", $engDate);        
        $day = explode(" ", $temp[0]);      
        $month = $day[1];
       
        return $day[0] . " " . $monthsRus[$day[1]] . " " . $day[2] . " г., " . $temp[1];
    }

