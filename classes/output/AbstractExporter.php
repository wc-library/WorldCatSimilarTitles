<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 *
 * @author bgarcia
 */
namespace output;
abstract class AbstractExporter {
    public abstract function getFrom($format, array $IDs);
}
