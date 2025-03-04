<?php

function getRandomId(int $length) {
    return bin2hex(random_bytes($length));

};