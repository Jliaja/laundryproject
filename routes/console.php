<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('auto:cancel-pesanan')
    ->everyMinute();