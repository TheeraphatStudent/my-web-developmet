<?php

function ageCalculator ($birth) {
    return (new DateTime())->diff(new DateTime($birth))->y;

}

function dateFormat ($date) {
    return date('d M Y, H:i', strtotime($date));

}