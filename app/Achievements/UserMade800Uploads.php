<?php

namespace App\Achievements;

use Gstt\Achievements\Achievement;

class UserMade800Uploads extends Achievement
{
    /*
     * The achievement name
     */
    public $name = "800 Uploads";

    /*
     * A small description for the achievement
     */
    public $description = "Completou 800 Uploads";

    /*
     * The amount of points required to unlock this achievement.
     */
    public $points = 800;

    /*
     * Triggers whenever an Achiever unlocks this achievement
    */
    public function whenUnlocked($progress)
    {
        return auth()->user()->updatePoints($this->points);
    }

}
