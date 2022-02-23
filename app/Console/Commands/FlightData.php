<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Flight;

class FlightData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'flight:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This will update the flight information';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $queryString = http_build_query([
            'api_key' => config('services.key.api'),
            'arr_iata' => 'KBP'
            ]);

            $ch = curl_init(sprintf('%s?%s', 'https://airlabs.co/api/v9/flights', $queryString));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $json = curl_exec($ch);
            curl_close($ch);

            $apiResults = json_decode($json, true);
            // dd($apiResults['response']);

            foreach ($apiResults['response'] as $result) {
                $flightData = new Flight();
                $flightData->flag = $result['flag'];
                $flightData->departure_iata = $result['dep_iata'];
                $flightData->arrival_iata = $result['arr_iata'];
                $flightData->airlane_iata = $result['airline_iata'];
                $flightData->latitude = $result['lat'];
                $flightData->longtitude = $result['lng'];
                $flightData->altitude = $result['alt'];
                $flightData->speed = $result['speed'];
                $flightData->save();
            }
    }
}
