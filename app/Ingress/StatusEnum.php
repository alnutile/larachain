<?php

namespace App\Ingress;

enum StatusEnum: string
{
    case Pending = "pending";
    case Running = "running";
    case Complete = "complete";
    case Failed = "failed";
}
