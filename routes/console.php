<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('pdf-tools:cleanup')->hourly();
