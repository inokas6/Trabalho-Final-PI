<?php

function isVarSet($var) {
    return !empty($var) && isset($var);
}