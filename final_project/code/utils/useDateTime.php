<?php

function ageCalculator ($birth) {
    return (new DateTime())->diff(new DateTime($birth))->y;

}