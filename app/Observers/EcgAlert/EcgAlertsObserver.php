<?php

namespace App\Observers\EcgAlert;


use App\Models\EcgAlert\EcgAlertsModel;

class EcgAlertsObserver
{
    public function updated(EcgAlertsModel $ecgAlertsModel): void
    {
        $ecgAlertsModel->updateAction();
    }
}
