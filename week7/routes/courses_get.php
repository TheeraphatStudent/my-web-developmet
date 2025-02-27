<?php

$result = getCourses();

renderView('courses_get',[
    'courses' => $result
]);