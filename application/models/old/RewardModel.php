<?php

namespace App\Models\old;
use DBModel;

defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH . './models/DBModel.php';

class RewardModel extends DBModel
{

    protected $table = 'user_reward';

}
