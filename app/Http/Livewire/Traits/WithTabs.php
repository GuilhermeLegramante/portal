<?php

namespace App\Http\Livewire\Traits;


trait WithTabs
{
    public $activeTab = 1;

    public function setActiveTab($tab)
    {
        $this->activeTab = $tab;
    }
}
