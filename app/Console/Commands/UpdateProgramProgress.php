<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Program;
use Illuminate\Console\Command;

class UpdateProgramProgress extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    // protected $signature = 'app:update-program-progress';
    protected $signature = 'programs:update-progress';
    

    /**
     * The console command description.
     *
     * @var string
     */
    // protected $description = 'Command description';
    protected $description = 'Update program progress based on date and time';
    /**
     * Execute the console command.
     */
     public function handle()
    {
        $now = Carbon::now();

        // Fetch all programs
        $programs = Program::all();

        foreach ($programs as $program) {
            $programDate = Carbon::parse($program->date);
            $programDateOnly = Carbon::parse($program->date)->format('Y-m-d');

            $startDateTime = Carbon::parse($programDateOnly . ' ' . $program->start_time);
            $endDateTime = Carbon::parse($programDateOnly . ' ' . $program->end_time);

            if ($now->lt($startDateTime)) {
                $progress = 'incoming';
            } elseif ($now->between($startDateTime, $endDateTime)) {
                $progress = 'ongoing';
            } else {
                $progress = 'done';
            }

            if ($program->progress !== $progress) {
                $program->progress = $progress;
                $program->save();
                $this->info("Program '{$program->title}' updated to progress: {$progress}");
            }
        }

        return 0;
    }
}
