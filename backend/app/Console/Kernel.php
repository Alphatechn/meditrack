<?php

namespace App\Console;

use App\Mail\Rappel_RdvMail;
use App\Models\Patient;
use App\Models\Rendez_vous;
use App\Models\User;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Mail;
class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->call(function () {
            $rendez_vous = Rendez_vous::where('status', 'Confirmé')
                ->where('date_r', '>', now())
                ->get(); // Récupère uniquement les rendez-vous "actifs" et à venir

            foreach ($rendez_vous as $rv) {
                $dateRendezVous = $rv->date_r;
                $datePrevue = $dateRendezVous->subDays(3); // Calcule la date 3 jours avant le rendez-vous

                if ($datePrevue->format('Y-m-d') == now()->format('Y-m-d')) {
                    $pat= Patient::where('id',$rv->id_pat)->first();
                    $usersp = User::where('id',$pat['id_user'])->first();
                    // Envoi de l'email de rappel ici
                    $password=[
                        'date' => $rv->date_r,
                    ];
                    Mail::to($usersp['email'])
                        ->send(new Rappel_RdvMail($password));
                }
            }
        })->timezone('Africa/Douala')->at('04:59')->daily();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
