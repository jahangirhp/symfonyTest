<?php

namespace App\Message;

class EmailNotification
{
  public function __construct(
        public string $content
    ) {}
}
