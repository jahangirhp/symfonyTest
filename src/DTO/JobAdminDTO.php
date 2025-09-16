<?php

namespace App\DTO;

use App\Entity\JobTask;
use App\Entity\Product;
use App\Entity\User;

class JobAdminDTO
{
    public JobTask $jobTask;
    public User $user;
    public function __construct( User $user,JobTask $jobTask)
    {
        $this->user = $user;
        $this->jobTask = $jobTask;
    }

}


