<?php


namespace vloop\user\entities\common;


abstract class IteratorAbstract implements \Iterator
{
    private $position = 0;

     /**
      * Move forward to next element
      * @link https://php.net/manual/en/iterator.next.php
      * @return void Any returned value is ignored.
      * @since 5.0.0
      */
     public function next()
     {
         $this->position++;
     }

     /**
      * Return the key of the current element
      * @link https://php.net/manual/en/iterator.key.php
      * @return mixed scalar on success, or null on failure.
      * @since 5.0.0
      */
     public function key()
     {
         return $this->position;
     }

     /**
      * Rewind the Iterator to the first element
      * @link https://php.net/manual/en/iterator.rewind.php
      * @return void Any returned value is ignored.
      * @since 5.0.0
      */
     public function rewind()
     {
         $this->position = 0;
     }
 }