<?php

/*
 * Copyright 2011 Piotr Śliwa <peter.pl7@gmail.com>
 *
 * License information is in LICENSE file
 */

namespace PHPPdf\Exception;

/**
 * @author Piotr Śliwa <peter.pl7@gmail.com>
 */
class UnregisteredNodeException extends Exception
{
    private $name;
    
    public function __construct($message, $name)
    {
        parent::__construct($message);
        $this->name = $name;
    }

    public static function nodeNotRegisteredException($name)
    {
        throw new self(sprintf('Node "%s" is not registered.', $name), $name);
    }
    
    public function getName()
    {
        return $this->name;
    }
}